<x-admin.layout>
    <main class="container my-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <h2 class="form-title mb-5">Add New Product</h2>



                <form class="admin-form" method="POST" action="{{ route('product.update', $product->id) }}"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row g-4">

                        <div class="col-6">
                            <label class="form-label">PRODUCT NAME</label>
                            <input type="text" name="name" class="form-control"
                                value="{{ old('name', $product->name) }}" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">PRICE (USD)</label>
                            <input type="number" name="price" step="0.01" class="form-control"
                                value="{{ old('price', $product->price) }}" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">CATEGORY</label>
                            <select name="category_id" class="form-select" required>
                                <option value="">Select Category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ (int) old('category_id', $product->category_id) === (int) $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Size (comma separated)</label>
                            <input type="text" name="sizes" class="form-control"
                                value="{{ old('sizes', $sizesText) }}" placeholder="S, M, L, XL">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">DISCOUNT TYPE</label>
                            <select name="discount_type" class="form-control">
                                @php $dt = old('discount_type', $product->discount_type); @endphp
                                <option value="none" {{ $dt === 'none' ? 'selected' : '' }}>None</option>
                                <option value="fixed" {{ $dt === 'fixed' ? 'selected' : '' }}>Fixed</option>
                                <option value="percent" {{ $dt === 'percent' ? 'selected' : '' }}>Percentage</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">DISCOUNT VALUE</label>
                            <input type="number" name="discount_value" step="0.01" class="form-control"
                                value="{{ old('discount_value', $product->discount_value) }}">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">STOCK QUANTITY</label>
                            <input type="number" name="stock" class="form-control"
                                value="{{ old('stock', $product->stock) }}" required>
                        </div>

                        <div class="col-12">
                            <label class="form-label">DESCRIPTION</label>
                            <textarea name="description" class="form-control" rows="5">{{ old('description', $product->description) }}</textarea>
                        </div>

                        {{-- Existing images --}}
                        <div class="col-12">
                            <label class="form-label">EXISTING IMAGES</label>

                            @if (!empty($product->images) && count($product->images))
                                <div style="display:flex; gap:12px; flex-wrap:wrap;">
                                    @foreach ($product->images as $img)
                                        <div style="border:1px solid #ddd; padding:8px; border-radius:6px;">
                                            <img src="{{ asset('storage/' . $img) }}"
                                                style="width:90px; height:90px; object-fit:cover; display:block; margin-bottom:6px;">
                                            <label style="display:flex; gap:6px; align-items:center;">
                                                <input type="checkbox" name="remove_images[]"
                                                    value="{{ $img }}">
                                                Remove
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p>No images uploaded.</p>
                            @endif
                        </div>

                        {{-- Add new images --}}
                        <div class="col-12">
                            <label class="form-label">ADD NEW IMAGES</label>
                            <input type="file" name="images[]" multiple class="form-control">
                        </div>

                        <div class="col-12 mt-4 d-flex gap-3">
                            <button type="submit" class="btn-save" id="saveBtn">UPDATE PRODUCT</button>
                            <a href="{{ url('admin/products') }}" class="btn-cancel">CANCEL</a>
                        </div>

                    </div>
                </form>

            </div>
        </div>
    </main>
</x-admin.layout>

<script>
    document.querySelector('form.admin-form')?.addEventListener('submit', function() {
        const btn = document.getElementById('saveBtn');
        if (btn) {
            btn.disabled = true;
            btn.innerText = 'UPDATING...';
        }
    });
</script>
