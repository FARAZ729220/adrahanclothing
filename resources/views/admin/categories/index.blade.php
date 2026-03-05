<x-admin.layout>

    <main class="flex-grow-1 p-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="text-white fw-black m-0">Categories</h2>

            <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#category">
                <i class="bi bi-plus-circle me-2"></i> Add Category
            </button>
        </div>

        <div class="table-responsive">
            <table class="table table-dark custom-admin-table align-middle" id="category-table">
                <thead>
                    <tr>
                        <th class="text-secondary small fw-bold border-0">Name</th>
                        <th class="text-secondary small fw-bold border-0">Image</th>
                        <th class="text-secondary small fw-bold border-0">Status</th>
                        <th class="text-secondary small fw-bold border-0">Date</th>
                        <th class="text-secondary small fw-bold border-0">Actions</th>

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
                            <td class="text-secondary">
                                @if ($category->is_active)
                                    <span class="text-success">Active</span>
                                @else
                                    <span class="text-danger">Not Active</span>
                                @endif
                            </td>
                            <td class="fw-bold">{{ $category->created_at->format('d M Y') }}</td>
                            <td class="fw-bold"><button type="button" class="btn btn-secondary edit-btn-category"
                                    data-bs-toggle="modal" data-bs-target="#editcategory" data-id="{{ $category->id }}"
                                    data-name="{{ $category->name }}" data-active="{{ $category->is_active ? 1 : 0 }}"
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
                        <p>No Order at the moment</p>
                    @endforelse
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
                </tbody>
            </table>
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

    let categoryTable;

    $(document).ready(function() {

        // Initialize DataTable
        categoryTable = $('#category-table').DataTable();

        // Delete Category
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

                            categoryTable.row(row).remove().draw();

                            Swal.fire(
                                'Deleted!',
                                'Category has been deleted.',
                                'success'
                            );
                        },
                        error: function() {
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
