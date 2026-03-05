<x-layout title="Cart | Adrahan">

    @php
        $isEmpty = $cartItems->count() === 0;
    @endphp

    {{-- EMPTY CART --}}
    @if ($isEmpty)
        <section class="empty-cart-section py-5 vh-100 d-flex align-items-center justify-content-center">
            <div class="container text-center">
                <div class="cart-icon-wrapper mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor"
                        class="bi bi-bag" viewBox="0 0 16 16">
                        <path
                            d="M8 1a2.5 2.5 0 0 1 2.5 2.5V4h-5v-.5A2.5 2.5 0 0 1 8 1zm3.5 3v-.5a3.5 3.5 0 1 0-7 0V4H1v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4h-3.5zM2 5h12v9a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V5z" />
                    </svg>
                </div>

                <h2 class="text-white fw-black mb-2">Your cart is empty</h2>
                <p class="text-light opacity-50 mb-4">Time to fill it with some fire fits.</p>

                <a href="{{ route('shop') }}" class="btn btn-gradient px-5 py-3 rounded-pill fw-bold text-uppercase">
                    CONTINUE SHOPPING
                </a>
            </div>
        </section>
    @else
        {{-- CART WITH ITEMS --}}
        <section class="cart-section py-5">
            <div class="container py-5">
                <h2 class="display-5 fw-black text-white mb-5">Your <span class="gradient-text">Cart</span></h2>

                <div class="row g-5">
                    <div class="col-lg-8">

                        @foreach ($cartItems as $item)
                            @php
                                $img = !empty($item['img'])
                                    ? asset('storage/' . $item['img'])
                                    : asset('images/product-placeholder.jpg');

                                $qty = (int) ($item['qty'] ?? 1);
                                $unitPrice = (float) ($item['price'] ?? 0);
                                $lineTotal = $unitPrice * $qty;
                            @endphp

                            <div class="cart-item-card d-flex align-items-center mb-4 p-3" id="row-{{ $item['key'] }}"
                                data-key="{{ $item['key'] }}">

                                <img src="{{ $img }}" class="rounded-3 me-3" width="80" height="80"
                                    style="object-fit:cover;" alt="{{ $item['name'] }}">

                                <div class="flex-grow-1">

                                    <p class="m-0 fw-bold text-white">
                                        {{ $item['name'] }}
                                    </p>

                                    <p class="m-0 text-light opacity-75 small">
                                        Size: <span class="fw-semibold">{{ $item['size'] }}</span>
                                    </p>

                                    {{-- Unit + line total --}}
                                    <div class="d-flex flex-wrap align-items-center gap-3 mt-2">
                                        <p class="m-0 text-pink fw-bold">
                                            Rs {{ number_format($unitPrice) }}
                                        </p>

                                        <p class="m-0 text-light opacity-75 small">
                                            Line Total:
                                            <span class="fw-bold text-white" id="line-{{ $item['key'] }}">
                                                Rs {{ number_format($lineTotal) }}
                                            </span>
                                        </p>

                                        <p class="m-0 ms-auto text-light opacity-75 small">
                                            Stock: {{ (int) ($item['stock'] ?? 0) }}
                                        </p>
                                    </div>

                                    {{-- Qty --}}
                                    <div class="qty-selector d-flex align-items-center mt-3">
                                        <button type="button" class="btn btn-sm text-white qty-minus"
                                            data-key="{{ $item['key'] }}">-</button>

                                        <span class="px-3 text-white"
                                            id="qty-{{ $item['key'] }}">{{ $qty }}</span>

                                        <button type="button" class="btn btn-sm text-white qty-plus"
                                            data-key="{{ $item['key'] }}">+</button>
                                    </div>
                                </div>

                                {{-- Remove --}}
                                <button type="button" class="btn text-secondary remove-item"
                                    data-key="{{ $item['key'] }}" aria-label="Remove item">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        @endforeach

                    </div>

                    {{-- Order Summery --}}
                    <div class="col-lg-4">
                        <div class="order-summary-box p-4 rounded-4">
                            <h4 class="text-white mb-4">Order Summary</h4>

                            <div class="d-flex justify-content-between mb-3 text-light">
                                <span>Subtotal</span>
                                <span id="subtotalText">Rs {{ number_format($subtotal) }}</span>
                            </div>

                            <div class="d-flex justify-content-between mb-4 text-light">
                                <span>Shipping</span>
                                <span id="shippingText">Rs {{ number_format($shipping) }}</span>
                            </div>

                            <hr class="border-secondary">

                            <div class="d-flex justify-content-between mb-4 fw-bold">
                                <span class="text-white">Total</span>
                                <span class="text-white" id="totalText">Rs {{ number_format($total) }}</span>
                            </div>

                            <a href="{{ route('checkout.show') }}"
                                class="btn btn-gradient w-100 py-3 rounded-pill fw-bold text-uppercase text-center">
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
