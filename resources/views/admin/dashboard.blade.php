<x-admin.layout>
    <main class="container my-5">


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
                            <tr>
                                <td>1001</td>
                                <td>John Doe</td>
                                <td>$485</td>
                                <td><span class="status-badge completed">Completed</span></td>
                                <td>26 Feb 2026</td>
                                <td class="table-actions">
                                    ✏️ 🗑️
                                </td>
                            </tr>
                            <tr>
                                <td>1002</td>
                                <td>Sarah Smith</td>
                                <td>$210</td>
                                <td><span class="status-badge pending">Pending</span></td>
                                <td>25 Feb 2026</td>
                                <td class="table-actions">
                                    ✏️ 🗑️
                                </td>
                            </tr>
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
                                <th>Active</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($categories->count() > 0)
                                @foreach ($categories as $category)
                                    <tr>
                                        <td>{{ $category->name }}</td>

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
                                                data-active="{{ $category->is_active ? 1 : 0 }}">
                                                ✏️
                                            </button>
                                            <!-- Delete Button -->
                                            {{-- <form method="POST" action="{{ route('category.destroy', $category->id) }}"
                                                style="display:inline-block;"
                                                onsubmit="return confirm('Are you sure you want to delete this category?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger category-delete-btn">
                                                    🗑️
                                                </button>
                                            </form> --}}
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
                                @endforeach
                            @endif

                        </tbody>
                    </table>

                    <div class="modal fade" id="editcategory" tabindex="-1" aria-labelledby="editCategoryLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <form id="editCategoryForm" method="POST"
                                    action="{{ route('category.update', ['id' => 0]) }}">
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
                                            <input type="text" name="name" id="editCategoryName" value=""
                                                required
                                                style="width:100%; padding:10px; border:1px solid #ccc; border-radius:4px;">
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
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($products as $product)
                                <tr>
                                    <td>
                                        @if (!empty($product->images) && count($product->images) > 0)
                                            <img src="{{ asset('storage/' . $product->images[0]) }}"
                                                class="product-thumb" width="50">
                                        @else
                                            no image
                                        @endif
                                    </td>

                                    <td>{{ $product->name }}</td>

                                    <td>${{ number_format($product->price, 2) }}</td>

                                    <td>
                                        @if ($product->stock > 0)
                                            {{ $product->stock }} In Stock
                                        @else
                                            <span class="out-stock">Out of Stock</span>
                                        @endif
                                    </td>

                                    <td class="table-actions">
                                        <a href="{{ route('product.edit', $product->id) }}" button type="button"
                                            class="btn btn-secondary">✏️</a>

                                        <form method="POST" action="{{ route('product.destroy', $product->id) }}"
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
                                <tr>
                                    <td colspan="5" style="text-align:center;">
                                        No products found.
                                    </td>
                                </tr>
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
                        style="background:#fff; padding:15px; border:1px solid #ddd; border-radius:6px;">
                        @csrf

                        <div style="margin-bottom:12px;">
                            <label style="display:block; margin-bottom:6px;">Category Name</label>
                            <input type="text" name="name" value="{{ old('name') }}" required
                                style="width:100%; padding:10px; border:1px solid #ccc; border-radius:4px;"
                                placeholder="e.g. Blazers">
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
    $(document).ready(function() {
        // Initialize tables once
        const categoryTable = $('#category-table').DataTable({
            responsive: true,
            order: []
        });
        const productTable = $('#product-table').DataTable({
            responsive: true,
            order: []
        });

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
                            // Remove row via DataTables API
                            categoryTable.row(row).remove().draw(false);
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
                            // Remove row via DataTables API
                            productTable.row(row).remove().draw(false);
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

        // Edit Category Modal
        const editButtons = document.querySelectorAll('.edit-btn-category');
        editButtons.forEach(button => {
            button.addEventListener('click', function() {
                const id = this.dataset.id;
                const name = this.dataset.name;
                const active = this.dataset.active;

                document.getElementById('editCategoryName').value = name;
                document.getElementById('editCategoryActive').checked = active == 1;

                const form = document.getElementById('editCategoryForm');
                form.action = form.action.replace('/0', '/' + id);
            });
        });
    });
</script>
