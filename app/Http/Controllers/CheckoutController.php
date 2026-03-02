<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CheckoutController extends Controller
{
    // public function placeOrder(Request $request)
    // {
    //     // Cart structure expected:
    //     // [
    //     //   ['product_id'=>1,'quantity'=>2,'size'=>'M'],
    //     //   ...
    //     // ]

    //     $cart = session()->get('cart', []);

    //     if (empty($cart)) {
    //         return back()->withErrors('Cart is empty.');
    //     }

    //     // Validate checkout fields
    //     $validated = $request->validate([
    //         'name' => ['required', 'string', 'max:100'],
    //         'email' => ['nullable', 'email', 'max:150'],
    //         'phone' => ['required', 'string', 'max:30'],
    //         'shipping_address' => ['required', 'string', 'max:500'],
    //         'payment_method' => ['required', 'in:cod,online_manual'],

    //         // Required only if online_manual
    //         'payment_proof' => [
    //             'required_if:payment_method,online_manual',
    //             'image',
    //             'mimes:jpg,jpeg,png,webp',
    //             'max:2048',
    //         ],

    //         'payment_reference_note' => [
    //             'nullable',
    //             'string',
    //             'max:255',
    //         ],
    //     ]);

    //     DB::beginTransaction();

    //     $paymentProofPath = null;

    //     try {

    //         // Upload proof (only for online_manual)
    //         if ($validated['payment_method'] === 'online_manual' && $request->hasFile('payment_proof')) {
    //             $paymentProofPath = $request->file('payment_proof')
    //                 ->store('payment_proofs', 'public');
    //         }

    //         $subtotal = 0;
    //         $discountTotal = 0;
    //         $grandTotal = 0;

    //         // Create order
    //         $order = Order::create([
    //             'customer_name' => $validated['name'],
    //             'customer_email' => $validated['email'] ?? null,
    //             'customer_phone' => $validated['phone'],
    //             'shipping_address' => $validated['shipping_address'],
    //             'payment_method' => $validated['payment_method'],
    //             'payment_status' => $validated['payment_method'] === 'cod'
    //                 ? 'unpaid'
    //                 : 'pending_verification',
    //             'delivery_status' => 'pending',
    //             'payment_proof_path' => $validated['payment_method'] === 'cod'
    //                 ? null
    //                 : $paymentProofPath,
    //             'payment_reference_note' => $validated['payment_reference_note'] ?? null,
    //             'subtotal' => 0,
    //             'discount_total' => 0,
    //             'grand_total' => 0,
    //         ]);

    //         $order->update([
    //             'order_number' => 'ORD-'.str_pad($order->id, 4, '0', STR_PAD_LEFT),
    //         ]);

    //         foreach ($cart as $item) {

    //             $qty = (int) ($item['quantity'] ?? 0);
    //             $size = $item['size'] ?? null;

    //             if ($qty < 1) {
    //                 throw new \Exception('Invalid quantity in cart.');
    //             }

    //             // Lock row to prevent overselling
    //             $product = Product::where('id', $item['product_id'])
    //                 ->lockForUpdate()
    //                 ->firstOrFail();

    //             if ($product->stock < $qty) {
    //                 throw new \Exception("Not enough stock for {$product->name}");
    //             }

    //             $unitPrice = (float) $product->price;
    //             $unitDiscount = 0;

    //             if ($product->discount_type === 'percent') {
    //                 $unitDiscount = ($unitPrice * (float) $product->discount_value) / 100;
    //             } elseif ($product->discount_type === 'fixed') {
    //                 $unitDiscount = (float) $product->discount_value;
    //             }

    //             $finalUnitPrice = max(0, $unitPrice - $unitDiscount);

    //             $lineSubtotal = $unitPrice * $qty;
    //             $lineDiscount = $unitDiscount * $qty;
    //             $lineTotal = $finalUnitPrice * $qty;

    //             $subtotal += $lineSubtotal;
    //             $discountTotal += $lineDiscount;
    //             $grandTotal += $lineTotal;

    //             // Save order item snapshot
    //             OrderItem::create([
    //                 'order_id' => $order->id,
    //                 'product_id' => $product->id,
    //                 'product_name' => $product->name,
    //                 'unit_price' => (int) round($finalUnitPrice),
    //                 'quantity' => $qty,
    //                 'size' => $size,
    //                 'line_total' => (int) round($lineTotal),
    //             ]);

    //             // Deduct stock
    //             $product->stock -= $qty;

    //             if ($product->stock <= 0) {
    //                 $product->stock = 0;
    //                 $product->is_active = false;
    //             }

    //             $product->save();
    //         }

    //         // Update order totals
    //         $order->update([
    //             'subtotal' => (int) round($subtotal),
    //             'discount_total' => (int) round($discountTotal),
    //             'grand_total' => (int) round($grandTotal),
    //         ]);

    //         DB::commit();

    //         session()->forget('cart');

    //         return redirect()->back()->with('success', 'Order placed successfully!');

    //     } catch (\Exception $e) {

    //         DB::rollBack();

    //         // Remove uploaded proof if transaction failed
    //         if ($paymentProofPath) {
    //             Storage::disk('public')->delete($paymentProofPath);
    //         }

    //         return back()->withErrors($e->getMessage());
    //     }
    // }

    public function placeOrder(Request $request)
    {
        // Cart from session (your structure: key => ['product_id','qty','size', ...])
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->back()->withErrors('Cart is empty.');
        }

        // ✅ Validate checkout fields
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['nullable', 'email', 'max:150'],
            'phone' => ['required', 'string', 'max:30'],
            'shipping_address' => ['required', 'string', 'max:500'],
            'payment_method' => ['required', 'in:cod,online_manual'],

            // Required only if online_manual
            'payment_proof' => [
                'required_if:payment_method,online_manual',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],

            'payment_reference_note' => ['nullable', 'string', 'max:255'],
        ]);

        $paymentProofPath = null;

        DB::beginTransaction();

        try {
            // ✅ upload proof if online_manual
            if ($validated['payment_method'] === 'online_manual' && $request->hasFile('payment_proof')) {
                $paymentProofPath = $request->file('payment_proof')->store('payment_proofs', 'public');
            }

            // ✅ Shipping (same logic as cart page)
            $shipping = (int) session('shipping_fee', 200);
            if (count($cart) === 0) {
                $shipping = 0;
            }

            // ✅ Create order (totals updated later)
            $order = Order::create([
                'customer_name' => $validated['name'],
                'customer_email' => $validated['email'] ?? null,
                'customer_phone' => $validated['phone'],
                'shipping_address' => $validated['shipping_address'],

                'payment_method' => $validated['payment_method'],
                'payment_status' => $validated['payment_method'] === 'cod'
                    ? 'unpaid'
                    : 'pending_verification',

                'delivery_status' => 'pending',

                'payment_proof_path' => $validated['payment_method'] === 'online_manual'
                    ? $paymentProofPath
                    : null,

                'payment_reference_note' => $validated['payment_reference_note'] ?? null,

                'subtotal' => 0,
                'discount_total' => 0,
                'grand_total' => 0,

                'order_status' => 'active',
                'cancelled_at' => null,
            ]);

            // ✅ order number
            $order->update([
                'order_number' => 'ORD-'.str_pad((string) $order->id, 6, '0', STR_PAD_LEFT),
            ]);

            $subtotal = 0;
            $discountTotal = 0;
            $itemsTotal = 0;

            // ✅ Loop session cart
            foreach ($cart as $cartItem) {

                $productId = (int) ($cartItem['product_id'] ?? 0);
                $qty = (int) ($cartItem['qty'] ?? 0);
                $size = $cartItem['size'] ?? null;

                if ($productId <= 0 || $qty < 1) {
                    throw new \Exception('Invalid cart item.');
                }

                // ✅ Lock product row to prevent overselling
                $product = Product::where('id', $productId)->lockForUpdate()->first();

                if (! $product) {
                    throw new \Exception("Product not found (ID: {$productId}).");
                }

                if (! $product->is_active || (int) $product->stock <= 0) {
                    throw new \Exception("{$product->name} is out of stock.");
                }

                if ((int) $product->stock < $qty) {
                    throw new \Exception("Not enough stock for {$product->name}. Only {$product->stock} left.");
                }

                // ✅ Validate size (optional but recommended)
                $sizes = is_array($product->sizes) ? $product->sizes : [];
                if ($size && ! in_array($size, $sizes, true)) {
                    throw new \Exception("Invalid size selected for {$product->name}.");
                }

                // ✅ Calculate pricing from DB (do NOT trust session price)
                $unitPrice = (float) $product->price;
                $unitDiscount = 0;

                if ($product->discount_type === 'percent' && (float) $product->discount_value > 0) {
                    $unitDiscount = ($unitPrice * (float) $product->discount_value) / 100;
                } elseif ($product->discount_type === 'fixed' && (float) $product->discount_value > 0) {
                    $unitDiscount = (float) $product->discount_value;
                }

                $finalUnitPrice = max(0, $unitPrice - $unitDiscount);

                $lineSubtotal = $unitPrice * $qty;
                $lineDiscount = $unitDiscount * $qty;
                $lineTotal = $finalUnitPrice * $qty;

                $subtotal += $lineSubtotal;
                $discountTotal += $lineDiscount;
                $itemsTotal += $lineTotal;

                // ✅ Save order item snapshot
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'unit_price' => (int) round($finalUnitPrice),
                    'quantity' => $qty,
                    'size' => $size,
                    'line_total' => (int) round($lineTotal),
                ]);

                // ✅ Deduct stock + hide if zero
                $product->stock = (int) $product->stock - $qty;

                if ((int) $product->stock <= 0) {
                    $product->stock = 0;
                    $product->is_active = false;
                }

                $product->save();
            }

            // ✅ Grand total includes shipping
            $grandTotal = $itemsTotal + $shipping;

            // ✅ Update order totals
            $order->update([
                'subtotal' => (int) round($subtotal),
                'discount_total' => (int) round($discountTotal),
                'grand_total' => (int) round($grandTotal),
            ]);

            DB::commit();

            // ✅ clear cart
            session()->forget('cart');

            // You can redirect to thank-you page later
            return redirect()->route('checkout.success', $order->order_number);

        } catch (\Exception $e) {

            DB::rollBack();

            // ✅ Delete proof image if uploaded but transaction failed
            if ($paymentProofPath) {
                Storage::disk('public')->delete($paymentProofPath);
            }

            return redirect()->back()->withErrors($e->getMessage())->withInput();
        }
    }

    public function showCheckout()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->withErrors('Cart is empty.');
        }

        $items = collect($cart)->values();

        $subtotal = $items->sum(fn ($i) => ((float) $i['price']) * ((int) $i['qty']));

        $shipping = (int) session('shipping_fee', 200);
        if ($items->count() === 0) {
            $shipping = 0;
        }

        $total = $subtotal + $shipping;

        // Manual payment account details (static for now)
        $account = [
            'title' => env('MANUAL_PAYMENT_TITLE', 'Adrahan Store'),
            'number' => env('MANUAL_PAYMENT_ACCOUNT', 'Easypaisa/JazzCash: 0300-1234567'),
            'note' => env('MANUAL_PAYMENT_NOTE', 'Payment send karke screenshot upload kar dein. Admin verification ke baad order confirm hoga.'),
        ];

        return view('checkout', compact('items', 'subtotal', 'shipping', 'total', 'account'));
    }


    public function success($order_number)
{
    $order = \App\Models\Order::with('items')
        ->where('order_number', $order_number)
        ->firstOrFail();

    return view('thank_you', compact('order'));
}
}
