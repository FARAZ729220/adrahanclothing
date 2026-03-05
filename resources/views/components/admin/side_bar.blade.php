<nav class="admin-sidebar d-flex flex-column p-3">
    <div class="sidebar-header mb-4">
        <span class="text-secondary small fw-bold">Admin Panel</span>
    </div>

    <ul class="nav nav-pills flex-column mb-auto">

        <li class="nav-item mb-2">
            <a href="{{ route('admin.dashboard') }}"
                class="nav-link d-flex align-items-center gap-2
               {{ request()->routeIs('admin.dashboard') ? 'active' : 'text-white' }}">
                <i class="bi bi-grid-fill"></i> Dashboard
            </a>
        </li>

        <li class="nav-item mb-2">
            <a href="{{ route('admin.orders.index') }}"
                class="nav-link d-flex align-items-center gap-2
               {{ request()->routeIs('admin.orders.*') ? 'active' : 'text-white' }}">
                <i class="bi bi-cart"></i> Orders
            </a>
        </li>

        <li class="nav-item mb-2">
            <a href="{{ route('category.index') }}"
                class="nav-link d-flex align-items-center gap-2
               {{ request()->routeIs('category.*') ? 'active' : 'text-white' }}">
                <i class="bi bi-folder"></i> Categories
            </a>
        </li>

        <li class="nav-item mb-2">
            <a href="{{ route('product.index') }}"
                class="nav-link d-flex align-items-center gap-2
               {{ request()->routeIs('product.*') ? 'active' : 'text-white' }}">
                <i class="bi bi-box-seam"></i> Products
            </a>
        </li>

    </ul>

    <hr class="border-secondary">

    <a href="#" class="nav-link text-danger d-flex align-items-center gap-2 mb-3"
        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        <i class="bi bi-box-arrow-right"></i> Logout
    </a>

    <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" class="d-none">
        @csrf
    </form>
</nav>
