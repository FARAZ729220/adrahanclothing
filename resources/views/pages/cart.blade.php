<x-layout title="Cart | Adrahan">

    @php
        $isEmpty = $cartItems->count() === 0;
    @endphp

    {{-- EMPTY CART --}}
    @if ($isEmpty)
        <section class="cart-empty-section d-flex align-items-center justify-content-center bg-white">
            <div class="container text-center py-5">
                <div class="mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" fill="#6c757d" class="bi bi-bag-x"
                        viewBox="0 0 16 16">
                        <path fill-rule="evenodd"
                            d="M6.146 8.146a.5.5 0 0 1 .708 0L8 9.293l1.146-1.147a.5.5 0 1 1 .708.708L8.707 10l1.147 1.146a.5.5 0 0 1-.708.708L8 10.707l-1.146 1.147a.5.5 0 0 1-.708-.708L7.293 10 6.146 8.854a.5.5 0 0 1 0-.708z" />
                        <path
                            d="M8 1a2.5 2.5 0 0 1 2.5 2.5V4h-5v-.5A2.5 2.5 0 0 1 8 1zm3.5 3v-.5a3.5 3.5 0 1 0-7 0V4H1v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4h-3.5zM2 5h12v9a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V5z" />
                    </svg>
                </div>

                <h2 class="display-5 fw-bold cart-title mb-3">Your cart is empty</h2>
                <p class="text-muted lead mb-5 mx-auto" style="max-width: 500px;">
                    Discover our collection and find something you love.
                </p>

                <a href="{{ route('shop') }}" class="btn btn-dark rounded-0 px-5 py-3 fw-bold text-uppercase ls-1">
                    Start Shopping
                </a>
            </div>
        </section>
    @else
        {{-- CART WITH ITEMS --}}


        <section class="cart-section py-5 bg-white">
            <div class="container py-5">

                <h1 class="display-4 fw-bold section-title mb-5">Shopping Cart</h1>

                <div class="row g-5">

                    {{-- LEFT: Cart Items --}}
                    <div class="col-lg-8">

                        @forelse ($cartItems as $item)
                            @php
                                $img = !empty($item['img'])
                                    ? asset('storage/' . $item['img'])
                                    : asset('images/product-placeholder.jpg');

                                $qty = (int) ($item['qty'] ?? 1);
                                $unitPrice = (float) ($item['price'] ?? 0);
                                $lineTotal = $unitPrice * $qty;

                                $size = $item['size'] ?? null;
                                $stock = (int) ($item['stock'] ?? 0);
                                $key = $item['key'];
                            @endphp

                            <div class="cart-item border p-3 d-flex align-items-center position-relative mb-3"
                                id="row-{{ $key }}" data-key="{{ $key }}">

                                {{-- Image --}}
                                <div class="cart-img-box me-4">
                                    <img src="{{ $img }}" alt="{{ $item['name'] }}" class="img-fluid"
                                        style="width:90px;height:90px;object-fit:cover;">
                                </div>

                                {{-- Details --}}
                                <div class="cart-details flex-grow-1">

                                    <h5 class="fw-bold mb-1">{{ $item['name'] }}</h5>

                                    {{-- Optional meta row --}}
                                    <div class="d-flex flex-wrap gap-3 align-items-center mb-2">
                                        @if ($size)
                                            <small class="text-muted">Size: <span
                                                    class="fw-semibold">{{ $size }}</span></small>
                                        @endif
                                        <small class="text-muted">Stock: <span
                                                class="fw-semibold">{{ $stock }}</span></small>
                                    </div>

                                    {{-- Price Row --}}
                                    <div class="d-flex flex-wrap gap-3 align-items-center mb-3">
                                        <span class="new-price fw-bold">
                                            Rs {{ number_format($unitPrice) }}
                                        </span>

                                        <small class="text-muted">
                                            Line Total:
                                            <span class="fw-bold" id="line-{{ $key }}">
                                                Rs {{ number_format($lineTotal) }}
                                            </span>
                                        </small>
                                    </div>

                                    {{-- Quantity Controls --}}
                                    <div class="d-flex align-items-center quantity-group">
                                        <button type="button"
                                            class="btn btn-light btn-sm border rounded-0 px-3 qty-minus"
                                            data-key="{{ $key }}">-</button>

                                        <span class="px-4 fw-bold"
                                            id="qty-{{ $key }}">{{ $qty }}</span>

                                        <button type="button"
                                            class="btn btn-light btn-sm border rounded-0 px-3 qty-plus"
                                            data-key="{{ $key }}">+</button>
                                    </div>

                                </div>

                                {{-- Remove --}}
                                <button type="button"
                                    class="btn border-0 position-absolute top-50 end-0 translate-middle-y me-3 text-muted remove-item"
                                    data-key="{{ $key }}" aria-label="Remove item">
                                    <i class="bi bi-trash3"></i>
                                </button>

                            </div>

                        @empty
                            <div class="text-center py-5">
                                <p class="mb-0 text-muted">Your cart is empty.</p>
                            </div>
                        @endforelse

                    </div>

                    {{-- RIGHT: Summary --}}
                    <div class="col-lg-4">
                        <div class="summary-card border p-4">
                            <h4 class="fw-bold mb-4">Order Summary</h4>

                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Subtotal</span>
                                <span class="fw-bold" id="subtotalText">Rs {{ number_format($subtotal) }}</span>
                            </div>

                            <div class="d-flex justify-content-between mb-4">
                                <span class="text-muted">Shipping</span>
                                <span class="fw-bold" id="shippingText">Rs {{ number_format($shipping) }}</span>
                            </div>

                            <hr>

                            <div class="d-flex justify-content-between mb-4 mt-2">
                                <h5 class="fw-bold mb-0">Total</h5>
                                <h5 class="fw-bold mb-0" id="totalText">Rs {{ number_format($total) }}</h5>
                            </div>

                            <a href="{{ route('checkout.show') }}"
                                class="btn btn-dark w-100 rounded-0 py-3 fw-bold text-uppercase ls-1">
                                Proceed to Checkout
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </section>
    @endif

