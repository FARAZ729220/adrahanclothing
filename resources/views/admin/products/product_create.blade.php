<x-admin.layout>

    <main class="container my-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="form-title text-white m-0">Add Product</h2>

                    <a href="{{ route('product.index') }}" class="btn-back">
                        <i class="bi bi-arrow-left me-2"></i> Back to Products
                    </a>
                </div>

                <div class="admin-card">

                    <form class="admin-form" method="POST" action="{{ route('product.store') }}"
                        enctype="multipart/form-data">

                        @csrf

                        <div class="row g-4">

                            <!-- PRODUCT NAME -->
                            <div class="col-6">
                                <label class="form-label">PRODUCT NAME</label>
                                <input type="text" name="name" class="form-control"
                                    placeholder="e.g. Silk Knit Polo" required>
                            </div>

                            <!-- PRICE -->
                            <div class="col-md-6">
                                <label class="form-label">PRICE (USD)</label>
                                <input type="number" name="price" step="0.01" class="form-control"
                                    placeholder="0.00" required>
                            </div>

                            <!-- CATEGORY -->
                            <div class="col-md-6">
                                <label class="form-label">CATEGORY</label>
                                <select name="category_id" class="form-select" required>
                                    <option value="">Select Category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- SIZES -->
                            <div class="col-md-6">
                                <label class="form-label">Size (comma separated)</label>
                                <input type="text" name="sizes" class="form-control" placeholder="S, M, L, XL">
                            </div>

                            <!-- DISCOUNT TYPE -->
                            <div class="col-md-6">
                                <label class="form-label">DISCOUNT TYPE</label>
                                <select name="discount_type" class="form-control">
                                    <option value="none">None</option>
                                    <option value="fixed">Fixed</option>
                                    <option value="percent">Percentage</option>
                                </select>
                            </div>

                            <!-- DISCOUNT VALUE -->
                            <div class="col-md-6">
                                <label class="form-label">DISCOUNT VALUE</label>
                                <input type="number" name="discount_value" step="0.01" class="form-control"
                                    placeholder="Enter value">
                            </div>

                            <!-- STOCK QUANTITY -->
                            <div class="col-md-6">
                                <label class="form-label">STOCK QUANTITY</label>
                                <input type="number" name="stock" class="form-control"
                                    placeholder="Enter stock quantity" required>
                            </div>

                            <!-- DESCRIPTION -->
                            <div class="col-12">
                                <label class="form-label">DESCRIPTION</label>
                                <textarea name="description" class="form-control" rows="5" placeholder="Describe the material, fit, and style..."></textarea>
                            </div>

                            <!-- MULTIPLE IMAGES -->
                            <div class="col-12">
                                <label class="form-label">PRODUCT IMAGES</label>
                                <input type="file" name="images[]" multiple class="form-control">
                            </div>

                            <!-- BUTTONS -->
                            <div class="col-12 mt-5 d-flex gap-3">
                                <button type="submit" class="btn-save">SAVE PRODUCT</button>
                                
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
</x-admin.layout>
