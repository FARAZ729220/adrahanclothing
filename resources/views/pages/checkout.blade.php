<x-layout title="Checkout | Adrahan">

    @php
        $pixelContentIds = collect($items)
            ->map(function ($it) {
                return (string) ($it['product_id'] ?? ($it['id'] ?? $it['name']));
            })
            ->values();

        $pixelContents = collect($items)
            ->map(function ($it) {
                return [
                    'id' => (string) ($it['product_id'] ?? ($it['id'] ?? $it['name'])),
                    'quantity' => (int) ($it['qty'] ?? 1),
                    'item_price' => (float) ($it['price'] ?? 0),
                ];
            })
            ->values();

        $pixelNumItems = collect($items)->sum(function ($it) {
            return (int) ($it['qty'] ?? 1);
        });
    @endphp
    <section class="checkout-page bg-white reveal" style="padding:100px 0;">
        <div class="container py-lg-4">

            <div class="d-flex align-items-center justify-content-between mb-4">
                <div>
                    <p class="text-uppercase small text-muted ls-2 mb-1">Secure Checkout</p>
                    <h2 class="display-5 fw-bold section-title mb-0">Checkout</h2>
                </div>

                <a href="{{ route('cart.index') }}" class="text-decoration-none text-dark small">
                    <i class="bi bi-arrow-left me-1"></i> Back to Cart
                </a>
            </div>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="row g-5">

                <div class="col-lg-7 reveal-left">
                    <div class="checkout-card border p-4">

                        <form action="{{ route('checkout.place') }}" method="POST" enctype="multipart/form-data"
                            id="checkoutForm" novalidate>
                            @csrf

                            <div class="mb-3">
                                <label class="fw-bold small mb-2 d-block">Full Name</label>
                                <input name="name" class="form-control rounded-0 @error('name') is-invalid @enderror"
                                    required value="{{ old('name') }}">
                                @error('name')
                                    <small class="text-danger d-block mt-1">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="fw-bold small mb-2 d-block">Email <span class="text-muted"></span></label>
                                <input name="email" type="email"
                                    class="form-control rounded-0 @error('email') is-invalid @enderror"
                                    value="{{ old('email') }}">
                                @error('email')
                                    <small class="text-danger d-block mt-1">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="fw-bold small mb-2 d-block">Phone</label>
                                <input name="phone"
                                    class="form-control rounded-0 @error('phone') is-invalid @enderror" required
                                    value="{{ old('phone') }}">
                                @error('phone')
                                    <small class="text-danger d-block mt-1">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="fw-bold small mb-2 d-block">Shipping Address</label>
                                <textarea name="shipping_address" class="form-control rounded-0 @error('shipping_address') is-invalid @enderror"
                                    rows="4" required>{{ old('shipping_address') }}</textarea>
                                @error('shipping_address')
                                    <small class="text-danger d-block mt-1">{{ $message }}</small>
                                @enderror
                            </div>

                            <hr class="my-4">

                            <div class="mb-2">
                                <label class="fw-bold small mb-3 d-block">Payment Method</label>

                                <div class="d-flex gap-2 flex-wrap">
                                    <label class="pay-pill">
                                        <input type="radio" name="payment_method" value="cod"
                                            {{ old('payment_method', 'cod') === 'cod' ? 'checked' : '' }}>
                                        <span>COD</span>
                                    </label>

                                    <label class="pay-pill">
                                        <input type="radio" name="payment_method" value="online_manual"
                                            {{ old('payment_method') === 'online_manual' ? 'checked' : '' }}>
                                        <span>Online (Manual)</span>
                                    </label>
                                </div>

                                @error('payment_method')
                                    <small class="text-danger d-block mt-2">{{ $message }}</small>
                                @enderror
                            </div>

                            <div id="manualBox" class="manual-box border p-3 mt-3" style="display:none;">
                                <p class="fw-bold mb-2">Payment Details</p>

                                <div class="text-muted small">
                                    <div class="fw-semibold text-dark">Muneeb ur Rehman</div>
                                    <div class="mt-1">
                                        Account:
                                        <span class="fw-bold text-dark">{{ $account['number'] }}</span>
                                    </div>
                                    <div class="small mt-2">{{ $account['note'] }}</div>
                                </div>

                                <hr>

                                <div class="text-muted small my-3">
                                    <div class="fw-semibold text-dark">Muneeb ur Rehman</div>
                                    <div class="mt-1">
                                        Account:
                                        <span class="fw-bold text-dark">Bank Al Habib: 10680048015336016</span>
                                    </div>
                                    <div class="small mt-2">{{ $account['note'] }}</div>
                                </div>

                                <hr>

                                <div class="mt-3">
                                    <label class="fw-bold small mb-2 d-block">
                                        Upload Payment Screenshot <span class="text-danger">*</span>
                                    </label>
                                    <input type="file" name="payment_proof"
                                        class="form-control rounded-0 @error('payment_proof') is-invalid @enderror"
                                        accept="image/*" id="paymentProof">
                                    <div class="small text-muted mt-1">jpg/png/webp • max 2MB</div>
                                    <small class="text-danger d-none mt-1" id="proofError">
                                        Payment screenshot is required.
                                    </small>
                                    @error('payment_proof')
                                        <small class="text-danger d-block mt-1">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="mt-3">
                                    <label class="fw-bold small mb-2 d-block">Reference Note <span
                                            class="text-muted">(optional)</span></label>
                                    <input type="text" name="payment_reference_note"
                                        class="form-control rounded-0 @error('payment_reference_note') is-invalid @enderror"
                                        value="{{ old('payment_reference_note') }}" placeholder="Txn id / sender name">
                                    @error('payment_reference_note')
                                        <small class="text-danger d-block mt-1">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <button class="btn btn-dark w-100 rounded-0 py-3 fw-bold text-uppercase mt-4"
                                id="placeOrderBtn">
                                Place Order
                            </button>
                        </form>

                    </div>
                </div>

                <div class="col-lg-5 reveal-right">
                    <div class="checkout-card border p-4 checkout-summary">

                        <h4 class="fw-bold mb-4">Order Summary</h4>

                        @foreach ($items as $it)
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div>
                                    <div class="fw-semibold">{{ $it['name'] }}</div>
                                    <div class="text-muted small">
                                        Size: {{ $it['size'] }} • Qty: {{ $it['qty'] }}
                                    </div>
                                </div>

                                <div class="fw-bold">
                                    Rs {{ number_format(((float) $it['price']) * ((int) $it['qty'])) }}
                                </div>
                            </div>

                            <hr>
                        @endforeach

                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Subtotal</span>
                            <span class="fw-bold">Rs {{ number_format($subtotal) }}</span>
                        </div>

                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-muted">Shipping</span>
                            <span class="fw-bold">Rs {{ number_format($shipping) }}</span>
                        </div>

                        <hr>

                        <div class="d-flex justify-content-between mt-3">
                            <span class="fw-bold">Total</span>
                            <span class="fw-bold">Rs {{ number_format($total) }}</span>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const checkoutForm = document.getElementById('checkoutForm');
        const paymentRadios = document.querySelectorAll('input[name="payment_method"]');
        const manualBox = document.getElementById('manualBox');
        const paymentProof = document.getElementById('paymentProof');
        const proofError = document.getElementById('proofError');

        const total = {{ json_encode((float) $total) }};
        const currency = 'PKR';

        const contentIds = @json($pixelContentIds);
        const contents = @json($pixelContents);

        let addPaymentInfoTracked = false;

        if (typeof fbq === 'function') {
            fbq('track', 'InitiateCheckout', {
                content_type: 'product',
                content_ids: contentIds,
                contents: contents,
                num_items: {{ $pixelNumItems }},
                value: total,
                currency: currency
            });
        } else {
            console.log('[Pixel] fbq not available');
        }

        function getSelectedPaymentMethod() {
            return document.querySelector('input[name="payment_method"]:checked')?.value;
        }

        function toggleManualBox() {
            const selected = getSelectedPaymentMethod();

            if (selected === 'online_manual') {
                manualBox.style.display = 'block';
                paymentProof?.setAttribute('required', 'required');

                if (!addPaymentInfoTracked && typeof fbq === 'function') {
                    fbq('track', 'AddPaymentInfo', {
                        content_type: 'product',
                        content_ids: contentIds,
                        contents: contents,
                        value: total,
                        num_items: {{ $pixelNumItems }},
                        currency: currency
                    });
                    addPaymentInfoTracked = true;
                }
            } else {
                manualBox.style.display = 'none';
                paymentProof?.removeAttribute('required');
                proofError?.classList.add('d-none');
            }
        }

        paymentRadios.forEach(radio => {
            radio.addEventListener('change', toggleManualBox);
        });

        toggleManualBox();

        checkoutForm?.addEventListener('submit', function (e) {
            const selected = getSelectedPaymentMethod();

            if (!checkoutForm.checkValidity()) {
                e.preventDefault();
                e.stopPropagation();
                checkoutForm.reportValidity();
                return;
            }

            if (selected === 'online_manual' && paymentProof && !paymentProof.files.length) {
                e.preventDefault();
                proofError?.classList.remove('d-none');
                paymentProof.focus();
                return;
            }

            proofError?.classList.add('d-none');
        });
    });
</script>
</x-layout>
