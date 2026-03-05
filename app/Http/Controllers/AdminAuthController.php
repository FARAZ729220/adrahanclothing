<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    public function showLogin()
    {
        return view('admin.login');
    }

    public function admin_dashboard()
    {

        // Basic totals
        $totalOrders = Order::count();
        $totalCategories = Category::count();
        $totalProducts = Product::count();

        // ✅ Advanced counters
        $totalRevenue = Order::where('order_status', 'active')
            ->where('payment_status', 'paid')
            ->sum('grand_total');

        $pendingPayments = Order::where('order_status', 'active')
            ->whereIn('payment_status', ['unpaid', 'pending_verification'])
            ->count();

        $pendingDeliveries = Order::where('order_status', 'active')
            ->where('delivery_status', 'pending')
            ->count();

        $cancelledOrders = Order::where('order_status', 'cancelled')->count();

        $lowStockProducts = Product::where('stock', '>', 0)
            ->where('stock', '<=', 5)
            ->count();

        $outOfStockProducts = Product::where('stock', 0)->count();

        return view('admin.dashboard', compact(
            'totalOrders',
            'totalCategories',
            'totalProducts',
            'totalRevenue',
            'pendingPayments',
            'pendingDeliveries',
            'cancelledOrders',
            'outOfStockProducts',
            'lowStockProducts',
        ));
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string', 'min:6'],
        ]);

        // attempt login
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // role check (admin only)
            if (Auth::user()->role !== 'admin') {
                Auth::logout();

                return back()->withErrors([
                    'email' => 'You are not authorized to access admin panel.',
                ])->onlyInput('email');
            }

            return redirect()->route('admin.dashboard')->with('success', 'Welcome back!');
        }

        return back()->withErrors([
            'email' => 'Invalid credentials. Please try again.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login')->with('success', 'Logged out successfully.');
    }
}
