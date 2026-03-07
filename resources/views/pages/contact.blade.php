<x-layout>
    <section class="contact-section py-5 bg-white">
        <div class="container py-5">
            <div class="text-center mb-5">
                <h2 class="display-5 fw-bold section-title">Contact Us</h2>
                <p class="text-muted">Got a question? We'd love to hear from you.</p>
            </div>


            <div class="py-5 text-center">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show mx-auto"
                        style="
                max-width: 360px;
                background: linear-gradient(90deg, #00e5ff 0%, #9d50bb 100%);
                font-weight: 700;
                color: #000000;
                border: none;
             ">
                        {{ session('success') }}

                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"
                            aria-label="Close">
                        </button>
                    </div>
                @endif
            </div>


            <div class="row g-5 ">
                <div class="col-lg-4">
                    <div class="d-flex align-items-start mb-4">
                        <div class="contact-icon-box me-3">
                            <i class="bi bi-geo-alt"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-1">Address</h6>
                            <p class="text-muted small mb-0">123 Fashion Street, Style City, SC 10001</p>
                        </div>
                    </div>

                    <div class="d-flex align-items-start mb-4">
                        <div class="contact-icon-box me-3">
                            <i class="bi bi-telephone"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-1">Phone</h6>
                            <p class="text-muted small mb-0">+1 (555) 000-0000</p>
                        </div>
                    </div>

                    <div class="d-flex align-items-start">
                        <div class="contact-icon-box me-3">
                            <i class="bi bi-envelope"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-1">Email</h6>
                            <p class="text-muted small mb-0">hello@drip.store</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-8">
                    <div class="contact-form-card p-4 p-md-5 border">
                        <form action="{{ route('contact.us.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-12">
                                    <label class="form-label small fw-bold">Name *</label>
                                    <input type="text" name="name" class="form-control rounded-1"
                                        placeholder="Your name" value="{{ old('name') }}">
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label small fw-bold">Phone</label>
                                    <input type="text" name="phone" class="form-control rounded-1"
                                        value="{{ old('phone]') }}" placeholder="Your phone number">
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label small fw-bold">Email *</label>
                                    <input type="email" name="email" class="form-control rounded-1"
                                        placeholder="you@example.com" value="{{ old('email') }}">
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label small fw-bold">Proof Image *</label>
                                    <input type="file" name="proof_image" class="form-control rounded-1">
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label small fw-bold">Message *</label>
                                    <textarea class="form-control rounded-1" name="description" rows="4" placeholder="Tell us how we can help..."> {{ old('description') }}</textarea>
                                </div>
                                <div class="col-12 mt-4">
                                    <button type="submit"
                                        class="btn btn-dark w-100 rounded-1 py-3 fw-bold text-uppercase d-flex align-items-center justify-content-center gap-2">
                                        <i class="bi bi-send"></i> Send Message
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-layout>
