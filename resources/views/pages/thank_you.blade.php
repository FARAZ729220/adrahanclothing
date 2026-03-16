{{-- <x-layout title="thankyou | Adrahan">

     <section class="thank-you-section d-flex align-items-center justify-content-center bg-white">
    <div class="container text-center py-5">
        <div class="mb-4">
            <div class="success-icon-circle mx-auto d-flex align-items-center justify-content-center">
                <i class="bi bi-check2-circle"></i>
            </div>
        </div>

        <h1 class="display-4 fw-bold section-title mb-3">Thank You!</h1>
        <p class="text-muted lead mb-5 mx-auto" style="max-width: 500px;">
            Your order has been placed successfully. We'll deliver it to you soon!
        </p>

        <a href="{{ route('shop') }}" class="btn btn-dark rounded-0 px-5 py-3 fw-bold text-uppercase ls-1">
            Continue Shopping
        </a>
    </div>
</section>

</x-layout> --}}
<x-layout title="thankyou | Adrahan">

    @php
        $pixelContentIds = collect($order->items ?? [])
            ->map(function ($item) {
                return (string) ($item->product_id ?? ($item->id ?? $item->name));
            })
            ->values();

        $pixelContents = collect($order->items ?? [])
            ->map(function ($item) {
                return [
                    'id' => (string) ($item->product_id ?? ($item->id ?? $item->name)),
                    'quantity' => (int) ($item->qty ?? 1),
                    'item_price' => (float) ($item->price ?? 0),
                ];
            })
            ->values();

        $pixelNumItems = collect($order->items ?? [])->sum(function ($item) {
            return (int) ($item->qty ?? 1);
        });
    @endphp

    <section class="thank-you-section d-flex align-items-center justify-content-center bg-white">
        <div class="container text-center py-5">
            <div class="mb-4">
                <div class="success-icon-circle mx-auto d-flex align-items-center justify-content-center">
                    <i class="bi bi-check2-circle"></i>
                </div>
            </div>

            <h1 class="display-4 fw-bold section-title mb-3">Thank You!</h1>
            <p class="text-muted lead mb-2 mx-auto" style="max-width: 500px;">
                Your order has been placed successfully. We'll deliver it to you soon!
            </p>

            <p class="text-muted small mb-5">
                Order Number: <span class="fw-bold text-dark">{{ $order->order_number }}</span>
            </p>

            <a href="{{ route('shop') }}" class="btn btn-dark rounded-0 px-5 py-3 fw-bold text-uppercase ls-1">
                Continue Shopping
            </a>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof fbq !== 'function') {
                console.log('[Pixel] fbq not available');
                return;
            }

            fbq('track', 'Purchase', {
                content_ids: @json($pixelContentIds),
                contents: @json($pixelContents),
                content_type: 'product',
                num_items: {{ (int) $pixelNumItems }},
                value: {{ json_encode((float) ($order->total ?? 0)) }},
                currency: 'PKR',
                order_id: @json($order->order_number)
            });
        });
    </script>

</x-layout>
