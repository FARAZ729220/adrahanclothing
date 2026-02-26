<x-admin.layout>

    <div class="container py-5">
        <div class="card my-5">
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

                <button type="submit"
                    style="background:#111; color:#fff; padding:10px 16px; border:none; border-radius:4px; cursor:pointer;">
                    Save Category
                </button>
            </form>
        </div>
    </div>

</x-admin.layout>
