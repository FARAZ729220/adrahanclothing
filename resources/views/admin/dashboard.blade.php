<x-admin.layout>
    <main class="container my-5">
        <div class="container mt-4">

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
                        <table class="admin-table" id="order-table">
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

                            <a href="{{ route('category.create') }}" class="btn btn-secondary" style="margin:10px"> Add
                                Category</a>
                        </div>
                        <table class="admin-table" id="category-table">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Created</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($categories->count() > 0)
                                    @foreach ($categories as $category)
                                        <tr>
                                            <td>{{ $category->name }}</td>
                                            <td>{{$category->created_at  }}</td>
                                            <td class="table-actions">
                                                <a href=""></a>
                                                <a href=""></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif

                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Products Tab -->
                <div class="tab-pane fade" id="products">
                    <div class="admin-table-wrapper">
                        <table class="admin-table" id="product-table">
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
                                <tr>
                                    <td><img src="https://via.placeholder.com/50" class="product-thumb"></td>
                                    <td>Camel Wool Overcoat</td>
                                    <td>$485</td>
                                    <td>In Stock</td>
                                    <td class="table-actions">✏️ 🗑️</td>
                                </tr>
                                <tr>
                                    <td><img src="https://via.placeholder.com/50" class="product-thumb"></td>
                                    <td>Cream Chinos</td>
                                    <td>$165</td>
                                    <td class="out-stock">Out of Stock</td>
                                    <td class="table-actions">✏️ 🗑️</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </main>
</x-admin.layout>
<script>
    $(document).ready(function() {
        $('#order-table').DataTable({
            responsive: true,
            'order': []
        });

         $('#category-table').DataTable({
            responsive: true,
            'order': []
        });

         $('#product-table').DataTable({
            responsive: true,
            'order': []
        });
    });

    function contact_delete(contactId) {
        console.log(contactId);
        Swal.fire({
            title: 'Are you sure?',
            text: "Do you really want to delete this item?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('b_form_' + contactId).submit();
            }
        });
    }
</script>
