<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    public function list(Request $request)
    {
        $q = Order::query()->latest();

        // optional filters
        if ($request->filled('payment_status')) {
            $q->where('payment_status', $request->payment_status);
        }
        if ($request->filled('delivery_status')) {
            $q->where('delivery_status', $request->delivery_status);
        }
        if ($request->filled('payment_method')) {
            $q->where('payment_method', $request->payment_method);
        }

        return response()->json($q->paginate(20));
    }

    public function detail($id)
    {
        $order = Order::with('items')->findOrFail($id);
        return response()->json($order);
    }

    public function updatePaymentStatus(Request $request, $id)
    {
        $data = $request->validate([
            'payment_status' => ['required','in:unpaid,pending_verification,paid']
        ]);

        $order = Order::findOrFail($id);
        $order->payment_status = $data['payment_status'];
        $order->save();

        return response()->json(['message'=>'Payment status updated']);
    }

    public function markDelivered($id)
    {
        $order = Order::findOrFail($id);
        $order->delivery_status = 'done';
        $order->save();

        return response()->json(['message'=>'Order marked delivered']);
    }
}
