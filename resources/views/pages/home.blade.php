<x-layout title="Adrahan Clothing - Premium Minimal Fashion"
    description="Shop premium minimal fashion at Adrahan Clothing. Discover timeless essentials crafted for everyday style and comfort.">

    <header class="hero-section" id="homeHero">

        <div id="heroCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="5000">

            <div class="carousel-inner">


                @if ($settings && $settings->hero_image_1)
                    <div class="carousel-item active hero-slide"
                        style="background-image:url('{{ asset('storage/' . $settings->hero_image_1) }}')">
                    </div>
                @endif



                @if ($settings && $settings->hero_image_2)
                    <div class="carousel-item hero-slide"
                        style="background-image:url('{{ asset('storage/' . $settings->hero_image_2) }}')">
                    </div>
                @endif


                {{-- IMAGE 3 --}}
                @if ($settings && $settings->hero_image_3)
                    <div class="carousel-item hero-slide"
                        style="background-image:url('{{ asset('storage/' . $settings->hero_image_3) }}')">
                    </div>
                @endif

            </div>

        </div>



        <div class="hero-overlay text-white">

            <div class="hero-content">

                <p class="text-uppercase mb-2 small fw-semibold">
                    {{ $settings->hero_subtitle ?? 'New Season Collection' }}
                </p>

                <h1 class="display-1 fw-bold mb-3">
                    {{ $settings->hero_title ?? 'Your Style. Your Rules.' }}
                </h1>

                <p class="lead mb-4 px-3 mw-500">
                    {{ $settings->hero_description ?? 'Discover the freshest collection crafted for the modern wardrobe.' }}
                </p>

                <a href="{{ route('shop') }}" class="btn btn-light rounded-0 px-4 py-2 fw-bold text-uppercase">
                    Explore Collection →
                </a>

            </div>

        </div>

    </header>

    <section class="product-section py-5 bg-white reveal">
        <div class="container py-5">

            <div class="text-center mb-5">
                <p class="text-uppercase small text-muted ls-2 mb-1">Curated For You</p>
                <h2 class="display-5 fw-bold section-title">Best Sellers</h2>
            </div>

            <div class="row g-4 reveal-stagger">

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

                    <div class="col-6 col-md-4 col-lg-3">

                        <a href="{{ route('product.show', $product->slug) }}" class="text-decoration-none text-dark">

                            <div class="product-card">

                                <div class="product-img-container position-relative">

                                    @if ($badgeText)
                                        <span class="badge-discount">{{ $badgeText }}</span>
                                    @endif

                                    <img src="{{ $img }}" alt="{{ $product->name }}" class="img-fluid w-100">

                                </div>

                                <div class="product-info mt-3">

                                    <h6 class="product-name mb-1">{{ $product->name }}</h6>

                                    <div class="d-flex justify-content-between align-items-center">

                                        <div class="price-box">

                                            @if ($finalPrice < $originalPrice)
                                                <span
                                                    class="old-price text-muted small text-decoration-line-through me-2">
                                                    PKR {{ number_format($originalPrice, 0) }}
                                                </span>
                                            @endif

                                            <span class="new-price fw-bold">
                                                PKR {{ number_format($finalPrice, 0) }}
                                            </span>

                                        </div>

                                        <span class="stock-status text-muted small">
                                            In Stock: {{ $product->stock ?? 0 }}
                                        </span>

                                    </div>

                                </div>

                            </div>

                        </a>

                    </div>

                @empty

                    <div class="col-12 text-center">
                        <p>No products found.</p>
                    </div>
                @endforelse

            </div>

            <div class="text-center mt-5">
                <a href="{{ route('shop') }}"
                    class="btn btn-outline-dark rounded-0 px-5 py-2 fw-bold text-uppercase view-all-btn">
                    View All Products
                </a>
            </div>

        </div>
    </section>




    {{-- category section --}}
    <section class="category-section bg-white reveal">
        <div class="container py-5">
            <div class="text-center mb-5">
                <p class="text-uppercase small text-muted ls-2 mb-1">Browse</p>
                <h2 class="display-5 fw-bold section-title">Shop by Category</h2>
            </div>

            <div class="row g-4 reveal-stagger">
                @forelse($categories as $category)
                    <div class="col-6 col-md-3">
                        <a href="{{ route('shop', ['category' => $category->slug]) }}"
                            class="category-card position-relative d-block overflow-hidden">
                            <img src="{{ $category->image ? asset('storage/' . $category->image) : asset('images/placeholder.jpg') }}"
                                alt="{{ $category->name }}" class="img-fluid w-100">
                            <div class="category-label">
                                <h3 class="h5 mb-0 fw-bold">{{ $category->name }}</h3>
                            </div>
                            <div class="category-overlay"></div>
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
 
     