<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Setting;
use App\Models\Product;
use Illuminate\Http\Request;

class StorefrontController extends Controller
{
    public function home()
    {
        $settings = Setting::first();
        $products = \App\Models\Product::where('is_active', true)
            ->latest()
            ->take(8) // home pe kitne show karne hain
            ->get();

        $categories = Category::where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('pages.home', compact('products', 'categories','settings'));
    }

    public function shop(Request $request)
    {
        $categories = Category::where('is_active', true)->orderBy('name')->get();

        $selectedSlug = $request->query('category'); // slug
        $selectedCategory = null;

        $productsQuery = Product::query()->where('is_active', true);

        if ($selectedSlug) {
            $selectedCategory = Category::where('slug', $selectedSlug)->where('is_active', true)->first();

            if ($selectedCategory) {
                $productsQuery->where('category_id', $selectedCategory->id);
            }
        }

        $products = $productsQuery->latest()->paginate(12)->withQueryString();

        return view('pages.shop', compact('categories', 'products', 'selectedCategory', 'selectedSlug'));
    }

    public function productShow($slug)
    {
        $product = Product::where('slug', $slug)->where('is_active', true)->firstOrFail();

        return view('pages.product_detail', compact('product'));
    }

    public function contact_us()
    {
        return view('pages.contact');
    }

    public function our_mission()
    {
        return view('pages.our_mission');
    }
}