</x-layout>

<script>
    const CART_UPDATE_URL = "{{ route('cart.update') }}";
    const CART_REMOVE_URL = "{{ route('cart.remove') }}";
    const CSRF = "{{ csrf_token() }}";

    function money(n) {
        return 'Rs ' + Number(n).toLocaleString('en-PK');
    }

    function applyCartResponse(res) {
        // totals
        const sub = document.getElementById('subtotalText');
        const tot = document.getElementById('totalText');
        const ship = document.getElementById('shippingText');

        if (ship) ship.innerText = money(res.shipping);
        if (sub && typeof res.subtotal !== 'undefined') sub.innerText = money(res.subtotal);
        if (tot && typeof res.total !== 'undefined') tot.innerText = money(res.total);

        // badge
        const badge = document.getElementById('cartCountBadge');
        if (typeof res.cart_count !== 'undefined') {
            if (res.cart_count > 0) {
                if (badge) {
                    badge.innerText = res.cart_count;
                    badge.style.display = 'inline-block';
                }
            } else {
                if (badge) badge.style.display = 'none';
            }
        }

        // remove row if server removed
        if (res.removed_key) {
            const row = document.getElementById('row-' + res.removed_key);
            if (row) row.remove();
        }

        // if empty, reload to show empty section
        if (res.is_empty) {
            location.reload();
        }
    }

    async function post(url, data) {
        const resp = await fetch(url, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": CSRF,
                "Accept": "application/json"
            },
            body: JSON.stringify(data)
        });

        const json = await resp.json();

        if (!resp.ok) {
            alert(json.message || "Something went wrong");
            return null;
        }

        return json;
    }

    // PLUS
    document.addEventListener('click', async function(e) {
        const btn = e.target.closest('.qty-plus');
        if (!btn) return;

        const key = btn.dataset.key;
        const qtyEl = document.getElementById('qty-' + key);

        let qty = parseInt(qtyEl.innerText || "0");
        qty++;

        const res = await post(CART_UPDATE_URL, {
            key,
            qty
        });
        if (!res) return;

        if (res.updated_key) {
            qtyEl.innerText = res.qty;

            const line = document.getElementById('line-' + key);
            if (line) line.innerText = money(res.line_total);
        }

        applyCartResponse(res);
    });

    // MINUS
    document.addEventListener('click', async function(e) {
        const btn = e.target.closest('.qty-minus');
        if (!btn) return;

        const key = btn.dataset.key;
        const qtyEl = document.getElementById('qty-' + key);

        let qty = parseInt(qtyEl.innerText || "0");
        qty--;
        if (qty < 0) qty = 0;

        const res = await post(CART_UPDATE_URL, {
            key,
            qty
        });
        if (!res) return;

        if (res.updated_key) {
            qtyEl.innerText = res.qty;

            const line = document.getElementById('line-' + key);
            if (line) line.innerText = money(res.line_total);
        }

        applyCartResponse(res);
    });


    // REMOVE with SweetAlert
    document.addEventListener('click', async function(e) {

        const btn = e.target.closest('.remove-item');
        if (!btn) return;

        const key = btn.dataset.key;

        const result = await Swal.fire({
            title: 'Remove Item?',
            text: "This item will be removed from your cart.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#7c3aed', // matches your purple theme
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, remove it',
            cancelButtonText: 'Cancel',
            background: '#0f172a',
            color: '#fff',
            backdrop: 'rgba(0,0,0,0.6)'
        });

        if (!result.isConfirmed) return;

        const res = await post(CART_REMOVE_URL, {
            key
        });
        if (!res) return;

        // Optional: small success animation
        await Swal.fire({
            icon: 'success',
            title: 'Removed!',
            text: 'Item removed from cart.',
            timer: 1200,
            showConfirmButton: false,
            background: '#0f172a',
            color: '#fff'
        });

        applyCartResponse(res);
    });
</script>
