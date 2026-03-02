<x-layout>
    @php
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
            $badgeText = 'Rs ' . ((int) $product->discount_value) . ' OFF';
        }
    @endphp

    <section class="product-detail-section" style="padding: 150px">
        <div class="container">
            <div class="row g-5">

                <div class="col-md-6">
                    <div class="product-gallery position-relative">

                        {{-- Discount Badge --}}
                        @if ($badgeText)
                            <span class="badge-discount">
                                {{ $badgeText }}
                            </span>
                        @endif

                        @php
                            $images = is_array($product->images) ? $product->images : [];
                        @endphp

                        @if (count($images) > 0)

                            <div id="productCarousel" class="carousel slide" data-bs-ride="carousel">

                                {{-- Indicators --}}
                                <div class="carousel-indicators">
                                    @foreach ($images as $index => $image)
                                        <button type="button" data-bs-target="#productCarousel"
                                            data-bs-slide-to="{{ $index }}"
                                            class="{{ $index == 0 ? 'active' : '' }}"
                                            aria-current="{{ $index == 0 ? 'true' : 'false' }}"
                                            aria-label="Slide {{ $index + 1 }}">
                                        </button>
                                    @endforeach
                                </div>

                                {{-- Slides --}}
                                <div class="carousel-inner rounded-4 overflow-hidden">
                                    @foreach ($images as $index => $image)
                                        <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                            <img src="{{ asset('storage/' . $image) }}"
                                                class="d-block w-100 product-detail-img" alt="{{ $product->name }}">
                                        </div>
                                    @endforeach
                                </div>

                                {{-- Controls --}}
                                <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel"
                                    data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>

                                <button class="carousel-control-next" type="button" data-bs-target="#productCarousel"
                                    data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>

                            </div>
                        @else
                            {{-- Placeholder if no images --}}
                            <div class="rounded-4 d-flex align-items-center justify-content-center"
                                style="height:450px; background:#e5e2db;">
                                <span class="text-muted">No Image Available</span>
                            </div>
                        @endif

                    </div>
                </div>

                <div class="col-md-6">

                    <form id="addToCartForm" action="{{ route('cart.add') }}" method="POST">
                        @csrf

                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="hidden" name="size" id="selectedSize">
                        <input type="hidden" name="qty" id="selectedQty" value="1">

                        <p class="text-secondary small text-uppercase mb-1">
                            {{ $product->category->name ?? 'Category' }}
                        </p>

                        <h1 class="display-6 fw-bold text-white mb-3">
                            {{ $product->name }}
                        </h1>

                        {{-- PRICE SECTION --}}
                        <div class="d-flex align-items-center gap-3 mb-4">
                            <h2 class="product-price-large m-0 text-white">
                                Rs {{ number_format($finalPrice) }}
                            </h2>

                            @if ($finalPrice < $originalPrice)
                                <span class="text-secondary text-decoration-line-through">
                                    Rs {{ number_format($originalPrice) }}
                                </span>
                            @endif

                            <span class="ms-auto text-secondary small">
                                In Stock: {{ $product->stock }}
                            </span>
                        </div>

                        {{-- SIZE SELECTOR --}}
                        <div class="size-selector mb-4">
                            <p class="text-white small fw-bold mb-2">Select Size</p>

                            <div class="d-flex gap-2 flex-wrap">
                                @foreach ($product->sizes ?? [] as $size)
                                    <button type="button" class="btn size-btn" data-size="{{ $size }}">
                                        {{ $size }}
                                    </button>
                                @endforeach
                            </div>
                        </div>

                        {{-- QUANTITY --}}
                        <div class="quantity-selector mb-5">
                            <p class="text-white small fw-bold mb-2">Quantity</p>

                            <div class="qty-input d-flex align-items-center">
                                <button type="button" class="btn qty-control" id="qtyMinus">-</button>

                                <span id="qtyDisplay" class="px-4 text-white fw-bold">1</span>

                                <button type="button" class="btn qty-control" id="qtyPlus">+</button>
                            </div>
                        </div>

                        {{-- BUTTONS --}}
                        <div class="d-grid gap-3">
                            <button type="submit" id="addToCartBtn"
                                class="btn btn-gradient py-3 rounded-pill fw-bold text-uppercase">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                    fill="currentColor" class="bi bi-bag-plus" viewBox="0 0 16 16">
                                    <path
                                        d="M8 7.5a.5.5 0 0 1 .5.5v1.5H10a.5.5 0 0 1 0 1H8.5V11.5a.5.5 0 0 1-1 0V10H6a.5.5 0 0 1 0-1h1.5V8a.5.5 0 0 1 .5-.5z" />
                                    <path
                                        d="M8 1a2.5 2.5 0 0 1 2.5 2.5V4h-5v-.5A2.5 2.5 0 0 1 8 1zm3.5 3v-.5a3.5 3.5 0 1 0-7 0V4H1v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4h-3.5zM2 5h12v9a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V5z" />
                                </svg>
                                Add to Cart
                            </button>

                            <button type="button" id="checkoutBtn"
                                onclick="window.location='{{ route('checkout.show') }}'"
                                class="btn btn-outline-pink py-3 rounded-pill fw-bold text-uppercase">
                                Proceed to Checkout
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </section>

    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 9999">
        <div id="cartToast" class="toast bg-dark text-white border-0" role="alert">
            <div class="toast-body" id="cartToastMsg"></div>
        </div>
    </div>
</x-layout>

<script>
    const form = document.getElementById('addToCartForm');
    const sizeInput = document.getElementById('selectedSize');
    const qtyInput = document.getElementById('selectedQty');
    const qtyDisplay = document.getElementById('qtyDisplay');
    const addBtn = document.getElementById('addToCartBtn');

    const maxStock = {{ (int) $product->stock }};
    let currentQty = 1;

    function showToast(message) {
        const toastEl = document.getElementById('cartToast');
        const msgEl = document.getElementById('cartToastMsg');
        msgEl.textContent = message;

        const t = new bootstrap.Toast(toastEl, {
            delay: 2000
        });
        t.show();
    }

    // ✅ SIZE SELECT
    document.querySelectorAll('.size-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.size-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            sizeInput.value = this.dataset.size;
        });
    });

    // ✅ QUANTITY CONTROL
    document.getElementById('qtyPlus').addEventListener('click', function() {
        if (currentQty < maxStock) {
            currentQty++;
            qtyDisplay.textContent = currentQty;
            qtyInput.value = currentQty;
        }
    });

    document.getElementById('qtyMinus').addEventListener('click', function() {
        if (currentQty > 1) {
            currentQty--;
            qtyDisplay.textContent = currentQty;
            qtyInput.value = currentQty;
        }
    });

    // ✅ ADD TO CART (AJAX)
    form.addEventListener('submit', async function(e) {
        e.preventDefault();

        if (!sizeInput.value) {
            showToast('Please select a size');
            return;
        }

        try {
            addBtn.disabled = true;
            addBtn.innerText = 'ADDING...';

            const res = await fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },
                body: new FormData(form)
            });

            const data = await res.json();

            if (!res.ok) {
                showToast(data.message || 'Error adding to cart');
                return;
            }

            showToast(data.message || 'Added to cart');

            // ✅ REALTIME BADGE UPDATE (unique items count)
            if (typeof data.cart_count !== 'undefined') {
                window.setCartBadge(data.cart_count);
            }

        } catch (err) {
            showToast('Network error');
        } finally {
            addBtn.innerText = 'ADD TO CART';
            addBtn.disabled = false;
        }
    });
</script>
