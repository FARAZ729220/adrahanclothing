<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function placeOrder(Request $request)
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) return response()->json(['message'=>'Cart is empty'], 422);

        $data = $request->validate([
            'customer_name' => ['required','string','max:120'],
            'customer_email' => ['nullable','email','max:150'],
            'customer_phone' => ['required','string','max:30'],
            'shipping_address' => ['required','string','max:600'],

            'payment_method' => ['required','in:cod,online_manual'],
            'payment_proof' => ['nullable','image','max:4096'],
            'payment_reference_note' => ['nullable','string','max:200'],
        ]);

        if ($data['payment_method'] === 'online_manual' && !$request->hasFile('payment_proof')) {
            return response()->json(['message'=>'Payment proof required for online payment'], 422);
        }

        $order = DB::transaction(function () use ($cart, $data, $request) {

            $productIds = collect($cart)->pluck('product_id')->unique()->values()->all();

            $products = Product::whereIn('id', $productIds)
                ->lockForUpdate()
                ->get()
                ->keyBy('id');

            $subtotal = 0;
            $discountTotal = 0;

            // verify + compute totals
            foreach ($cart as $item) {
                $p = $products[$item['product_id']] ?? null;

                if (!$p || !$p->is_active || $p->stock <= 0) {
                    throw new \RuntimeException('Product not available');
                }
                if ($item['quantity'] > $p->stock) {
                    throw new \RuntimeException("Insufficient stock for {$p->name}");
                }

                $original = $p->price * $item['quantity'];
                $final = $p->finalPrice() * $item['quantity'];

                $subtotal += $original;
                $discountTotal += ($original - $final);
            }

            $grandTotal = max(0, $subtotal - $discountTotal);

            $orderNumber = 'ORD-' . strtoupper(Str::random(8));

            $proofPath = null;
            if ($data['payment_method'] === 'online_manual') {
                $proofPath = $request->file('payment_proof')->store("payment_proofs/{$orderNumber}", 'public');
            }

            $order = Order::create([
                'order_number' => $orderNumber,

                'customer_name' => $data['customer_name'],
                'customer_email' => $data['customer_email'] ?? null,
                'customer_phone' => $data['customer_phone'],
                'shipping_address' => $data['shipping_address'],

                'payment_method' => $data['payment_method'],
                'payment_status' => $data['payment_method'] === 'cod' ? 'unpaid' : 'pending_verification',
                'delivery_status' => 'pending',

                'payment_proof_path' => $proofPath,
                'payment_reference_note' => $data['payment_reference_note'] ?? null,

                'subtotal' => $subtotal,
                'discount_total' => $discountTotal,
                'grand_total' => $grandTotal,
            ]);

            // create order items + reduce stock
            foreach ($cart as $item) {
                $p = $products[$item['product_id']];
                $unit = $p->finalPrice();
                $line = $unit * $item['quantity'];

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $p->id,
                    'product_name' => $p->name,
                    'unit_price' => $unit,
                    'quantity' => $item['quantity'],
                    'size' => $item['size'] ?? null,
                    'line_total' => $line,
                ]);

                $p->stock = $p->stock - $item['quantity'];
                $p->save();
            }

            return $order;
        });

        session()->forget('cart');

        return response()->json([
            'message' => 'Order placed',
            'order_number' => $order->order_number,
        ]);
    }
}

