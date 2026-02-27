<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminCategoryController extends Controller
{
    public function category_store(Request $request)
    {
        // 1️⃣ Validate input
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
        ]);

        // 2️⃣ Generate unique slug
        $slugBase = Str::slug($validated['name']);
        $slug = $slugBase;
        $counter = 1;

        while (Category::where('slug', $slug)->exists()) {
            $slug = $slugBase.'-'.$counter;
            $counter++;
        }

        // 3️⃣ Create category
        Category::create([
            'name' => $validated['name'],
            'slug' => $slug,
            'is_active' => $request->has('is_active'), // checkbox handling
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Category Created successfully.');

    }

    public function category_update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
        ]);

        $category->name = $validated['name'];
        $category->is_active = $request->has('is_active');

        // Optional: update slug if name changes
        $slugBase = Str::slug($validated['name']);
        $slug = $slugBase;
        $counter = 1;

        while (Category::where('slug', $slug)->where('id', '!=', $id)->exists()) {
            $slug = $slugBase.'-'.$counter;
            $counter++;
        }
        $category->slug = $slug;

        $category->save();

        return redirect()->back()->with('success', 'Category updated successfully.');
    }

    public function category_destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect()->back()->with('success', 'Category deleted successfully.');
    }
}
