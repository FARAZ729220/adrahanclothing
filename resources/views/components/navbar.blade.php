<nav class="navbar navbar-expand navbar-dark fixed-top custom-nav fade-in-content">
    <div class="container-fluid px-4 px-md-5">
        <a class="navbar-brand fw-black" href="#">Adrahan<span>.</span></a>

        <div class="navbar-nav mx-auto">
            <a class="nav-link px-3" href="{{ route('home') }}">Home</a>
            <a class="nav-link px-3" href="{{ route('shop') }}">Shop</a>
        </div>

        <div class="navbar-icons">
            <a href="{{ route('cart.index') }}" class="text-white opacity-75 position-relative d-inline-block">

                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                    class="bi bi-bag" viewBox="0 0 16 16">
                    <path
                        d="M8 1a2.5 2.5 0 0 1 2.5 2.5V4h-5v-.5A2.5 2.5 0 0 1 8 1zm3.5 3v-.5a3.5 3.5 0 1 0-7 0V4H1v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4h-3.5zM2 5h12v9a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V5z" />
                </svg>

                @php $count = count(session('cart', [])); @endphp

                <span id="cartCountBadge"
                    class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-dark"
                    style="font-size: 11px; {{ $count > 0 ? '' : 'display:none;' }}">
                    {{ $count }}
                </span>
            </a>
        </div>
    </div>
</nav>
