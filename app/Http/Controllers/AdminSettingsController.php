<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class AdminSettingsController extends Controller
{
    public function setting()
    {
        $settings = Setting::first();

        return view('admin.settings', compact('settings'));
    }

    public function setting_update(Request $request)
    {
        $request->validate([
            'shipping_fee' => ['required', 'integer', 'min:0'],
            'hero_title' => ['nullable', 'string', 'max:255'],
            'hero_subtitle' => ['nullable', 'string', 'max:255'],
            'hero_description' => ['nullable', 'string', 'max:1000'],
            'hero_image_1' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'hero_image_2' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'hero_image_3' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        ]);

        $settings = Setting::first();

        $settings->shipping_fee = $request->shipping_fee;
        $settings->free_shipping = $request->has('free_shipping');

        if ($request->hasFile('hero_image_1')) {
            $settings->hero_image_1 = $request->file('hero_image_1')->store('hero', 'public');
        }

        if ($request->hasFile('hero_image_2')) {
            $settings->hero_image_2 = $request->file('hero_image_2')->store('hero', 'public');
        }

        if ($request->hasFile('hero_image_3')) {
            $settings->hero_image_3 = $request->file('hero_image_3')->store('hero', 'public');
        }

        $settings->hero_title = $request->hero_title;
        $settings->hero_subtitle = $request->hero_subtitle;
        $settings->hero_description = $request->hero_description;

        $settings->save();

        return back()->with('success', 'Settings updated');

    }
}
