<x-admin.layout>
    <main class="flex-grow-1 p-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="text-white fw-black m-0">Orders</h2>
        </div>

        <div class="table-responsive">
            <table class="table table-dark custom-admin-table align-middle" id="order-table">
                <thead>
                    <tr>
                        <th class="text-secondary small fw-bold border-0">Order ID</th>
                        <th class="text-secondary small fw-bold border-0">Customer</th>
                        <th class="text-secondary small fw-bold border-0">Date</th>
                        <th class="text-secondary small fw-bold border-0">Total</th>
                        <th class="text-secondary small fw-bold border-0">Status</th>
                        <th class="text-secondary small fw-bold border-0">View Order Detail</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                        <tr>
                            <td>{{ $order->order_number }}</td>
                            <td>{{ $order->customer_name }} <br>
                                <small>{{ $order->customer_phone }}</small>
                            </td>
                            <td class="text-secondary">{{ $order->created_at->format('d M Y') }}</td>
                            <td class="fw-bold">Rs {{ $order->grand_total }}</td>
                            <td>
                                @if ($order->order_status === 'cancelled')
                                    <span class="badge status-cancelled">Cancelled</span>
                                @elseif($order->delivery_status === 'done')
                                    <span class="badge status-delivered">Delivered</span>
                                @elseif($order->payment_status === 'pending_verification')
                                    <span class="badge status-pending">Pending Verification</span>
                                @else
                                    <span class="badge status-pending">Pending</span>
                                @endif
                            </td>

                            <td><a href="{{ route('admin.orders.show', $order->id) }}"><i class="bi bi-eye-fill"></i></a></td>
                        </tr>
                    @empty
                        <p>No Order at the moment</p>
                    @endforelse

                </tbody>
            </table>
        </div>
    </main>

</x-admin.layout>

<script>
   $(document).ready(function() {
        $('#order-table').DataTable({
            pageLength: 10,
            ordering: true,
            responsive: true,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search orders..."
            }
        });
    });
</script>
