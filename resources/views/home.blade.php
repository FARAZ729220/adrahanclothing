<x-layout>

    <section class="hero-section d-flex align-items-center justify-content-center text-center">
        <div class="hero-overlay"></div>

        <div class="container position-relative z-index-1">
            <p class="text-uppercase tracking-widest small fw-bold mb-2 fade-in-content delay-1">
                New Season Drop
            </p>

            <div class="fade-in-content delay-2">
                <h1 class="display-1 fw-black text-white mb-0">Your Style.</h1>
                <h1 class="display-1 fw-black gradient-text mt-n2">Your Rules.</h1>
            </div>

            <p class="lead text-light opacity-75 mx-auto mt-4 mb-5 hero-subtext fade-in-content delay-3">
                Bold fits for the fearless. Drop into the <br class="d-none d-md-block"> freshest streetwear collection.
            </p>

            <div class="fade-in-content delay-4">
                <a href="{{ route('shop') }}" class="btn btn-gradient rounded-pill px-5 py-3 fw-bold">
                    Explore <span class="ms-2">→</span>
                </a>
            </div>
        </div>
    </section>

    {{-- product section --}}
    <section id="trending" class="trending-section py-5">
        <div class="container py-5">

            <div class="row mb-5 text-center fade-in-content">
                <div class="col-12">
                    <h2 class="display-5 fw-black text-white">Trending <span class="gradient-text">Now</span></h2>
                    <p class="text-light opacity-75 small mt-2">The pieces everyone's talking about.</p>
                </div>
            </div>

            <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 gx-4 gx-lg-5 gy-5 product-grid">
                @forelse($products as $product)
                    @php
                        $hasImages =
                            !empty($product->images) && is_array($product->images) && count($product->images) > 0;
                        $img = $hasImages
                            ? asset('storage/' . $product->images[0])
                            : asset('images/product-placeholder.jpg');

                        $originalPrice = (float) ($product->price ?? 0);
                        $finalPrice = $originalPrice;

                        if ($product->discount_type === 'percent' && (float) $product->discount_value > 0) {
                            $finalPrice = $originalPrice - ($originalPrice * (float) $product->discount_value) / 100;
                        } elseif ($product->discount_type === 'fixed' && (float) $product->discount_value > 0) {
                            $finalPrice = $originalPrice - (float) $product->discount_value;
                        }

                        $finalPrice = max(0, $finalPrice);

                        $badgeText = null;
                        if ($product->discount_type === 'percent' && (float) $product->discount_value > 0) {
                            $badgeText = ((int) $product->discount_value) . '% OFF';
                        } elseif ($product->discount_type === 'fixed' && (float) $product->discount_value > 0) {
                            $badgeText = 'PKR ' . ((int) $product->discount_value) . ' OFF';
                        }
                    @endphp

                    <div class="col product-card-container">
                        <a href="{{ route('product.show', $product->id) }}" class="text-decoration-none text-dark">
                            <div class="product-card shadow-sm">
                                <div class="img-wrapper position-relative">
                                    <img src="{{ $img }}" alt="{{ $product->name }}">

                                    {{-- Discount Badge --}}
                                    @if ($badgeText)
                                        <span class="badge bg-danger position-absolute top-0 start-0 m-2">
                                            {{ $badgeText }}
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="product-info mt-3">
                                <p class="product-name m-0 fw-bold tiny-text text-white">
                                    {{ $product->name }}
                                </p>

                                <div class="d-flex justify-content-between align-items-center mt-1">

                                    {{-- Price Section --}}
                                    <div class="price-box">
                                        @if ($finalPrice < $originalPrice)
                                            <span
                                                class="old-price text-secondary tiny-text text-decoration-line-through me-1">
                                                PKR {{ number_format($originalPrice, 0) }}
                                            </span>
                                        @endif

                                        <span class="product-price fw-bold tiny-text">
                                            PKR {{ number_format($finalPrice, 0) }}
                                        </span>
                                    </div>

                                    {{-- Stock Section --}}
                                    <div class="stock-box">
                                        <p class="text-secondary m-0 stock-text">
                                            In Stock: {{ $product->stock ?? 0 }}
                                        </p>
                                    </div>

                                </div>
                            </div>
                        </a>
                    </div>

                @empty
                    <div class="col-12">
                        <p class="text-center">No products found.</p>
                    </div>
                @endforelse

            </div>

            <div class="row mt-5 pt-4 text-center">
                <div class="col-12">
                    <a href="{{ route('shop') }}"
                        class="btn btn-outline-pink px-5 py-3 rounded-pill fw-bold text-uppercase tiny-text">
                        View All
                    </a>
                </div>
            </div>
        </div>
    </section>


    {{-- category section --}}
    <section class="category-section py-5">
        <div class="container py-5">
            <div class="row mb-5 text-center">
                <div class="col-12">
                    <h2 class="display-5 fw-black text-white">Shop by <span class="gradient-text">Category</span></h2>
                    <p class="text-light opacity-75 small">Find your vibe.</p>
                </div>
            </div>

            <div class="row g-4 gx-lg-5 category-grid">
                @forelse($categories as $category)
                    <div class="col-6 col-md-3 product-card-container">
                        <a href="{{ route('shop', ['category' => $category->slug]) }}">
                            <div class="category-card">
                                <img src="{{ $category->image ? asset('storage/' . $category->image) : asset('images/placeholder.jpg') }}"
                                    alt="{{ $category->name }}">
                                <div class="category-overlay">
                                    <h3 class="fw-black text-white m-0">{{ $category->name }}</h3>
                                </div>
                            </div>
                        </a>
                    </div>
                @empty
                    <div class="col-12">
                        <p class="text-center">No categories found.</p>
                    </div>
                @endforelse


            </div>
        </div>
    </section>
    
</x-layout>
