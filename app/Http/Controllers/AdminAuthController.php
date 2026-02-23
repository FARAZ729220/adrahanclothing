<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminAuthController extends Controller
{
    public function showLogin()
    {
        return view('admin.login');
    }

    public function admin_dashboard()
    {

        $contact_count = Contact::count();
        $portfolio_count = Portfolio::count();

        return view('admin.dashboard', ['contact_count' => $contact_count,  'portfolio_count' => $portfolio_count]);
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
}
