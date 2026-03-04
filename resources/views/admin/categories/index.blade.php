<x-admin.layout>

    <div class="admin-content-wrap">
        <div class="admin-panel">
            <div class="admin-panel-header">
                <h4 class="admin-title mb-0">Categories</h4>

                <button type="button" class="btn btn-theme" data-bs-toggle="modal" data-bs-target="#category">
                    <i class="bi bi-plus-circle me-2"></i> Add Category
                </button>
            </div>

            <div class="table-responsive">
                <table class="table theme-table align-middle" id="category-table">
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

                    <div class="modal fade" id="editcategory" tabindex="-1" aria-labelledby="editCategoryLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <form id="editCategoryForm" method="POST"
                                    action="{{ route('category.update', ['id' => 0]) }}" enctype="multipart/form-data">
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
                </table>
            </div>
        </div>
    </div>







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
