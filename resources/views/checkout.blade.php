<x-layout>
    <section style="padding:140px 0;">
        <div class="container">

            <div class="d-flex align-items-center justify-content-between mb-4">
                <h2 class="text-white fw-black m-0">Checkout</h2>
                <a href="{{ route('cart.index') }}" class="text-light opacity-75">← Back to Cart</a>
            </div>

            {{-- Errors / success --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $e)
                            <li>{{ $e }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="row g-4">

                {{-- LEFT: FORM --}}
                <div class="col-lg-7">
                    <div class="p-4 rounded-4" style="background:#0b1220;">
                        <form action="{{ route('checkout.place') }}" method="POST" enctype="multipart/form-data" id="checkoutForm">
                            @csrf

                            <div class="mb-3">
                                <label class="text-white mb-1">Full Name</label>
                                <input name="name" class="form-control" required value="{{ old('name') }}">
                            </div>

                            <div class="mb-3">
                                <label class="text-white mb-1">Email (optional)</label>
                                <input name="email" type="email" class="form-control" value="{{ old('email') }}">
                            </div>

                            <div class="mb-3">
                                <label class="text-white mb-1">Phone</label>
                                <input name="phone" class="form-control" required value="{{ old('phone') }}">
                            </div>

                            <div class="mb-3">
                                <label class="text-white mb-1">Shipping Address</label>
                                <textarea name="shipping_address" class="form-control" rows="4" required>{{ old('shipping_address') }}</textarea>
                            </div>

                            <hr class="border-secondary my-4">

                            <div class="mb-2">
                                <label class="text-white fw-bold mb-2">Payment Method</label>

                                <div class="d-flex gap-3 flex-wrap">
                                    <label class="btn btn-outline-light">
                                        <input type="radio" name="payment_method" value="cod"
                                            {{ old('payment_method', 'cod') === 'cod' ? 'checked' : '' }}>
                                        COD
                                    </label>

                                    <label class="btn btn-outline-light">
                                        <input type="radio" name="payment_method" value="online_manual"
                                            {{ old('payment_method') === 'online_manual' ? 'checked' : '' }}>
                                        Online (Manual)
                                    </label>
                                </div>
                            </div>

                            {{-- Manual Payment Box --}}
                            <div id="manualBox" class="p-3 rounded-3 mt-3" style="background:#111c33; display:none;">
                                <p class="text-white mb-1 fw-bold">Payment Details</p>
                                <div class="text-light">
                                    <div>{{ $account['title'] }}</div>
                                    <div class="mt-1">
                                        Account:
                                        <span class="text-white fw-bold">{{ $account['number'] }}</span>
                                    </div>
                                    <div class="small opacity-75 mt-2">{{ $account['note'] }}</div>
                                </div>

                                <div class="mt-3">
                                    <label class="text-white mb-1">Upload Payment Screenshot <span class="text-danger">*</span></label>
                                    <input type="file" name="payment_proof" class="form-control" accept="image/*" id="paymentProof">
                                    <div class="small text-light opacity-75 mt-1">
                                        jpg/png/webp • max 2MB
                                    </div>
                                </div>

                                <div class="mt-3">
                                    <label class="text-white mb-1">Reference Note (optional)</label>
                                    <input type="text" name="payment_reference_note" class="form-control"
                                        value="{{ old('payment_reference_note') }}" placeholder="Txn id / sender name">
                                </div>
                            </div>

                            <button class="btn btn-gradient w-100 py-3 rounded-pill fw-bold text-uppercase mt-4" id="placeOrderBtn">
                                Place Order
                            </button>
                        </form>
                    </div>
                </div>

                {{-- RIGHT: SUMMARY --}}
                <div class="col-lg-5">
                    <div class="p-4 rounded-4" style="background:#0b1220;">
                        <h5 class="text-white mb-3">Order Summary</h5>

                        @foreach($items as $it)
                            <div class="d-flex justify-content-between text-light mb-2">
                                <div>
                                    <div class="text-white fw-semibold">{{ $it['name'] }}</div>
                                    <div class="small opacity-75">
                                        Size: {{ $it['size'] }} • Qty: {{ $it['qty'] }}
                                    </div>
                                </div>
                                <div class="text-white fw-bold">
                                    Rs {{ number_format(((float)$it['price']) * ((int)$it['qty'])) }}
                                </div>
                            </div>
                            <hr class="border-secondary">
                        @endforeach

                        <div class="d-flex justify-content-between text-light mb-2">
                            <span>Subtotal</span>
                            <span>Rs {{ number_format($subtotal) }}</span>
                        </div>

                        <div class="d-flex justify-content-between text-light mb-2">
                            <span>Shipping</span>
                            <span>Rs {{ number_format($shipping) }}</span>
                        </div>

                        <div class="d-flex justify-content-between text-white fw-bold mt-3">
                            <span>Total</span>
                            <span>Rs {{ number_format($total) }}</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
</x-layout>

<script>
    const manualBox = document.getElementById('manualBox');
    const paymentProof = document.getElementById('paymentProof');
    const radios = document.querySelectorAll('input[name="payment_method"]');

    function toggleManual() {
        const selected = document.querySelector('input[name="payment_method"]:checked')?.value;

        if (selected === 'online_manual') {
            manualBox.style.display = 'block';
            if (paymentProof) paymentProof.required = true; // ✅ front-end required
        } else {
            manualBox.style.display = 'none';
            if (paymentProof) paymentProof.required = false;
        }
    }

    radios.forEach(r => r.addEventListener('change', toggleManual));
    toggleManual();
</script>
