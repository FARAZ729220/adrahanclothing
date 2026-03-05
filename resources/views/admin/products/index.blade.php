<x-admin.layout>


    <main class="flex-grow-1 p-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="text-white fw-black m-0">Products</h2>

            <a href="{{ route('product.create') }}" class="btn btn-secondary">
                <i class="bi bi-plus-circle me-2"></i> Add Products
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-dark custom-admin-table align-middle" id="product-table">
                <thead>
                    <tr>
                        <th class="text-secondary small fw-bold border-0">Image</th>
                        <th class="text-secondary small fw-bold border-0">Name</th>
                        <th class="text-secondary small fw-bold border-0">Price</th>
                        <th class="text-secondary small fw-bold border-0">Stock</th>
                        <th class="text-secondary small fw-bold border-0">Actions</th>

                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                        <tr>

                            <td>
                                @if (!empty($product->images) && is_array($product->images) && count($product->images) > 0)
                                    <img src="{{ asset('storage/' . $product->images[0]) }}" width="50"
                                        class="product-thumb">
                                @else
                                    No Image
                                @endif
                            </td>
                            <td class="text-secondary">{{ $product->name ?? '—' }}</td>
                            <td class="fw-bold">Rs {{ number_format($product->price ?? 0, 2) }}</td>
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

                            <td><a href="{{ route('product.edit', $product->id) }}" class="btn btn-secondary">✏️</a>

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
                        <p>No Order at the moment</p>
                    @endforelse

                </tbody>
            </table>
        </div>
    </main>
</x-admin.layout>


<script>
    let productTable;

    $(document).ready(function() {

        // Initialize DataTable
        productTable = $('#product-table').DataTable();

        // Delete Product
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

                            productTable.row(row).remove().draw();

                            Swal.fire(
                                'Deleted!',
                                'Product has been deleted.',
                                'success'
                            );

                        },
                        error: function(xhr) {
                            console.log(xhr.responseText);
                            Swal.fire(
                                'Error!',
                                'Something went wrong.',
                                'error'
                            );
                        }

                    });

                }

            });

        });

    });
</script>
