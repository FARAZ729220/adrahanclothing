{{-- <x-layout title="Shop All Products - Adrahan Clothing"
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

</x-layout> --}}




<x-layout title="Shop All Products - Adrahan Clothing" description="Browse premium clothing from Adrahan Clothing.">

    <section class="all-products-section bg-white reveal">
        <div class="container py-4">

            <div class="mb-4">
                <h2 class="display-6 fw-bold section-title mb-1">All Products</h2>
                <p class="text-muted small">Browse the full collection.</p>
            </div>

            <div class="filter-wrapper mb-4">
                <a href="{{ route('shop') }}"
                    class="btn {{ empty($selectedSlug) ? 'btn-dark' : 'btn-outline-secondary text-dark' }} rounded-0 px-3 py-2 text-uppercase fw-bold small">
                    All
                </a>

                @foreach ($categories as $cat)
                    <a href="{{ route('shop', ['category' => $cat->slug]) }}"
                        class="btn {{ $selectedSlug === $cat->slug ? 'btn-dark' : 'btn-outline-secondary text-dark' }} rounded-0 px-3 py-2 text-uppercase small">
                        {{ strtoupper($cat->name) }}
                    </a>
                @endforeach
            </div>

            <div class="row g-3 g-md-4 reveal-stagger">

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
                            <div class="product-card h-100">
                                <div class="product-img-container position-relative">
                                    @if ($oldPrice)
                                        <span class="badge-discount">
                                            {{ $product->discount_type === 'percent' ? (int) $product->discount_value . '%' : 'PKR ' . (int) $product->discount_value }}
                                            OFF
                                        </span>
                                    @endif
                                    <img src="{{ $img }}" alt="{{ $product->name }}" class="img-fluid w-100">
                                </div>

                                <div class="product-info mt-2">
                                    <h6 class="product-name mb-1 text-truncate-2">
                                        {{ $product->name }}
                                    </h6>

                                    <div class="d-flex flex-column">
                                        <div class="price-box">
                                            @if ($oldPrice)
                                                <small class="text-muted text-decoration-line-through d-block"
                                                    style="font-size: 0.7rem;">
                                                    PKR {{ number_format($oldPrice, 0) }}
                                                </small>
                                            @endif
                                            <span class="new-price fw-bold">
                                                PKR {{ number_format($newPrice, 0) }}
                                            </span>
                                        </div>

                                        <span class="stock-status text-muted" style="font-size: 0.65rem;">
                                            @if ($product->stock > 0)
                                                In Stock: {{ $product->stock }}
                                            @else
                                                <span class="text-danger">Sold Out</span>
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <p>No products found.</p>
                    </div>
                @endforelse

            </div>

            <div class="mt-5 d-flex justify-content-center">
                {{ $products->links() }}
            </div>

        </div>
    </section>
</x-layout>
