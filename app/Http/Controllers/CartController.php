<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session('cart', []);
        $cartItems = collect($cart);

        $subtotal = $cartItems->sum(fn ($item) => ((float) $item['price']) * ((int) $item['qty']));

        $shipping = $this->getShippingFee($cart);

        $total = $subtotal + $shipping;

        return view('cart', compact('cartItems', 'subtotal', 'shipping', 'total'));
    }

    public function add(Request $request)
    {
        $isAjax = $request->ajax() || $request->wantsJson();

        // ✅ Validate input (qty optional, default 1)
        try {
            $request->validate([
                'product_id' => ['required', 'integer'],
                'size' => ['required', 'string'],
                'qty' => ['nullable', 'integer', 'min:1'],
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($isAjax) {
                return response()->json([
                    'ok' => false,
                    'message' => 'Please select a size.',
                    'errors' => $e->errors(),
                ], 422);
            }
            throw $e;
        }

        $qty = (int) ($request->qty ?? 1); // ✅ default 1

        $product = Product::findOrFail($request->product_id);

        // ✅ validate size exists in product sizes
        $sizes = is_array($product->sizes) ? $product->sizes : [];
        if (! in_array($request->size, $sizes)) {
            if ($isAjax) {
                return response()->json(['ok' => false, 'message' => 'Invalid size selected.'], 422);
            }

            return back()->with('error', 'Invalid size selected.');
        }

        // ✅ stock check
        if ((int) $product->stock <= 0) {
            if ($isAjax) {
                return response()->json(['ok' => false, 'message' => 'This product is out of stock.'], 422);
            }

            return back()->with('error', 'This product is out of stock.');
        }

        // ✅ price with discount
        $originalPrice = (float) ($product->price ?? 0);
        $finalPrice = $originalPrice;

        if ($product->discount_type === 'percent' && (float) $product->discount_value > 0) {
            $finalPrice = $originalPrice - ($originalPrice * (float) $product->discount_value) / 100;
        } elseif ($product->discount_type === 'fixed' && (float) $product->discount_value > 0) {
            $finalPrice = $originalPrice - (float) $product->discount_value;
        }

        $finalPrice = max(0, $finalPrice);

        $img = (is_array($product->images) && count($product->images) > 0) ? $product->images[0] : null;

        $cart = session()->get('cart', []);

        // ✅ unique key: product + size
        $key = $product->id.'_'.$request->size;

        if (isset($cart[$key])) {
            $newQty = (int) $cart[$key]['qty'] + $qty;

            if ($newQty > (int) $product->stock) {
                $msg = 'Stock limit reached. Only '.$product->stock.' available.';
                if ($isAjax) {
                    return response()->json(['ok' => false, 'message' => $msg], 422);
                }

                return back()->with('error', $msg);
            }

            $cart[$key]['qty'] = $newQty;
        } else {
            if ($qty > (int) $product->stock) {
                $msg = 'Stock limit reached. Only '.$product->stock.' available.';
                if ($isAjax) {
                    return response()->json(['ok' => false, 'message' => $msg], 422);
                }

                return back()->with('error', $msg);
            }

            $cart[$key] = [
                'key' => $key,
                'product_id' => $product->id,
                'name' => $product->name,
                'slug' => $product->slug,
                'size' => $request->size,
                'price' => $finalPrice, // final price stored
                'img' => $img,
                'qty' => $qty,
                'stock' => (int) $product->stock,
            ];
        }

        session()->put('cart', $cart);

        $cartCount = count($cart);

        if ($isAjax) {
            return response()->json([
                'ok' => true,
                'message' => $product->name.' added to cart.',
                'cart_count' => count($cart),
                'itemKey' => $key,
            ]);
        }

        return back()->with('success', $product->name.' added to cart.');
    }

    public function update(Request $request)
    {
        $request->validate([
            'key' => ['required', 'string'],
            'qty' => ['required', 'integer', 'min:0'],
        ]);

        $cart = session()->get('cart', []);

        $key = $request->key;
        $qty = (int) $request->qty;

        if (! isset($cart[$key])) {
            return response()->json([
                'success' => false,
                'message' => 'Cart item not found.',
            ], 404);
        }

        // Stock check
        $stock = (int) ($cart[$key]['stock'] ?? 0);

        if ($qty > $stock) {
            return response()->json([
                'success' => false,
                'message' => "Stock limit reached. Only {$stock} available.",
            ], 422);
        }

        // Qty 0 => auto remove
        if ($qty === 0) {
            unset($cart[$key]);
            session()->put('cart', $cart);

            return $this->cartJsonResponse([
                'removed_key' => $key,
                'message' => 'Item removed.',
            ]);
        }

        $cart[$key]['qty'] = $qty;
        session()->put('cart', $cart);

        $price = (float) $cart[$key]['price']; // already discounted/final
        $lineTotal = $price * $qty;

        return $this->cartJsonResponse([
            'updated_key' => $key,
            'qty' => $qty,
            'line_total' => $lineTotal,
            'message' => 'Cart updated.',
        ]);
    }

    public function remove(Request $request)
    {
        $request->validate([
            'key' => ['required', 'string'],
        ]);

        $cart = session()->get('cart', []);
        $key = $request->key;

        if (! isset($cart[$key])) {
            return response()->json([
                'success' => false,
                'message' => 'Cart item not found.',
            ], 404);
        }

        unset($cart[$key]);
        session()->put('cart', $cart);

        return $this->cartJsonResponse([
            'removed_key' => $key,
            'message' => 'Item removed.',
        ]);
    }

    /**
     * Common cart response
     */
    private function cartJsonResponse(array $extra = [])
    {
        $cart = session()->get('cart', []);

        $subtotal = collect($cart)->sum(fn ($item) => ((float) $item['price']) * ((int) $item['qty']));

        $shipping = (int) session('shipping_fee', 200);
        if (count($cart) === 0) {
            $shipping = 0;
        }

        $total = $subtotal + $shipping;

        return response()->json(array_merge([
            'success' => true,
            'cart_count' => count($cart), // ✅ key matches JS
            'subtotal' => (int) round($subtotal),
            'shipping' => $shipping,
            'total' => (int) round($total),
            'is_empty' => count($cart) === 0,
        ], $extra));
    }

    private function getShippingFee(array $cart): int
    {
        if (count($cart) === 0) {
            return 0;
        }

        return (int) session('shipping_fee', 200);
    }
}
