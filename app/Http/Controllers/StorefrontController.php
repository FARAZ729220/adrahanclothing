<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;

class StorefrontController extends Controller
{
    public function categories() {
        return response()->json(Category::where('is_active', true)->get());
    }

    public function products() {
        return response()->json(Product::visible()->latest()->paginate(12));
    }

    public function productsByCategory($categoryId) {
        return response()->json(
            Product::visible()->where('category_id', $categoryId)->paginate(12)
        );
    }

    public function productDetail($slug) {
        $product = Product::visible()->where('slug', $slug)->firstOrFail();
        return response()->json([
            'product' => $product,
            'final_price' => $product->finalPrice(),
        ]);
    }
}

