<nav class="navbar navbar-expand-lg fixed-top custom-nav {{ request()->routeIs('home') ? '' : 'nav-scrolled' }}">
    <div class="container-fluid nav-shell px-3 px-lg-5">

        <!-- LEFT : LOGO -->
        <a class="navbar-brand brand-wrap" href="{{ route('home') }}">
            <span class="logo-badge">
                <img src="{{ asset('logo/logo.png') }}" class="nav-logo" alt="Adrahan Logo">
            </span>
        </a>

        <!-- CENTER : DESKTOP NAV -->
        <div class="collapse navbar-collapse justify-content-center d-none d-lg-flex">
            <ul class="navbar-nav gap-4">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}"
                        href="{{ route('home') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('shop') ? 'active' : '' }}"
                        href="{{ route('shop') }}">Shop</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('mission') ? 'active' : '' }}"
                        href="{{ route('mission') }}">Our Mission</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('contact.us') ? 'active' : '' }}"
                        href="{{ route('contact.us') }}">Contact</a>
                </li>
            </ul>
        </div>

        <!-- RIGHT : CART + MOBILE MENU -->
        <div class="nav-actions">
            <a href="{{ route('cart.index') }}" class="nav-icon cart-btn position-relative" aria-label="Cart">
                <i class="bi bi-bag"></i>

                @php $count = count(session('cart', [])); @endphp
                <span id="cartCountBadge"
                    class="position-absolute top-0 start-100 translate-middle badge rounded-pill cart-badge"
                    style="{{ $count > 0 ? '' : 'display:none;' }}">
                    {{ $count }}
                </span>
            </a>

            <button class="navbar-toggler border-0 menu-btn" type="button" id="mobileMenuToggle"
                aria-label="Open menu">
                <span class="custom-toggler-icon">
                    <span></span>
                    <span></span>
                    <span></span>
                </span>
            </button>
        </div>

    </div>
</nav>

{{-- Premium Mobile Drawer --}}
<div class="mobile-drawer" id="mobileDrawer">
    <div class="mobile-drawer-backdrop" id="mobileDrawerBackdrop"></div>

    <div class="mobile-drawer-panel">
        <div class="mobile-drawer-header">
            <a class="mobile-drawer-brand text-decoration-none" href="{{ route('home') }}">
                <span class="logo-badge">
                    <img src="{{ asset('logo/logo.png') }}" class="nav-logo" alt="Adrahan Logo">
                </span>
            </a>

            <button type="button" class="mobile-drawer-close" id="mobileDrawerClose" aria-label="Close menu">
                <span>&times;</span>
            </button>
        </div>

        <div class="mobile-drawer-body">
            <ul class="mobile-drawer-nav list-unstyled mb-0">
                <li>
                    <a class="{{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Home</a>
                </li>
                <li>
                    <a class="{{ request()->routeIs('shop') ? 'active' : '' }}" href="{{ route('shop') }}">Shop</a>
                </li>
                <li>
                    <a class="{{ request()->routeIs('mission') ? 'active' : '' }}" href="{{ route('mission') }}">Our
                        Mission</a>
                </li>
                <li>
                    <a class="{{ request()->routeIs('contact.us') ? 'active' : '' }}"
                        href="{{ route('contact.us') }}">Contact</a>
                </li>
                <li>
                    <a class="{{ request()->routeIs('privacy.policy') ? 'active' : '' }}"
                        href="{{ route('privacy.policy') }}">Privacy Policy</a>
                </li>
            </ul>

            <div class="mobile-drawer-social">
                <h6>Follow Us</h6>
                <div class="mobile-social-icons">
                    <a href="https://www.instagram.com/adrahanclothing.pk?igsh=MTVoYjR6MXl4eXhlMA=="
                        aria-label="Instagram"><i class="bi bi-instagram"></i></a>
                    <a href="https://www.facebook.com/share/1GGsYbuefk/" aria-label="Facebook"><i
                            class="bi bi-facebook"></i></a>
                </div>
            </div>
        </div>
    </div>
</div>
