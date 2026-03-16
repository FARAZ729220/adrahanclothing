<x-layout title="Shop All Products - Adrahan Clothing" description="Browse premium clothing from Adrahan Clothing.">
    <section class="all-products-section bg-white reveal">
        <div class="container py-4">
            <div class="mb-4">
                <h2 class="display-6 fw-bold section-title mb-1">All Products</h2>
                <p class="text-muted small">Browse the full collection.</p>
            </div>

            <div class="filter-wrapper mb-4 d-flex flex-wrap gap-2">
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
                        $images = is_array($product->images) ? $product->images : json_decode($product->images, true);
                        $img =
                            !empty($images) && isset($images[0])
                                ? asset('storage/' . $images[0])
                                : asset('images/product-placeholder.jpg');

                        $newPrice = $product->price;
                        $oldPrice = null;

                        if ($product->discount_value > 0) {
                            $oldPrice = $product->price;
                            $newPrice =
                                $product->discount_type === 'percent'
                                    ? $product->price - ($product->price * $product->discount_value) / 100
                                    : $product->price - $product->discount_value;
                        }
                    @endphp

                    <div class="col-6 col-md-4 col-lg-3">
                        <a href="{{ route('product.show', $product->slug) }}"
                            class="text-decoration-none text-dark card-hover">
                            <div class="product-card h-100 border-0 shadow-sm-hover transition-all">
                                <div class="product-img-container position-relative overflow-hidden bg-light">
                                    @if ($oldPrice)
                                        <span
                                            class="badge bg-danger position-absolute top-0 start-0 m-2 rounded-0 px-2 py-1"
                                            style="z-index: 5; font-size: 0.65rem;">
                                            SALE
                                            {{ $product->discount_type === 'percent'
                                                ? (int) $product->discount_value . '%'
                                                : 'PKR ' . number_format($product->discount_value) }}
                                        </span>
                                    @endif

                                    <img src="{{ $img }}" alt="{{ $product->name }}"
                                        class="img-fluid w-100 object-fit-cover" style="aspect-ratio: 3/4;"
                                        loading="lazy">
                                </div>

                                <div class="product-info mt-2 px-1">
                                    <h6 class="product-name mb-1 text-truncate fw-semibold" style="font-size: 0.9rem;">
                                        {{ $product->name }}
                                    </h6>

                                    <div class="price-box">
                                        <span class="new-price fw-bold text-dark">
                                            PKR {{ number_format($newPrice) }}
                                        </span>

                                        @if ($oldPrice)
                                            <small class="text-muted text-decoration-line-through ms-1"
                                                style="font-size: 0.75rem;">
                                                {{ number_format($oldPrice) }}
                                            </small>
                                        @endif
                                    </div>

                                    <div class="stock-status mt-1">
                                        @if ($product->stock > 0)
                                            <span class="text-success small" style="font-size: 0.65rem;">● In
                                                Stock</span>
                                        @else
                                            <span class="text-danger small" style="font-size: 0.65rem;">● Sold
                                                Out</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <i class="bi bi-bag-x display-1 text-light"></i>
                        <p class="text-muted mt-3">No products found in this category.</p>
                    </div>
                @endforelse
            </div>

            <div class="mt-5 pagination-wrapper">
                {{ $products->links('pagination::bootstrap-5') }}
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {

                if (typeof fbq !== 'function') {
                    console.log('[Pixel] fbq not available');
                    return;
                }

                let pixelData = {
                    content_name: @json($selectedSlug ?? 'All Products'),
                    content_category: 'Shop',
                    content_type: 'product_group'
                };

                @if ($products->count() > 0)
                    pixelData.content_ids = @json($products->take(5)->pluck('id')->map(fn($id) => (string) $id)->values());

                    pixelData.contents = @json(
                        $products->take(5)->map(fn($p) => [
                                    'id' => (string) $p->id,
                                    'quantity' => 1,
                                ])->values());

                    pixelData.num_items = {{ $products->total() }};
                @endif

                fbq('track', 'ViewContent', pixelData);

            });
        </script>
    </section>
</x-layout>
