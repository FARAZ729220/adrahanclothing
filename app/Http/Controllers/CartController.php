<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function get() {
        return response()->json(['cart' => session()->get('cart', [])]);
    }

    public function add(Request $request)
    {
        $data = $request->validate([
            'product_id' => ['required','integer','exists:products,id'],
            'size' => ['nullable','string','max:10'],
            'quantity' => ['required','integer','min:1'],
        ]);

        $product = Product::visible()->findOrFail($data['product_id']);

        // validate size
        if (is_array($product->sizes) && count($product->sizes)) {
            if (empty($data['size']) || !in_array($data['size'], $product->sizes)) {
                return response()->json(['message'=>'Invalid size'], 422);
            }
        }

        $size = $data['size'] ?? '';
        $key = $product->id . ':' . $size;

        $cart = session()->get('cart', []);
        $existing = $cart[$key]['quantity'] ?? 0;
        $newQty = $existing + $data['quantity'];

        if ($newQty > $product->stock) {
            return response()->json(['message'=>'Quantity exceeds stock'], 422);
        }

        $cart[$key] = [
            'key' => $key,
            'product_id' => $product->id,
            'name' => $product->name,
            'size' => $data['size'] ?? null,
            'quantity' => $newQty,
            'unit_price' => $product->finalPrice(),
            'image' => $product->images[0] ?? null,
        ];

        session()->put('cart', $cart);
        return response()->json(['message'=>'Added', 'cart'=>$cart]);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'key' => ['required','string'],
            'quantity' => ['required','integer','min:1'],
        ]);

        $cart = session()->get('cart', []);
        if (!isset($cart[$data['key']])) {
            return response()->json(['message'=>'Item not found'], 404);
        }

        $item = $cart[$data['key']];
        $product = Product::visible()->findOrFail($item['product_id']);

        if ($data['quantity'] > $product->stock) {
            return response()->json(['message'=>'Quantity exceeds stock'], 422);
        }

        $cart[$data['key']]['quantity'] = $data['quantity'];
        $cart[$data['key']]['unit_price'] = $product->finalPrice(); // refresh

        session()->put('cart', $cart);
        return response()->json(['message'=>'Updated', 'cart'=>$cart]);
    }

    public function remove(Request $request)
    {
        $data = $request->validate(['key' => ['required','string']]);

        $cart = session()->get('cart', []);
        unset($cart[$data['key']]);
        session()->put('cart', $cart);

        return response()->json(['message'=>'Removed', 'cart'=>$cart]);
    }
}
