<x-admin.layout>
    <main class="container my-5">

        <!-- Dashboard Counters -->

        <div class="row mb-4 g-3">

            <div class="col-md-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center">
                        <h6 class="text-muted">Total Orders</h6>
                        <h1 class="fw-bold text-dark">{{ $totalOrders }}</h1>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center">
                        <h6 class="text-muted">Total Categories</h6>
                        <h1 class="fw-bold text-dark">{{ $totalCategories }}</h1>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center">
                        <h6 class="text-muted">Total Products</h6>
                        <h1 class="fw-bold text-dark">{{ $totalProducts }}</h1>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center">
                        <h6 class="text-muted">Low Stock (≤5)</h6>
                        <h1 class="fw-bold text-warning">{{ $lowStockProducts }}</h1>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center">
                        <h6 class="text-muted">Out of Stock</h6>
                        <h1 class="fw-bold text-danger">{{ $outOfStockProducts }}</h1>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center">
                        <h6 class="text-muted">Total Revenue (Paid)</h6>
                        <h1 class="fw-bold text-dark">Rs {{ number_format($totalRevenue) }}</h1>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center">
                        <h6 class="text-muted">Pending Payments</h6>
                        <h1 class="fw-bold text-dark">{{ $pendingPayments }}</h1>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center">
                        <h6 class="text-muted">Pending Deliveries</h6>
                        <h1 class="fw-bold text-dark">{{ $pendingDeliveries }}</h1>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center">
                        <h6 class="text-muted">Cancelled Orders</h6>
                        <h1 class="fw-bold text-dark">{{ $cancelledOrders }}</h1>
                    </div>
                </div>
            </div>

        </div>

        <!-- Tabs -->
        <ul class="nav nav-underline mb-4" id="adminTabs" role="tablist">
            <li class="nav-item">
                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#orders" type="button">
                    Orders
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#categories" type="button">
                    Categories
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#products" type="button">
                    Products
                </button>
            </li>
        </ul>

        <!-- Tab Content -->
        <div class="tab-content">

            <!-- Orders Tab -->
            <div class="tab-pane fade show active" id="orders">
                <div class="admin-table-wrapper">
                    <table class="table table-hover align-middle" id="order-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Customer</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orders as $order)
                                <tr>
                                    <td>{{ $order->order_number }}</td>

                                    <td>
                                        {{ $order->customer_name }} <br>
                                        <small>{{ $order->customer_phone }}</small>
                                    </td>

                                    <td>Rs {{ $order->grand_total }}</td>



                                    <td>
                                        @if ($order->order_status === 'cancelled')
                                            <span class="status-badge pending">Cancelled</span>
                                        @elseif($order->delivery_status === 'done')
                                            <span class="status-badge completed">Completed</span>
                                        @elseif($order->payment_status === 'pending_verification')
                                            <span class="status-badge pending">Pending Verification</span>
                                        @else
                                            <span class="status-badge pending">Pending</span>
                                        @endif
                                    </td>

                                    <td>{{ $order->created_at->format('d M Y') }}</td>

                                    <td class="table-actions">
                                        <a href="{{ route('admin.orders.show', $order->id) }}">👁️</a>
                                    </td>
                                </tr>
                            @empty
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Categories Tab -->
            <div class="tab-pane fade" id="categories">
                <div class="admin-table-wrapper">
                    <div style="display: flex; justify-content:end ">
                        <button type="button" class="btn btn-secondary" data-bs-toggle="modal"
                            data-bs-target="#category">
                            Add
                            Category
                        </button>
                    </div>
                    <table class="table table-hover align-middle" id="category-table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Image</th>
                                <th>Active</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($categories as $category)
                                <tr>
                                    <td>{{ $category->name }}</td>
                                    <td>
                                        @if ($category->image)
                                            <img src="{{ asset('storage/' . $category->image) }}" width="50"
                                                style="border-radius:6px;">
                                        @else
                                            No Image
                                        @endif
                                    </td>
                                    <td>
                                        @if ($category->is_active)
                                            <span class="text-success">Active</span>
                                        @else
                                            <span class="text-danger">Not Active</span>
                                        @endif
                                    </td>
                                    <td>{{ $category->created_at->format('d M Y') }}</td>
                                    <td class="table-actions">
                                        <button type="button" class="btn btn-secondary edit-btn-category"
                                            data-bs-toggle="modal" data-bs-target="#editcategory"
                                            data-id="{{ $category->id }}" data-name="{{ $category->name }}"
                                            data-active="{{ $category->is_active ? 1 : 0 }}"
                                            data-image="{{ $category->image ? asset('storage/' . $category->image) : '' }}">
                                            ✏️
                                        </button>

                                        <form method="POST" action="{{ route('category.destroy', $category->id) }}"
                                            style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-danger category-delete-btn"
                                                data-id="{{ $category->id }}">
                                                🗑️
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                            @endforelse
                        </tbody>
                    </table>

                    <div class="modal fade" id="editcategory" tabindex="-1" aria-labelledby="editCategoryLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <form id="editCategoryForm" method="POST"
                                    action="{{ route('category.update', ['id' => 0]) }}"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')

                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editCategoryLabel">Edit Category</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>

                                    <div class="modal-body"
                                        style="background:#fff; padding:15px; border:1px solid #ddd; border-radius:6px;">
                                        <div style="margin-bottom:12px;">
                                            <label style="display:block; margin-bottom:6px;">Category Name</label>
                                            <input type="text" name="name" id="editCategoryName"
                                                value="" required
                                                style="width:100%; padding:10px; border:1px solid #ccc; border-radius:4px;">
                                        </div>

                                        <div style="margin-bottom:12px;">
                                            <label style="display:block; margin-bottom:6px;">Current Image</label>

                                            <img id="editCategoryPreview" src="" alt="Category Image"
                                                style="width:80px; height:80px; object-fit:cover; border-radius:8px; border:1px solid #ddd; display:none;">

                                            <div id="editCategoryNoImage" style="color:#888; font-size:14px;">
                                                No Image
                                            </div>
                                        </div>

                                        <div style="margin-bottom:12px;">
                                            <label style="display:block; margin-bottom:6px;">New Image
                                                (optional)</label>
                                            <input type="file" name="image" accept="image/*"
                                                style="width:100%; padding:10px; border:1px solid #ccc; border-radius:4px;">
                                        </div>

                                        <div style="margin-bottom:12px;">
                                            <label style="display:flex; gap:8px; align-items:center;">
                                                <input type="checkbox" name="remove_image" value="1">
                                                Remove current image
                                            </label>
                                        </div>

                                        <div style="margin-bottom:12px;">
                                            <label style="display:flex; gap:8px; align-items:center;">
                                                <input type="checkbox" name="is_active" id="editCategoryActive"
                                                    value="1">
                                                Active
                                            </label>
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary"
                                            style="background:#111; color:#fff;">Update</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Products Tab -->
            <div class="tab-pane fade" id="products">
                <div class="admin-table-wrapper">
                    <div style="display: flex; justify-content:end ">
                        <a href="{{ route('product.create') }}" class="btn btn-secondary">Add Products </a>
                    </div>

                    <table class="table table-hover align-middle" id="product-table">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Stock</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($products as $product)
                                <tr>
                                    <!-- Image -->
                                    <td>
                                        @if (!empty($product->images) && is_array($product->images) && count($product->images) > 0)
                                            <img src="{{ asset('storage/' . $product->images[0]) }}" width="50"
                                                class="product-thumb">
                                        @else
                                            No Image
                                        @endif
                                    </td>

                                    <!-- Name -->
                                    <td>{{ $product->name ?? '—' }}</td>

                                    <!-- Price -->
                                    <td>${{ number_format($product->price ?? 0, 2) }}</td>

                                    <!-- Stock -->
                                    <td>
                                        @if ($product->stock == 0)
                                            <span class="badge bg-danger">Out of Stock</span>
                                        @elseif($product->stock <= 5)
                                            <span class="badge bg-warning text-dark">Low
                                                ({{ $product->stock }})
                                            </span>
                                        @else
                                            <span class="badge bg-success">{{ $product->stock }} In Stock</span>
                                        @endif
                                    </td>

                                    <!-- Actions -->
                                    <td class="table-actions">
                                        <a href="{{ route('product.edit', $product->id) }}"
                                            class="btn btn-secondary">✏️</a>

                                        <form action="{{ route('product.destroy', $product->id) }}" method="POST"
                                            style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-danger product-delete-btn"
                                                data-id="{{ $product->id }}">
                                                🗑️
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

    </main>





    {{-- Category Modal --}}
    <div class="modal fade" id="category" tabindex="-1" aria-labelledby="categoryLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="categoryLabel">Add Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('category.store') }}"
                        style="background:#fff; padding:15px; border:1px solid #ddd; border-radius:6px;"
                        enctype="multipart/form-data">
                        @csrf

                        <div style="margin-bottom:12px;">
                            <label style="display:block; margin-bottom:6px;">Category Name</label>
                            <input type="text" name="name" value="{{ old('name') }}" required
                                style="width:100%; padding:10px; border:1px solid #ccc; border-radius:4px;"
                                placeholder="e.g. Blazers">
                        </div>

                        <div style="margin-bottom:12px;">
                            <label style="display:block; margin-bottom:6px;">Category Image</label>
                            <input type="file" name="image" accept="image/*"
                                style="width:100%; padding:10px; border:1px solid #ccc; border-radius:4px;">
                        </div>

                        <div style="margin-bottom:12px;">
                            <label style="display:flex; gap:8px; align-items:center;">
                                <input type="checkbox" name="is_active" value="1"
                                    {{ old('is_active', '1') ? 'checked' : '' }}>
                                Active
                            </label>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                                style="background:#111; color:#fff; padding:10px 16px; border:none; border-radius:4px;">Close</button>
                            <button type="submit" class="btn btn-primary"
                                style="background:#111; color:#fff; padding:10px 16px; border:none; border-radius:4px;">
                                Create
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>


