<?php
namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminCategoryController extends Controller
{
    // GET /api/admin/categories
    public function index()
    {
        $categories = Category::latest()->paginate(20);

        return response()->json($categories);
    }

    // GET /api/admin/categories/{id}
    public function show($id)
    {
        $category = Category::findOrFail($id);

        return response()->json($category);
    }

    // POST /api/admin/categories
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $slugBase = Str::slug($data['name']);
        $slug = $this->uniqueSlug($slugBase);

        $category = Category::create([
            'name' => $data['name'],
            'slug' => $slug,
            'is_active' => $data['is_active'] ?? true,
        ]);

        return response()->json([
            'message' => 'Category created',
            'category' => $category,
        ], 201);
    }

    // PUT /api/admin/categories/{id}
    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        // If name changes, update slug too (and keep it unique)
        if ($category->name !== $data['name']) {
            $slugBase = Str::slug($data['name']);
            $category->slug = $this->uniqueSlug($slugBase, $category->id);
        }

        $category->name = $data['name'];
        if ($request->has('is_active')) {
            $category->is_active = (bool) $data['is_active'];
        }

        $category->save();

        return response()->json([
            'message' => 'Category updated',
            'category' => $category,
        ]);
    }

    // DELETE /api/admin/categories/{id}
    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        // Because we are NOT using foreign keys, do manual check:
        $hasProducts = Product::where('category_id', $category->id)->exists();
        if ($hasProducts) {
            return response()->json([
                'message' => 'Cannot delete: category has products. Move/delete products first.',
            ], 422);
        }

        $category->delete();

        return response()->json(['message' => 'Category deleted']);
    }

    private function uniqueSlug(string $baseSlug, ?int $ignoreId = null): string
    {
        $slug = $baseSlug;
        $i = 1;

        while (true) {
            $query = Category::where('slug', $slug);
            if ($ignoreId) {
                $query->where('id', '!=', $ignoreId);
            }

            if (! $query->exists()) {
                break;
            }

            $slug = $baseSlug.'-'.$i;
            $i++;
        }

        return $slug;
    }
}
