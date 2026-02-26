<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminCategoryController extends Controller
{
    public function create()
    {
        $categories = Category::latest()->paginate(20);

        return view('admin.category_create');
    }

    public function store(Request $request)
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
}
