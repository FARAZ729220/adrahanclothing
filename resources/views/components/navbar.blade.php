

<nav class="navbar navbar-expand-lg fixed-top custom-nav {{ request()->routeIs('home') ? '' : 'nav-scrolled' }}">
    <div class="container-fluid px-lg-5">
        <a class="navbar-brand fw-bold" href="{{ route('home') }}">Adrahan Clothing.</a>

        <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
            <ul class="navbar-nav gap-4">
                <li class="nav-item">
                    <a class="nav-link active" href="{{ route('home') }}">Home</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('shop') }}">Shop</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('mission') }}">Our Mission</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('contact.us') }}">Contact</a>
                </li>
            </ul>
        </div>

        <div class="d-flex align-items-center">

            <a href="{{ route('cart.index') }}" class="nav-icon ms-3 position-relative">

                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor"
                    class="bi bi-bag" viewBox="0 0 16 16">
                    <path
                        d="M8 1a2.5 2.5 0 0 1 2.5 2.5V4h-5v-.5A2.5 2.5 0 0 1 8 1zm3.5 3v-.5a3.5 3.5 0 1 0-7 0V4H1v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4h-3.5zM2 5h12v9a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V5z" />
                </svg>

                @php $count = count(session('cart', [])); @endphp

                <span id="cartCountBadge"
                    class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-dark"
                    style="font-size:11px; {{ $count > 0 ? '' : 'display:none;' }}">
                    {{ $count }}
                </span>

            </a>

            <button class="navbar-toggler border-0 ms-2" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

        </div>
    </div>
</nav>
