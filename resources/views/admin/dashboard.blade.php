<x-admin.layout>



    <main class="flex-grow-1 p-5">
        <h2 class="text-white fw-black mb-4">Dashboard</h2>

        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            <div class="col">
                <div class="stat-card p-4 rounded-4">
                    <div class="icon-box purple mb-3"><i class="bi bi-cart-fill"></i></div>
                    <h3 class="text-white fw-black m-0">{{ $totalOrders }}</h3>
                    <p class="text-secondary small m-0">Total Orders</p>
                </div>
            </div>

            <div class="col">
                <div class="stat-card p-4 rounded-4">
                    <div class="icon-box blue mb-3"><i class="bi bi-folder-fill"></i></div>
                    <h3 class="text-white fw-black m-0">{{ $totalCategories }}</h3>
                    <p class="text-secondary small m-0">Total Categories</p>
                </div>
            </div>

            <div class="col">
                <div class="stat-card p-4 rounded-4">
                    <div class="icon-box green mb-3"><i class="bi bi-box-fill"></i></div>
                    <h3 class="text-white fw-black m-0">{{ $totalProducts }}</h3>
                    <p class="text-secondary small m-0">Total Products</p>
                </div>
            </div>

            <div class="col">
                <div class="stat-card p-4 rounded-4">
                    <div class="icon-box yellow mb-3"><i class="bi bi-exclamation-triangle-fill"></i></div>
                    <h3 class="text-white fw-black m-0">{{ $lowStockProducts }}</h3>
                    <p class="text-secondary small m-0">Low Stock (&lt; 5)</p>
                </div>
            </div>

            <div class="col">
                <div class="stat-card p-4 rounded-4">
                    <div class="icon-box red mb-3"><i class="bi bi-x-circle-fill"></i></div>
                    <h3 class="text-white fw-black m-0">{{ $outOfStockProducts }}</h3>
                    <p class="text-secondary small m-0">Out of Stock</p>
                </div>
            </div>

            <div class="col">
                <div class="stat-card p-4 rounded-4">
                    <div class="icon-box light-green mb-3"><i class="bi bi-currency-dollar"></i></div>
                    <h3 class="text-white fw-black m-0">Rs {{ number_format($totalRevenue) }}</h3>
                    <p class="text-secondary small m-0">Total Revenue (Paid)</p>
                </div>
            </div>

            <div class="col">
                <div class="stat-card p-4 rounded-4">
                    <div class="icon-box yellow mb-3"><i class="bi bi-hourglass-split"></i></div>
                    <h3 class="text-white fw-black m-0">{{ $pendingPayments }}</h3>
                    <p class="text-secondary small m-0">Pending Payments</p>
                </div>
            </div>

            <div class="col">
                <div class="stat-card p-4 rounded-4">
                    <div class="icon-box yellow mb-3"><i class="bi bi-truck"></i></div>
                    <h3 class="text-white fw-black m-0">{{ $pendingDeliveries }}</h3>
                    <p class="text-secondary small m-0">Pending Deliveries</p>
                </div>
            </div>

             <div class="col">
                <div class="stat-card p-4 rounded-4">
                    <div class="icon-box red mb-3"><i class="bi bi-x-circle"></i></div>
                    <h3 class="text-white fw-black m-0">{{ $cancelledOrders }}</h3>
                    <p class="text-secondary small m-0">Cancelled Orders</p>
                </div>
            </div>
        </div>
    </main>




</x-admin.layout>


 
