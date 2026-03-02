<x-admin.layout>

    <h2>Orders</h2>

    <form method="GET" action="{{ route('admin.orders.index') }}"
        style="background:#fff;padding:12px;border:1px solid #ddd;margin-bottom:12px;">
        <div style="display:flex; gap:10px; flex-wrap:wrap;">
            <select name="payment_method">
                <option value="">Payment Method (All)</option>
                <option value="cod" {{ request('payment_method') === 'cod' ? 'selected' : '' }}>COD</option>
                <option value="online_manual" {{ request('payment_method') === 'online_manual' ? 'selected' : '' }}>Online
                    Manual</option>
            </select>

            <select name="payment_status">
                <option value="">Payment Status (All)</option>
                <option value="unpaid" {{ request('payment_status') === 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                <option value="pending_verification"
                    {{ request('payment_status') === 'pending_verification' ? 'selected' : '' }}>Pending Verification
                </option>
                <option value="paid" {{ request('payment_status') === 'paid' ? 'selected' : '' }}>Paid</option>
            </select>

            <select name="delivery_status">
                <option value="">Delivery Status (All)</option>
                <option value="pending" {{ request('delivery_status') === 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="done" {{ request('delivery_status') === 'done' ? 'selected' : '' }}>Done</option>
            </select>

            <button type="submit">Filter</button>
            <a href="{{ route('admin.orders.index') }}">Reset</a>
        </div>
    </form>

    <div style="background:#fff;padding:12px;border:1px solid #ddd;">
        <table class="table" style="width:100%; border-collapse:collapse;">
            <thead>
                <tr style="text-align:left;">
                    <th>Order#</th>
                    <th>Customer</th>
                    <th>Method</th>
                    <th>Payment</th>
                    <th>Delivery</th>
                    <th>Total</th>
                    <th>Date</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                    <tr style="border-top:1px solid #eee;">
                        <td>{{ $order->order_number }}</td>
                        <td>{{ $order->customer_name }}<br><small>{{ $order->customer_phone }}</small></td>
                        <td>{{ strtoupper($order->payment_method) }}</td>
                        <td>{{ $order->payment_status }}</td>
                        <td>{{ $order->delivery_status }}</td>
                        <td>{{ $order->grand_total }}</td>
                        <td>{{ $order->created_at->format('d M Y') }}</td>
                        <td>
                            <a href="{{ route('admin.orders.show', $order->id) }}">View</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" style="text-align:center;padding:20px;">No orders found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div style="margin-top:12px;">
            {{ $orders->links() }}
        </div>
    </div>
</x-admin.layout>
