<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class AdminCategoryController extends Controller
{
    public function category_store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        // Unique slug
        $slugBase = Str::slug($validated['name']);
        $slug = $slugBase;
        $counter = 1;

        while (Category::where('slug', $slug)->exists()) {
            $slug = $slugBase.'-'.$counter;
            $counter++;
        }

        // Upload image
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('categories', 'public');
        }

        Category::create([
            'name' => $validated['name'],
            'slug' => $slug,
            'image' => $imagePath,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Category Created successfully.');
    }

    public function category_update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'remove_image' => ['nullable', 'boolean'],
        ]);

        // Update slug (unique)
        $slugBase = Str::slug($validated['name']);
        $slug = $slugBase;
        $counter = 1;

        while (Category::where('slug', $slug)->where('id', '!=', $id)->exists()) {
            $slug = $slugBase.'-'.$counter;
            $counter++;
        }

        // Remove image if checkbox checked
        if ($request->boolean('remove_image') && $category->image) {
            Storage::disk('public')->delete($category->image);
            $category->image = null;
        }

        // Replace image if new uploaded
        if ($request->hasFile('image')) {
            if ($category->image) {
                Storage::disk('public')->delete($category->image);
            }
            $category->image = $request->file('image')->store('categories', 'public');
        }

        $category->name = $validated['name'];
        $category->slug = $slug;
        $category->is_active = $request->has('is_active');
        $category->save();

        return redirect()->back()->with('success', 'Category updated successfully.');
    }

    public function category_destroy($id)
    {
        $category = Category::findOrFail($id);

        if ($category->image) {
            Storage::disk('public')->delete($category->image);
        }

        $category->delete();

        return redirect()->back()->with('success', 'Category deleted successfully.');
    }
}
