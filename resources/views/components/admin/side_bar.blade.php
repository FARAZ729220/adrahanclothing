<nav class="admin-sidebar d-flex flex-column p-3">
    <div class="sidebar-header mb-4">
        <span class="text-secondary small fw-bold">Admin Panel</span>
    </div>

    <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item mb-2">
            <a href="{{ route('admin.dashboard') }}" class="nav-link active d-flex align-items-center gap-2">
                <i class="bi bi-grid-fill"></i> Dashboard
            </a>
        </li>
        <li class="nav-item mb-2">
            <a href="#" class="nav-link text-white d-flex align-items-center gap-2">
                <i class="bi bi-cart"></i> Orders
            </a>
        </li>
        <li class="nav-item mb-2">
            <a href="{{ route('category.index') }}" class="nav-link text-white d-flex align-items-center gap-2">
                <i class="bi bi-folder"></i> Categories
            </a>
        </li>
        <li class="nav-item mb-2">
            <a href="#" class="nav-link text-white d-flex align-items-center gap-2">
                <i class="bi bi-box-seam"></i> Products
            </a>
        </li>
    </ul>

    <hr class="border-secondary">
    <a href="logout.php" class="nav-link text-danger d-flex align-items-center gap-2 mb-3">
        <i class="bi bi-box-arrow-right"></i> Logout
    </a>
</nav>
