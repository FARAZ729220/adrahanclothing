<x-admin.layout>


    <div class="container mt-4">

        <h3>Order #{{ $order->order_number }}</h3>

        <div class="card p-3 mb-3">
            <h5>Customer Information</h5>
            <p><strong>Name:</strong> {{ $order->customer_name }}</p>
            <p><strong>Phone:</strong> {{ $order->customer_phone }}</p>
            <p><strong>Email:</strong> {{ $order->customer_email ?? '-' }}</p>
            <p><strong>Address:</strong> {{ $order->shipping_address }}</p>
        </div>

        <div class="card p-3 mb-3">
            <h5>Order Information</h5>
            <p><strong>Payment Method:</strong> {{ strtoupper($order->payment_method) }}</p>
            <p><strong>Payment Status:</strong> {{ $order->payment_status }}</p>
            <p><strong>Delivery Status:</strong> {{ $order->delivery_status }}</p>
            <p><strong>Date:</strong> {{ $order->created_at->format('d M Y H:i') }}</p>
        </div>

        <div class="card p-3 mb-3">
            <h5>Admin Controls</h5>

            @if ($order->order_status === 'cancelled')
                <div class="alert alert-warning mb-0">
                    This order is cancelled. Status updates are disabled.
                </div>
            @else
                <!-- Payment Status -->
                <form method="POST" action="{{ route('admin.orders.paymentStatus', $order->id) }}" class="mb-3">
                    @csrf
                    <label class="form-label"><strong>Payment Status</strong></label>
                    <select name="payment_status" class="form-select">
                        <option value="unpaid" {{ $order->payment_status === 'unpaid' ? 'selected' : '' }}>Unpaid
                        </option>
                        <option value="pending_verification"
                            {{ $order->payment_status === 'pending_verification' ? 'selected' : '' }}>
                            Pending Verification
                        </option>
                        <option value="paid" {{ $order->payment_status === 'paid' ? 'selected' : '' }}>Paid</option>
                    </select>
                    <button class="btn btn-primary mt-2">Update Payment</button>
                </form>

                <!-- Delivery Status -->
                <form method="POST" action="{{ route('admin.orders.deliveryStatus', $order->id) }}" class="mb-3">
                    @csrf
                    <label class="form-label"><strong>Delivery Status</strong></label>
                    <select name="delivery_status" class="form-select">
                        <option value="pending" {{ $order->delivery_status === 'pending' ? 'selected' : '' }}>Pending
                        </option>
                        <option value="done" {{ $order->delivery_status === 'done' ? 'selected' : '' }}>Done</option>
                    </select>
                    <button class="btn btn-success mt-2">Update Delivery</button>
                </form>

                <!-- Cancel Order -->
                @if ($order->delivery_status !== 'done')
                    <form method="POST" action="{{ route('admin.orders.cancel', $order->id) }}"
                        onsubmit="return confirm('Cancel this order? Stock will be restored.');">
                        @csrf
                        <button class="btn btn-danger">Cancel Order</button>
                    </form>
                @else
                    <div class="alert alert-info mb-0">
                        Order is delivered. Cancellation disabled.
                    </div>
                @endif

            @endif
        </div>

        @if ($order->payment_method === 'online_manual')
            <div class="card p-3 mb-3">
                <h5>Payment Proof</h5>

                @if ($order->payment_proof_path)
                    <a href="{{ asset('storage/' . $order->payment_proof_path) }}" target="_blank">
                        <img src="{{ asset('storage/' . $order->payment_proof_path) }}"
                            style="width:200px; border:1px solid #ddd;">
                    </a>
                @else
                    <p>No proof uploaded.</p>
                @endif

                <p><strong>Reference:</strong> {{ $order->payment_reference_note ?? '-' }}</p>
            </div>
        @endif

        <div class="card p-3 mb-3">
            <h5>Order Items</h5>

            <table class="table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Size</th>
                        <th>Unit Price</th>
                        <th>Qty</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->items as $item)
                        <tr>
                            <td>{{ $item->product_name }}</td>
                            <td>{{ $item->size ?? '-' }}</td>
                            <td>Rs {{ $item->unit_price }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>Rs {{ $item->line_total }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <hr>

            <p><strong>Subtotal:</strong> Rs {{ $order->subtotal }}</p>
            <p><strong>Discount:</strong> Rs {{ $order->discount_total }}</p>
            <h5><strong>Grand Total: Rs {{ $order->grand_total }}</strong></h5>
        </div>

        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
            Back to Dashboard
        </a>

    </div>
</x-admin.layout>
