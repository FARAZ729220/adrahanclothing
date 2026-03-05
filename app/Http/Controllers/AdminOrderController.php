<?php

namespace App\Http\Controllers;

use App\Mail\OrderCancelledMail;
use App\Mail\OrderDeliveredMail;
use App\Mail\OrderPaymentUpdatedMail;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class AdminOrderController extends Controller
{
    public function index()
    {
        $orders = Order::latest()->get();

        return view('admin.orders.order', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::with('items')->findOrFail($id);

        return view('admin.orders.show', compact('order'));
    }

    public function updatePaymentStatus(Request $request, $id)
    {
        $validated = $request->validate([
            'payment_status' => ['required', 'in:unpaid,pending_verification,paid'],
        ]);

        $order = Order::findOrFail($id);

        // ❌ If cancelled, block updates
        if ($order->order_status === 'cancelled') {
            return back()->withErrors('Cancelled order status cannot be updated.');
        }

        // ❌ Don’t allow downgrade from paid
        if ($order->payment_status === 'paid' && $validated['payment_status'] !== 'paid') {
            return back()->withErrors('Paid status cannot be downgraded.');
        }

        $order->payment_status = $validated['payment_status'];
        $order->save();

        // ✅ send mail to customer only (if email exists)
        if (! empty($order->customer_email)) {
            try {
                Mail::to($order->customer_email)->queue(new OrderPaymentUpdatedMail($order));
            } catch (\Throwable $e) {
                // optional: \Log::error($e->getMessage());
            }
        }

        return back()->with('success', 'Payment status updated.');
    }

    public function updateDeliveryStatus(Request $request, $id)
    {
        $validated = $request->validate([
            'delivery_status' => ['required', 'in:pending,done'],
        ]);

        $order = Order::findOrFail($id);

        // ❌ If cancelled, block updates
        if ($order->order_status === 'cancelled') {
            return back()->withErrors('Cancelled order status cannot be updated.');
        }

        // ❌ Don’t allow downgrade from done
        if ($order->delivery_status === 'done' && $validated['delivery_status'] !== 'done') {
            return back()->withErrors('Delivered status cannot be reverted.');
        }

        $order->delivery_status = $validated['delivery_status'];

        // ✅ COD delivered => mark paid
        if ($validated['delivery_status'] === 'done' && $order->payment_method === 'cod') {
            $order->payment_status = 'paid';
        }

        $order->save();

        // ✅ Send delivered email
        if ($validated['delivery_status'] === 'done' && ! empty($order->customer_email)) {
            try {
                Mail::to($order->customer_email)->queue(new OrderDeliveredMail($order));
            } catch (\Throwable $e) {
                // optional log
            }
        }

        return back()->with('success', 'Delivery status updated.');
    }

    public function cancel($id)
    {
        DB::beginTransaction();

        try {
            $order = Order::with('items')->lockForUpdate()->findOrFail($id);

            // ✅ Already cancelled? no double restore
            if ($order->order_status === 'cancelled') {
                DB::rollBack();

                return back()->with('success', 'Order is already cancelled.');
            }

            // ✅ Do not allow cancel if delivered
            if ($order->delivery_status === 'done') {
                DB::rollBack();

                return back()->withErrors('Delivered orders cannot be cancelled.');
            }

            // ✅ Restore stock for each item
            foreach ($order->items as $item) {

                $product = Product::where('id', $item->product_id)
                    ->lockForUpdate()
                    ->first();

                // If product deleted, skip safely
                if (! $product) {
                    continue;
                }

                $product->stock += (int) $item->quantity;

                // ✅ If stock back, make product visible again
                if ($product->stock > 0) {
                    $product->is_active = true;
                }

                $product->save();
            }

            // ✅ Mark order cancelled
            $order->order_status = 'cancelled';
            $order->cancelled_at = now();
            $order->save();

            DB::commit();

            // ✅ send cancel email to customer
            if (! empty($order->customer_email)) {
                try {
                    Mail::to($order->customer_email)->queue(new OrderCancelledMail($order));
                } catch (\Throwable $e) {
                    // optional: \Log::error($e->getMessage());
                }
            }

            return back()->with('success', 'Order cancelled and stock restored.');

        } catch (\Exception $e) {
            DB::rollBack();

            return back()->withErrors($e->getMessage());
        }
    }
}
