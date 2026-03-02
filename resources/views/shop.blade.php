<x-layout>
    <section id="all-products" class="all-products-section py-5">
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

                                    {{-- Discount Badge --}}
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

                                    {{-- Price Section --}}
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

                                    {{-- Stock Section --}}
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
    </section>



</x-layout>
