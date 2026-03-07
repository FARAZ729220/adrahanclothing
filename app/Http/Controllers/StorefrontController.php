<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Setting;
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
        $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:150'],
            'phone' => ['nullable', 'string', 'max:30'],
            'description' => ['required', 'string', 'max:2000'],
        ]);

        $proof_image = null;

        if ($request->hasFile('proof_image')) {
            $proof_image = $request->file('proof_image')->store('contacts', 'public');
        }

        $restrictedWords = ['SEO', 'marketing', 'social media marketing', 'betting'];
        $messageContent = strtolower($request->message);

        // Check if the message content contains any restricted words
        foreach ($restrictedWords as $word) {
            if (strpos($messageContent, strtolower($word)) !== false) {
                return back()->with('message', 'Contact Submitted successfully');
            }
        }

        // Check if the email contains a restricted domain
        if (str_contains(strtolower($request->email), 'xyz.com')) {
            return back()->with('message', 'Contact Submitted successfully');
        }

        if ($this->check_email($request->email)) {
            return redirect()->back()->with('message', 'Contact Submitted successfully');
        }

        // Save in DB
        $contact = Contact::create([
            'name'= $request->name,
        ]);

        // Prepare email data (same keys as your blade templates expect)
        $mailData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'proof' => $validated['proof_image'],
            'message' => $validated['description'],
            'phone' => $validated['phone'] ?? null,
        ];

        // 1) Send email to Admin
        Mail::to(env('ADMIN_ORDER_EMAIL', 'adrahanclothing@gmail.com'))
            ->queue(new AdminNewEnquiry($mailData));

        // 2) Send confirmation email to User
        Mail::to($validated['email'])
            ->queue(new UserContactConfirmation($mailData));

        return back()->with('success', 'Thanks! Your message has been sent successfully.');
    }

    public function our_mission()
    {
        return view('pages.our_mission');
    }
}
