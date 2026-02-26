<x-admin.layout>
    <main class="container my-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <h2 class="form-title mb-5">Add New Product</h2>

                <form class="admin-form">
                    <div class="row g-4">
                        <div class="col-6">
                            <label class="form-label">PRODUCT NAME</label>
                            <input type="text" class="form-control" placeholder="e.g. Silk Knit Polo" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">PRICE (USD)</label>
                            <input type="number" class="form-control" placeholder="0.00" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">CATEGORY</label>
                            <select class="form-select">
                                <option selected>Select Category</option>
                                <option>Blazers & Coats</option>
                                <option>Shirts & Polos</option>
                                <option>Trousers</option>
                                <option>Knitwear</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Size</label>
                            <input type="text" class="form-control" placeholder="X, XL, M, S, L" required>
                        </div>


                        <div class="col-md-6">
                            <label class="form-label">DISCOUNT PRICE (OPTIONAL)</label>
                            <select name="" id="" class="form-control">
                                <option value="">None</option>
                                <option value="">Fixed</option>
                                <option value="">Percentage</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">STOCK QUANTITY</label>
                            <input type="checkbox" name="" id="">
                        </div>

                        <div class="col-12">
                            <label class="form-label">DESCRIPTION</label>
                            <textarea class="form-control" rows="5" placeholder="Describe the material, fit, and style..."></textarea>
                        </div>

                        <div class="col-12">
                            <label class="form-label">PRODUCT IMAGE</label>
                            <div class="image-upload-box">
                                <i class="bi bi-cloud-upload"></i>
                                <p>Click to upload or drag and drop</p>
                                <input type="file" class="file-input">
                            </div>
                        </div>

                        <div class="col-12 mt-5 d-flex gap-3">
                            <button type="submit" class="btn-save">SAVE PRODUCT</button>
                            <button type="button" class="btn-cancel">CANCEL</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </main>
</x-admin.layout>
