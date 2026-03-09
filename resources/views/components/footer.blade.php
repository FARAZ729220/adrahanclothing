 <footer class="footer bg-white pt-5 pb-3 border-top">
    <div class="container py-4">
        <div class="row gy-4">
            <div class="col-md-4">
                <h3 class="footer-logo fw-bold mb-3">Adrahan Clothing.</h3>
                <p class="text-muted small mb-0">Timeless fashion for the modern wardrobe.</p>
                <p class="text-muted small">Quality pieces, effortless style.</p>
            </div>

            <div class="col-md-4">
                <h6 class="footer-heading fw-bold mb-3">Quick Links</h6>
                <ul class="list-unstyled footer-list">
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li><a href="{{ route('shop') }}">Shop</a></li>
                    <li><a href="{{ route('contact.us') }}">Contact Us</a></li>
                    <li><a href="{{ route('mission') }}">Our Mission</a></li>

                </ul>
            </div>

            <div class="col-md-4">
                <h6 class="footer-heading fw-bold mb-3">Follow Us</h6>
                <div class="d-flex gap-3">
                    <a href="https://www.instagram.com/adrahanclothing.pk?igsh=MTVoYjR6MXl4eXhlMA==" target="_blank" class="social-circle">
                        <i class="bi bi-instagram"></i>
                    </a>
                    <a href="https://www.facebook.com/share/1GGsYbuefk/" class="social-circle" target="_blank">
                        <i class="bi bi-facebook"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="text-center mt-5 pt-4 border-top">
            <p class="copyright-text mb-0">© {{ date('Y') }} Adrahan Clothing. All rights reserved.</p>
        </div>
    </div>
</footer>
