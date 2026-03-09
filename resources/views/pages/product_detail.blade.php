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

        $images = is_array($product->images) ? $product->images : [];
        $maxStock = (int) ($product->stock ?? 0);
    @endphp

    <section class="product-detail-section py-5 bg-white">
        <div class="container py-lg-4">

            <a href="{{ url()->previous() }}" class="text-decoration-none text-dark small mb-4 d-inline-block">
                <i class="bi bi-arrow-left me-1"></i> Back
            </a>

            <div class="row g-5">

                {{-- LEFT: Gallery --}}
                <div class="col-lg-7">
                    <div class="product-main-img position-relative bg-light overflow-hidden">

                        @if ($badgeText)
                            <span class="badge-tag m-3 position-absolute top-0 start-0 z-2">
                                {{ $badgeText }}
                            </span>
                        @endif

                        @if (count($images) > 0)
                            <div id="productCarousel" class="carousel slide" data-bs-ride="carousel">

                                @if (count($images) > 1)
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
                                @endif

                                <div class="carousel-inner">
                                    @foreach ($images as $index => $image)
                                        <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                            <img src="{{ asset('storage/' . $image) }}" alt="{{ $product->name }}"
                                                class="img-fluid w-100" style="height:520px; object-fit:cover;">
                                        </div>
                                    @endforeach
                                </div>

                                @if (count($images) > 1)
                                    <button class="carousel-control-prev" type="button"
                                        data-bs-target="#productCarousel" data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Previous</span>
                                    </button>

                                    <button class="carousel-control-next" type="button"
                                        data-bs-target="#productCarousel" data-bs-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Next</span>
                                    </button>
                                @endif

                            </div>
                        @else
                            <div class="d-flex align-items-center justify-content-center" style="height:520px;">
                                <span class="text-muted">No Image Available</span>
                            </div>
                        @endif

                    </div>
                </div>

                {{-- RIGHT: Details --}}
                <div class="col-lg-5">
                    <div class="ps-lg-4">

                        <form id="addToCartForm" action="{{ route('cart.add') }}" method="POST">
                            @csrf

                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="hidden" name="size" id="selectedSize">
                            <input type="hidden" name="qty" id="selectedQty" value="1">

                            <p class="text-uppercase text-muted smaller mb-1 ls-1">
                                {{ $product->category->name ?? 'Category' }}
                            </p>

                            <h1 class="display-6 fw-bold section-title mb-2">
                                {{ $product->name }}
                            </h1>

                            @if (!empty($product->description))
                                <p class="text-muted mb-4" style="line-height: 1.7;">
                                    {{ $product->description }}
                                </p>
                            @endif

                            <div class="d-flex align-items-baseline gap-3 mb-4 my-5">
                                <h3 class="fw-bold mb-0">
                                    Rs {{ number_format($finalPrice) }}
                                </h3>

                                @if ($finalPrice < $originalPrice)
                                    <span class="text-muted text-decoration-line-through">
                                        Rs {{ number_format($originalPrice) }}
                                    </span>
                                @endif

                                <span class="ms-auto text-muted smaller">
                                    In Stock: {{ $maxStock }}
                                </span>
                            </div>

                            {{-- Sizes --}}
                            <div class="mb-4">
                                <label class="fw-bold small mb-3 d-block">Select Size</label>

                                <div class="d-flex gap-2 flex-wrap">
                                    @foreach ($product->sizes ?? [] as $size)
                                        <button type="button" class="btn btn-outline-dark size-box rounded-0 size-btn"
                                            data-size="{{ $size }}">
                                            {{ $size }}
                                        </button>
                                    @endforeach
                                </div>
                            </div>

                            {{-- Quantity --}}
                            <div class="mb-5">
                                <label class="fw-bold small mb-3 d-block">Quantity</label>

                                <div class="d-flex align-items-center quantity-selector border"
                                    style="width: fit-content;">
                                    <button type="button" class="btn border-0 py-2 px-3" id="qtyMinus">-</button>
                                    <span class="px-3 fw-bold" id="qtyDisplay">1</span>
                                    <button type="button" class="btn border-0 py-2 px-3" id="qtyPlus">+</button>
                                </div>

                                @if ($maxStock <= 0)
                                    <small class="text-danger d-block mt-2">Out of stock</small>
                                @endif
                            </div>

                            {{-- Buttons --}}
                            <div class="d-grid gap-3">
                                <button type="submit"
                                    class="btn btn-dark rounded-0 py-3 fw-bold text-uppercase d-flex align-items-center justify-content-center gap-2"
                                    id="addToCartBtn" {{ $maxStock <= 0 ? 'disabled' : '' }}>
                                    <i class="bi bi-bag-plus"></i> Add To Cart
                                </button>

                                <button type="button" onclick="window.location='{{ route('checkout.show') }}'"
                                    class="btn btn-outline-dark rounded-0 py-3 fw-bold text-uppercase">
                                    Proceed to Checkout
                                </button>
                            </div>

                        </form>

                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- Toast --}}
    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 9999">
        <div id="cartToast" class="toast bg-dark text-white border-0" role="alert">
            <div class="toast-body" id="cartToastMsg"></div>
        </div>
    </div>

    {{-- Minimal styling for badge (optional) --}}
    <style>
        .badge-tag {
            background: #111;
            color: #fff;
            padding: 8px 12px;
            font-size: 12px;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .size-btn.active {
            background: #111 !important;
            color: #fff !important;
            border-color: #111 !important;
        }
    </style>

    <script>
        const form = document.getElementById('addToCartForm');
        const sizeInput = document.getElementById('selectedSize');
        const qtyInput = document.getElementById('selectedQty');
        const qtyDisplay = document.getElementById('qtyDisplay');
        const addBtn = document.getElementById('addToCartBtn');

        const maxStock = {{ $maxStock }};
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

        // SIZE SELECT
        document.querySelectorAll('.size-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                document.querySelectorAll('.size-btn').forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                sizeInput.value = this.dataset.size;
            });
        });

        // QUANTITY CONTROL
        document.getElementById('qtyPlus')?.addEventListener('click', function() {
            if (maxStock <= 0) return;
            if (currentQty < maxStock) {
                currentQty++;
                qtyDisplay.textContent = currentQty;
                qtyInput.value = currentQty;
            }
        });

        document.getElementById('qtyMinus')?.addEventListener('click', function() {
            if (currentQty > 1) {
                currentQty--;
                qtyDisplay.textContent = currentQty;
                qtyInput.value = currentQty;
            }
        });

        // ADD TO CART (AJAX)
        form?.addEventListener('submit', async function(e) {
            e.preventDefault();

            if (maxStock <= 0) {
                showToast('Out of stock');
                return;
            }

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
</x-layout>
