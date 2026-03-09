<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Contact;
use App\Models\Product;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

use App\Mail\AdminNewEnquiry;
use App\Mail\UserContactConfirmation;

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

        return view('pages.home', compact('products', 'categories', 'settings'));
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

    public function contact_us_store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:150'],
            'phone' => ['nullable', 'string', 'max:30'],
            'description' => ['required', 'string', 'max:2000'],
            'proof_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        $proofImagePath = null;

        if ($request->hasFile('proof_image')) {
            $proofImagePath = $request->file('proof_image')->store('contacts', 'public');
        }

        $restrictedWords = ['seo', 'marketing', 'social media marketing', 'betting'];
        $messageContent = strtolower($validated['description']);

        foreach ($restrictedWords as $word) {
            if (str_contains($messageContent, strtolower($word))) {
                return back()->with('success', 'Thanks! Your message has been sent successfully.');
            }
        }

        if (str_contains(strtolower($validated['email']), 'xyz.com')) {
            return back()->with('success', 'Thanks! Your message has been sent successfully.');
        }



        // Save in DB
        $contact = Contact::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'description' => $validated['description'],
            'proof_image' => $proofImagePath,
        ]);

        // Mail data
        $mailData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'message' => $validated['description'],
            'proof_image_path' => $proofImagePath,
            'contact_id' => $contact->id,
        ];

        // 1) Admin mail
        Mail::to(env('ADMIN_ORDER_EMAIL', 'adrahanclothing@gmail.com'))
            ->queue(new AdminNewEnquiry($mailData));

        // 2) User confirmation mail
        Mail::to($validated['email'])
            ->queue(new UserContactConfirmation($mailData));

        return back()->with('success', 'Thanks! Your message has been sent successfully.');
    }

    public function our_mission()
    {
        return view('pages.our_mission');
    }
}
