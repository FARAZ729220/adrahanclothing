<x-layout title="Shop All Products - Adrahan Clothing"
    description="Browse premium clothing from Adrahan Clothing. Explore modern essentials, clean silhouettes, and elevated everyday wear.">


    <section class="all-products-section bg-white reveal" style="padding: 100px">
        <div class="container py-4">

            <div class="mb-4">
                <h2 class="display-5 fw-bold section-title mb-1">All Products</h2>
                <p class="text-muted">Browse the full collection.</p>
            </div>

            <div class="d-flex flex-wrap gap-2 mb-5">

                <a href="{{ route('shop') }}"
                    class="btn {{ empty($selectedSlug) ? 'btn-dark' : 'btn-outline-secondary text-dark' }} rounded-0 px-4 py-2 text-uppercase fw-bold small">
                    All
                </a>

                @foreach ($categories as $cat)
                    <a href="{{ route('shop', ['category' => $cat->slug]) }}"
                        class="btn {{ $selectedSlug === $cat->slug ? 'btn-dark' : 'btn-outline-secondary text-dark' }} rounded-0 px-4 py-2 text-uppercase small">
                        {{ strtoupper($cat->name) }}
                    </a>
                @endforeach

            </div>


            <div class="row g-4 reveal-stagger">

                @forelse($products as $product)

                    @php
                        $img =
                            is_array($product->images) && count($product->images) > 0
                                ? asset('storage/' . $product->images[0])
                                : asset('images/product-placeholder.jpg');

                        $oldPrice = null;
                        $newPrice = $product->price;

                        if ($product->discount_type === 'percent' && $product->discount_value > 0) {
                            $oldPrice = $product->price;
                            $newPrice = max(0, $product->price - ($product->price * $product->discount_value) / 100);
                        } elseif ($product->discount_type === 'fixed' && $product->discount_value > 0) {
                            $oldPrice = $product->price;
                            $newPrice = max(0, $product->price - $product->discount_value);
                        }
                    @endphp

                    <div class="col-6 col-md-4 col-lg-3">

                        <a href="{{ route('product.show', $product->slug) }}" class="text-decoration-none text-dark">

                            <div class="product-card">

                                <div class="product-img-container position-relative">

                                    @if ($oldPrice)
                                        <span class="badge-discount">
                                            @if ($product->discount_type === 'percent')
                                                {{ (int) $product->discount_value }}% OFF
                                            @else
                                                PKR {{ (int) $product->discount_value }} OFF
                                            @endif
                                        </span>
                                    @endif

                                    <img src="{{ $img }}" alt="{{ $product->name }}" class="img-fluid w-100">

                                </div>

                                <div class="product-info mt-3">

                                    <h6 class="product-name mb-1">
                                        {{ $product->name }}
                                    </h6>

                                    <div class="d-flex justify-content-between align-items-end">

                                        <div class="price-box">

                                            @if ($oldPrice)
                                                <span
                                                    class="old-price text-muted small text-decoration-line-through me-1">
                                                    PKR {{ number_format($oldPrice, 0) }}
                                                </span>
                                            @endif

                                            <span class="new-price fw-bold">
                                                PKR {{ number_format($newPrice, 0) }}
                                            </span>

                                        </div>

                                        <span class="stock-status text-muted smaller">
                                            @if ($product->stock > 0)
                                                In Stock: {{ $product->stock }}
                                            @else
                                                <span class="text-danger">Out of Stock</span>
                                            @endif
                                        </span>

                                    </div>

                                </div>

                            </div>

                        </a>

                    </div>

                @empty

                    <div class="col-12 text-center py-5">
                        <p class="mb-0">No products found for this category.</p>
                    </div>

                @endforelse

            </div>


            <div class="mt-5">
                {{ $products->links() }}
            </div>

        </div>
    </section>

</x-layout>





{{-- <section id="all-products" class="all-products-section py-5">
        <div class="container py-5">

            <div class="row mb-4 text-start">
                <div class="col-12">
                    <h2 class="display-4 fw-black text-white m-0"><span class="gradient-text">Products</span></h2>
                    <p class="text-light opacity-75 small mt-2">Browse the full collection.</p>
                </div>
            </div>

            <div class="row mb-5">
                <div class="col-12 d-flex flex-wrap gap-2 filter-container">
                    <a href="{{ route('shop') }}"
                        class="btn filter-btn {{ empty($selectedSlug) ? 'active' : '' }}">All</a>
                    @foreach ($categories as $cat)
                        <a href="{{ route('shop', ['category' => $cat->slug]) }}"
                            class="btn filter-btn {{ $selectedSlug === $cat->slug ? 'active' : '' }}">{{ strtoupper($cat->name) }}</a>
                    @endforeach

                </div>
            </div>

            <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 gx-4 gx-lg-5 gy-5 product-grid">

                @forelse($products as $product)
                    @php
                        $img =
                            is_array($product->images) && count($product->images) > 0
                                ? asset('storage/' . $product->images[0])
                                : asset('images/product-placeholder.jpg');

                        $oldPrice = null;
                        $newPrice = $product->price;

                        if ($product->discount_type === 'percent' && $product->discount_value > 0) {
                            $oldPrice = $product->price;
                            $newPrice = max(0, $product->price - ($product->price * $product->discount_value) / 100);
                        } elseif ($product->discount_type === 'fixed' && $product->discount_value > 0) {
                            $oldPrice = $product->price;
                            $newPrice = max(0, $product->price - $product->discount_value);
                        }
                    @endphp

                    <div class="col product-card-container">
                        <a href="{{ route('product.show', $product->slug) }}" class="text-decoration-none text-dark">

                            <div class="product-card shadow-sm">
                                <div class="img-wrapper position-relative">
                                    <img src="{{ $img }}" alt="{{ $product->name }}">


                                    @if ($oldPrice)
                                        <span class="badge bg-danger position-absolute top-0 start-0 m-2">
                                            @if ($product->discount_type === 'percent')
                                                {{ (int) $product->discount_value }}% OFF
                                            @else
                                                PKR {{ (int) $product->discount_value }} OFF
                                            @endif
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="product-info mt-3">
                                <p class="product-name m-0 fw-bold tiny-text text-white">
                                    {{ $product->name }}
                                </p>

                                <div class="d-flex justify-content-between align-items-center mt-1">


                                    <div class="price-box">
                                        @if ($oldPrice)
                                            <span
                                                class="old-price text-secondary tiny-text text-decoration-line-through me-1">
                                                PKR {{ number_format($oldPrice, 0) }}
                                            </span>
                                        @endif

                                        <span class="product-price fw-bold tiny-text">
                                            PKR {{ number_format($newPrice, 0) }}
                                        </span>
                                    </div>


                                    <div class="stock-box">
                                        <p class="text-secondary m-0 stock-text">
                                            @if ($product->stock > 0)
                                                In Stock: {{ $product->stock }}
                                            @else
                                                <span class="text-danger">Out of Stock</span>
                                            @endif
                                        </p>
                                    </div>

                                </div>
                            </div>

                        </a>
                    </div>

                @empty
                    <div class="col-12 text-center py-5">
                        <p class="mb-0">No products found for this category.</p>
                    </div>
                @endforelse

            </div>


            <div class="mt-4">
                {{ $products->links() }}
            </div>
        </div>
    </section> --}}
