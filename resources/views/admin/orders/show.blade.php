<x-admin.layout>


    {{-- <div class="container mt-4">

        <h3 class="text-white">Order #{{ $order->order_number }}</h3>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
            Back to Dashboard
        </a>

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



    </div> --}}

    <div class="container-fluid py-4">

        {{-- Header --}}
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-4">
            <div>
                <h3 class="text-white fw-bold mb-1">Order #{{ $order->order_number }}</h3>
                <div class="text-secondary small">
                    Placed on {{ $order->created_at->format('d M Y, h:i A') }}
                </div>
            </div>

            <div class="d-flex gap-2">
                <a href="{{ route('admin.orders.index') }}" class="btn btn-light btn-sm px-3">
                    ← Back
                </a>

                @if ($order->order_status === 'cancelled')
                    <span class="badge rounded-pill bg-danger px-3 py-2">CANCELLED</span>
                @else
                    <span class="badge rounded-pill bg-success px-3 py-2 text-uppercase">
                        {{ $order->order_status }}
                    </span>
                @endif
            </div>
        </div>

        {{-- Main Grid --}}
        <div class="row g-4">

            {{-- Left Side --}}
            <div class="col-lg-8">

                {{-- Customer + Order Info --}}
                <div class="card glass-card mb-4">
                    <div class="card-body p-4">

                        <div class="row g-4">
                            {{-- Customer --}}
                            <div class="col-md-6">
                                <h6 class="text-white fw-bold mb-3">Customer</h6>

                                <div class="info-line">
                                    <span class="k">Name</span>
                                    <span class="v">{{ $order->customer_name }}</span>
                                </div>

                                <div class="info-line">
                                    <span class="k">Phone</span>
                                    <span class="v">{{ $order->customer_phone }}</span>
                                </div>

                                <div class="info-line">
                                    <span class="k">Email</span>
                                    <span class="v">{{ $order->customer_email ?? '-' }}</span>
                                </div>

                                <div class="mt-3">
                                    <div class="text-secondary small mb-1">Shipping Address</div>
                                    <div class="address-box">
                                        {{ $order->shipping_address }}
                                    </div>
                                </div>
                            </div>

                            {{-- Order --}}
                            <div class="col-md-6">
                                <h6 class="text-white fw-bold mb-3">Order Details</h6>

                                <div class="d-flex flex-wrap gap-2 mb-3">
                                    <span class="badge bg-dark border border-secondary">
                                        Payment: {{ strtoupper($order->payment_method) }}
                                    </span>

                                    <span
                                        class="badge {{ $order->payment_status === 'paid' ? 'bg-success' : ($order->payment_status === 'pending_verification' ? 'bg-warning text-dark' : 'bg-danger') }}">
                                        {{ strtoupper(str_replace('_', ' ', $order->payment_status)) }}
                                    </span>

                                    <span
                                        class="badge {{ $order->delivery_status === 'done' ? 'bg-success' : 'bg-info text-dark' }}">
                                        Delivery: {{ strtoupper($order->delivery_status) }}
                                    </span>
                                </div>

                                <div class="summary-box">
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="text-secondary">Subtotal</span>
                                        <span class="text-white fw-bold">Rs
                                            {{ number_format($order->subtotal) }}</span>
                                    </div>

                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="text-secondary">Discount</span>
                                        <span class="text-white fw-bold">Rs
                                            {{ number_format($order->discount_total) }}</span>
                                    </div>

                                    <div class="d-flex justify-content-between pt-2 border-top border-secondary">
                                        <span class="text-secondary">Grand Total</span>
                                        <span class="text-white fw-bold fs-5">Rs
                                            {{ number_format($order->grand_total) }}</span>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>

                {{-- Items --}}
                <div class="card glass-card">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h6 class="text-white fw-bold m-0">Order Items</h6>
                            <span class="text-secondary small">
                                {{ $order->items->count() }} item(s)
                            </span>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-dark table-borderless align-middle mb-0">
                                <thead>
                                    <tr class="text-secondary small">
                                        <th>Product</th>
                                        <th class="text-center">Size</th>
                                        <th class="text-center">Qty</th>
                                        <th class="text-end">Unit</th>
                                        <th class="text-end">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($order->items as $item)
                                        <tr class="item-row">
                                            <td class="text-white fw-semibold">{{ $item->product_name }}</td>
                                            <td class="text-center text-light">{{ $item->size ?? '-' }}</td>
                                            <td class="text-center text-light">{{ $item->quantity }}</td>
                                            <td class="text-end text-light">Rs {{ number_format($item->unit_price) }}
                                            </td>
                                            <td class="text-end text-white fw-bold">Rs
                                                {{ number_format($item->line_total) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>

            </div>

            {{-- Right Side --}}
            <div class="col-lg-4">

                {{-- Admin Controls --}}
                <div class="card glass-card mb-4">
                    <div class="card-body p-4">
                        <h6 class="text-white fw-bold mb-3">Admin Controls</h6>

                        @if ($order->order_status === 'cancelled')
                            <div class="alert alert-warning mb-0">
                                This order is cancelled. Status updates are disabled.
                            </div>
                        @else
                            {{-- Payment --}}
                            <form method="POST" action="{{ route('admin.orders.paymentStatus', $order->id) }}"
                                class="mb-3">
                                @csrf
                                <label class="text-secondary small mb-2">Payment Status</label>
                                <select name="payment_status" class="form-select form-select-sm dark-select">
                                    <option value="unpaid" {{ $order->payment_status === 'unpaid' ? 'selected' : '' }}>
                                        Unpaid</option>
                                    <option value="pending_verification"
                                        {{ $order->payment_status === 'pending_verification' ? 'selected' : '' }}>
                                        Pending Verification</option>
                                    <option value="paid" {{ $order->payment_status === 'paid' ? 'selected' : '' }}>
                                        Paid</option>
                                </select>
                                <button class="btn btn-primary btn-sm w-100 mt-2">Update Payment</button>
                            </form>

                            {{-- Delivery --}}
                            <form method="POST" action="{{ route('admin.orders.deliveryStatus', $order->id) }}"
                                class="mb-3">
                                @csrf
                                <label class="text-secondary small mb-2">Delivery Status</label>
                                <select name="delivery_status" class="form-select form-select-sm dark-select">
                                    <option value="pending"
                                        {{ $order->delivery_status === 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="done" {{ $order->delivery_status === 'done' ? 'selected' : '' }}>
                                        Done</option>
                                </select>
                                <button class="btn btn-success btn-sm w-100 mt-2">Update Delivery</button>
                            </form>

                            {{-- Cancel --}}
                            @if ($order->delivery_status !== 'done')
                                <form method="POST" action="{{ route('admin.orders.cancel', $order->id) }}"
                                    onsubmit="return confirm('Cancel this order? Stock will be restored.');">
                                    @csrf
                                    <button class="btn btn-danger btn-sm w-100">Cancel Order</button>
                                </form>
                            @else
                                <div class="alert alert-info mb-0">
                                    Order is delivered. Cancellation disabled.
                                </div>
                            @endif

                        @endif
                    </div>
                </div>

                {{-- Payment Proof --}}
                @if ($order->payment_method === 'online_manual')
                    <div class="card glass-card">
                        <div class="card-body p-4">
                            <h6 class="text-white fw-bold mb-3">Payment Proof</h6>

                            @if ($order->payment_proof_path)
                                <a href="{{ asset('storage/' . $order->payment_proof_path) }}" target="_blank"
                                    class="d-block">
                                    <img src="{{ asset('storage/' . $order->payment_proof_path) }}" class="proof-img"
                                        alt="Payment Proof">
                                </a>
                            @else
                                <div class="text-secondary">No proof uploaded.</div>
                            @endif

                            <div class="mt-3">
                                <div class="text-secondary small mb-1">Reference Note</div>
                                <div class="text-white">{{ $order->payment_reference_note ?? '-' }}</div>
                            </div>
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </div>
</x-admin.layout>
