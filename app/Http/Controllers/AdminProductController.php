<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class AdminProductController extends Controller
{
    public function product_index()
    {
        $products = Product::latest()->get();

        return view('admin.products.index', compact('products'));
    }

    public function product_create()
    {
        $categories = Category::where('is_active', true)->get();

        return view('admin.products.product_create', compact('categories'));
    }

    public function product_store(Request $request)
    {
        // 1) Validate request (ORM check for category via exists rule)
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'min:0'],
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'sizes' => ['nullable', 'string', 'max:255'],
            'discount_type' => ['required', 'in:none,fixed,percent'],
            'discount_value' => ['nullable', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'description' => ['nullable', 'string'],
            'images' => ['nullable', 'array'],
            'images.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        // 2) Extra ORM safety (optional but clean): ensure category exists
        Category::findOrFail($validated['category_id']);

        // 3) Parse sizes (comma separated -> array)
        $sizesArray = [];
        if (! empty($validated['sizes'])) {
            $sizesArray = collect(explode(',', $validated['sizes']))
                ->map(fn ($s) => strtoupper(trim($s)))
                ->filter()
                ->unique()
                ->values()
                ->all();
        }

        // 4) Discount rules
        $discountValue = (float) ($validated['discount_value'] ?? 0);

        if ($validated['discount_type'] === 'none') {
            $discountValue = 0;
        } elseif ($validated['discount_type'] === 'percent') {
            if ($discountValue > 100) {
                return back()
                    ->withErrors(['discount_value' => 'Percentage discount cannot be more than 100.'])
                    ->withInput();
            }
        } elseif ($validated['discount_type'] === 'fixed') {
            if ($discountValue > (float) $validated['price']) {
                return back()
                    ->withErrors(['discount_value' => 'Fixed discount cannot be more than the product price.'])
                    ->withInput();
            }
        }

        // 5) Unique slug (ORM check)
        $slugBase = Str::slug($validated['name']);
        $slug = $slugBase;
        $i = 1;

        while (Product::where('slug', $slug)->exists()) {
            $slug = $slugBase.'-'.$i;
            $i++;
        }

        // 6) Upload multiple images
        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imagePaths[] = $image->store('products', 'public');
            }
        }

        // 7) Create using Eloquent ORM
        Product::create([
            'category_id' => $validated['category_id'],
            'name' => $validated['name'],
            'slug' => $slug,
            'description' => $validated['description'] ?? null,
            'price' => $validated['price'],
            'stock' => $validated['stock'],
            'sizes' => $sizesArray,
            'discount_type' => $validated['discount_type'],
            'discount_value' => $discountValue,
            'images' => $imagePaths,
            'is_active' => true,
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Product created successfully.');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::where('is_active', true)->get();

        // For input display: sizes array -> "S, M, L"
        $sizesText = is_array($product->sizes) ? implode(', ', $product->sizes) : '';

        return view('admin.products.product_edit', compact('product', 'categories', 'sizesText'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        // Validate (block duplicate name in same category except this product)
        $validated = $request->validate([
            'name' => [
                'required', 'string', 'max:255',
                Rule::unique('products')->where(fn ($q) => $q->where('category_id', $request->category_id))
                    ->ignore($product->id),
            ],
            'price' => ['required', 'numeric', 'min:0'],
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'sizes' => ['nullable', 'string', 'max:255'],
            'discount_type' => ['required', 'in:none,fixed,percent'],
            'discount_value' => ['nullable', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'description' => ['nullable', 'string'],
            'images' => ['nullable', 'array'],
            'images.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'remove_images' => ['nullable', 'array'],
            'remove_images.*' => ['string'],
        ]);

        // ✅ Auto active/inactive based on stock
        $isActive = ((int) $validated['stock'] > 0);

        // Parse sizes
        $sizesArray = [];
        if (! empty($validated['sizes'])) {
            $sizesArray = collect(explode(',', $validated['sizes']))
                ->map(fn ($s) => strtoupper(trim($s)))
                ->filter()
                ->unique()
                ->values()
                ->all();
        }

        // Discount rules
        $discountValue = (float) ($validated['discount_value'] ?? 0);
        if ($validated['discount_type'] === 'none') {
            $discountValue = 0;
        }

        if ($validated['discount_type'] === 'percent' && $discountValue > 100) {
            return back()->withErrors(['discount_value' => 'Percentage discount cannot be more than 100.'])->withInput();
        }

        if ($validated['discount_type'] === 'fixed' && $discountValue > (float) $validated['price']) {
            return back()->withErrors(['discount_value' => 'Fixed discount cannot be more than the product price.'])->withInput();
        }

        // Slug update if name changed
        if ($product->name !== $validated['name']) {
            $slugBase = Str::slug($validated['name']);
            $slug = $slugBase;
            $i = 1;

            while (Product::where('slug', $slug)->where('id', '!=', $product->id)->exists()) {
                $slug = $slugBase.'-'.$i;
                $i++;
            }
            $product->slug = $slug;
        }

        // Current images
        $currentImages = is_array($product->images) ? $product->images : [];

        // Remove images if selected
        $removeImages = $validated['remove_images'] ?? [];
        if (! empty($removeImages)) {
            foreach ($removeImages as $img) {
                if (in_array($img, $currentImages, true)) {
                    Storage::disk('public')->delete($img);
                }
            }
            $currentImages = array_values(array_diff($currentImages, $removeImages));
        }

        // Append new images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $currentImages[] = $image->store('products', 'public');
            }
        }

        // ✅ Update product
        $product->update([
            'category_id' => $validated['category_id'],
            'name' => $validated['name'],
            'price' => $validated['price'],
            'stock' => $validated['stock'],
            'is_active' => $isActive, // ✅ important
            'sizes' => $sizesArray,
            'discount_type' => $validated['discount_type'],
            'discount_value' => $discountValue,
            'description' => $validated['description'] ?? null,
            'images' => $currentImages,
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Product updated successfully.');
    }

    public function product_destroy($id)
    {
        $product = Product::findOrFail($id);

        // Delete all images from storage
        if (is_array($product->images) && count($product->images) > 0) {
            foreach ($product->images as $image) {
                Storage::disk('public')->delete($image);
            }
        }

        // Delete product record
        $product->delete();

        return redirect()->route('admin.dashboard')
            ->with('success', 'Product deleted successfully.');
    }
}