</x-admin.layout>


<script>
    function initTable(id) {
        const table = $(id);

        // if table has only the empty placeholder row -> do not init
        const rows = table.find("tbody tr");
        if (rows.length === 0) return;
        if (rows.length === 1 && rows.first().hasClass("dt-empty")) return;

        if (!$.fn.DataTable.isDataTable(id)) {
            table.DataTable({
                responsive: true,
                order: []
            });
        }
    }

    $(document).on('click', '.edit-btn-category', function() {

        const id = $(this).data('id');
        const name = $(this).data('name');
        const active = $(this).data('active');
        const image = $(this).data('image'); // full URL or ""

        // Fill name + active
        $('#editCategoryName').val(name);
        $('#editCategoryActive').prop('checked', active == 1);

        // Reset remove_image every time modal opens
        $('input[name="remove_image"]').prop('checked', false);

        // Preview image
        if (image) {
            $('#editCategoryPreview').attr('src', image).show();
            $('#editCategoryNoImage').hide();
        } else {
            $('#editCategoryPreview').attr('src', '').hide();
            $('#editCategoryNoImage').show();
        }

        // Update form action safely
        const form = $('#editCategoryForm');
        let action = form.attr('action');

        // if action ends with /0 replace it
        action = action.replace(/\/0$/, '/' + id);

        // if action already has some id, replace last number
        action = action.replace(/\/\d+$/, '/' + id);

        form.attr('action', action);
    });

    $(document).ready(function() {

        initTable('#product-table');
        initTable('#category-table');
        initTable('#order-table');

        // ✅ Only fetch DT instance if it exists
        const categoryTable = $.fn.DataTable.isDataTable('#category-table') ?
            $('#category-table').DataTable() :
            null;

        const productTable = $.fn.DataTable.isDataTable('#product-table') ?
            $('#product-table').DataTable() :
            null;

        // ====================
        // Delete via SweetAlert
        // ====================

        // Category Delete
        $(document).on('click', '.category-delete-btn', function() {
            const button = $(this);
            const form = button.closest('form');
            const row = button.closest('tr');

            Swal.fire({
                title: 'Are you sure?',
                text: "This category will be permanently deleted!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: form.attr('action'),
                        type: 'POST',
                        data: form.serialize(),
                        success: function() {
                            if (categoryTable) {
                                categoryTable.row(row).remove().draw(false);
                            } else {
                                row.remove();
                            }
                            Swal.fire('Deleted!', 'Category has been deleted.',
                                'success');
                        },
                        error: function() {
                            Swal.fire('Error!', 'Something went wrong.', 'error');
                        }
                    });
                }
            });
        });

        // Product Delete
        $(document).on('click', '.product-delete-btn', function() {
            const button = $(this);
            const form = button.closest('form');
            const row = button.closest('tr');

            Swal.fire({
                title: 'Are you sure?',
                text: "This product will be permanently deleted!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: form.attr('action'),
                        type: 'POST',
                        data: form.serialize(),
                        success: function() {
                            if (productTable) {
                                productTable.row(row).remove().draw(false);
                            } else {
                                row.remove();
                            }
                            Swal.fire('Deleted!', 'Product has been deleted.',
                                'success');
                        },
                        error: function() {
                            Swal.fire('Error!', 'Something went wrong.', 'error');
                        }
                    });
                }
            });
        });

        // Tabs fix (optional but good)
        $('button[data-bs-toggle="tab"]').on('shown.bs.tab', function() {
            $.fn.dataTable.tables({
                    visible: true,
                    api: true
                })
                .columns.adjust()
                .responsive.recalc();
        });

    });
</script>
