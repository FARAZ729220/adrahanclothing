<x-layout title="thankyou | Adrahan">

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

</x-layout>
