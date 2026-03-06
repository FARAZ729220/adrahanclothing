<x-layout title="Mission & Vision | Adrahan">

    {{-- HERO --}}
    <section class="bg-white" style="padding: 100px">
        <div class="container py-lg-4">

            <div class="d-flex align-items-center justify-content-between mb-4">
                <div>
                    <p class="text-uppercase small text-muted ls-2 mb-1">About Adrahan</p>
                    <h1 class="display-5 fw-bold section-title mb-0">Our Mission & Vision</h1>
                </div>

                
            </div>

            <p class="text-muted mb-0" style="max-width: 820px;">
                We design streetwear essentials built for everyday confidence — premium quality, clean aesthetics,
                and a brand experience that feels modern from product to checkout.
            </p>
        </div>
    </section>

    {{-- MISSION + VISION --}}
    <section class="py-5 bg-white">
        <div class="container">

            <div class="row g-4">

                {{-- Mission --}}
                <div class="col-lg-6">
                    <div class="border p-4 h-100">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <i class="bi bi-bullseye"></i>
                            <h2 class="h4 fw-bold mb-0">Our Mission</h2>
                        </div>

                        <p class="text-muted mb-0">
                            To create timeless, wearable streetwear that balances comfort, durability, and style —
                            while delivering a simple, premium shopping experience for every customer.
                        </p>

                        <hr class="my-4">

                        <ul class="list-unstyled mb-0">
                            <li class="d-flex gap-2 mb-2">
                                <i class="bi bi-check2 text-dark"></i>
                                <span class="text-muted">Design pieces that feel premium, look clean, and fit
                                    right.</span>
                            </li>
                            <li class="d-flex gap-2 mb-2">
                                <i class="bi bi-check2 text-dark"></i>
                                <span class="text-muted">Use quality-first production to ensure long-lasting
                                    wear.</span>
                            </li>
                            <li class="d-flex gap-2">
                                <i class="bi bi-check2 text-dark"></i>
                                <span class="text-muted">Make shopping simple — clear pricing, easy checkout, reliable
                                    delivery.</span>
                            </li>
                        </ul>
                    </div>
                </div>

                {{-- Vision --}}
                <div class="col-lg-6">
                    <div class="border p-4 h-100">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <i class="bi bi-eye"></i>
                            <h2 class="h4 fw-bold mb-0">Our Vision</h2>
                        </div>

                        <p class="text-muted mb-0">
                            To become a leading modern fashion brand known for minimal design, high-quality essentials,
                            and a community that values confidence, individuality, and everyday style.
                        </p>

                        <hr class="my-4">

                        <ul class="list-unstyled mb-0">
                            <li class="d-flex gap-2 mb-2">
                                <i class="bi bi-check2 text-dark"></i>
                                <span class="text-muted">Build a brand that stands for clean design and consistent
                                    quality.</span>
                            </li>
                            <li class="d-flex gap-2 mb-2">
                                <i class="bi bi-check2 text-dark"></i>
                                <span class="text-muted">Expand collections while staying true to the Adrahan
                                    identity.</span>
                            </li>
                            <li class="d-flex gap-2">
                                <i class="bi bi-check2 text-dark"></i>
                                <span class="text-muted">Grow a loyal community through trust, transparency, and
                                    service.</span>
                            </li>
                        </ul>
                    </div>
                </div>

            </div>

        </div>
    </section>

    {{-- VALUES STRIP --}}
    <section class="py-5 bg-white">
        <div class="container">

            <div class="mb-4">
                <p class="text-uppercase small text-muted ls-2 mb-1">What We Stand For</p>
                <h2 class="h3 fw-bold section-title mb-0">Core Values</h2>
            </div>

            <div class="row g-4">

                <div class="col-md-4">
                    <div class="border p-4 h-100">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <i class="bi bi-gem"></i>
                            <h3 class="h5 fw-bold mb-0">Quality First</h3>
                        </div>
                        <p class="text-muted mb-0">
                            Materials and stitching that hold up — because essentials should last beyond the season.
                        </p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="border p-4 h-100">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <i class="bi bi-brush"></i>
                            <h3 class="h5 fw-bold mb-0">Minimal Design</h3>
                        </div>
                        <p class="text-muted mb-0">
                            Clean silhouettes and versatile pieces you can style your way — every day.
                        </p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="border p-4 h-100">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <i class="bi bi-shield-check"></i>
                            <h3 class="h5 fw-bold mb-0">Trust & Service</h3>
                        </div>
                        <p class="text-muted mb-0">
                            Transparent pricing, responsive support, and delivery you can depend on.
                        </p>
                    </div>
                </div>

            </div>

        </div>
    </section>

    {{-- CTA --}}
    <section class="py-5 bg-white">
        <div class="container">
            <div class="border p-4 d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
                <div>
                    <h2 class="h4 fw-bold mb-1">Explore the Collection</h2>
                    <p class="text-muted mb-0">Discover essentials designed for modern wardrobes.</p>
                </div>

                <a href="{{ route('shop') }}" class="btn btn-dark rounded-0 py-3 px-4 fw-bold text-uppercase">
                    Shop Now
                </a>
            </div>
        </div>
    </section>

    {{-- Small page-only helpers --}}
    <style>
        .ls-2 {
            letter-spacing: 2px;
        }

        .section-title {
            font-family: inherit;
        }

        /* matches your Shop styling */
        .border {
            border-color: rgba(0, 0, 0, 0.12) !important;
        }
    </style>

</x-layout>
