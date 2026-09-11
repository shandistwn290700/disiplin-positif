<?php

namespace App\Http\Controllers;

use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

// Method dibatasi middleware role:admin di routes/web.php
class SiteSettingController extends Controller
{
    public function edit()
    {
        $setting = SiteSetting::current();
        return view('settings.edit', compact('setting'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'hero_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'favicon' => ['nullable', 'image', 'mimes:png,ico', 'max:1024'],
        ]);

        $setting = SiteSetting::current();
        $updates = [];

        if ($request->hasFile('hero_image')) {
            if ($setting->hero_image) {
                Storage::disk('public')->delete($setting->hero_image);
            }
            $updates['hero_image'] = $request->file('hero_image')->store('hero', 'public');
        }

        if ($request->hasFile('favicon')) {
            if ($setting->favicon) {
                Storage::disk('public')->delete($setting->favicon);
            }
            $updates['favicon'] = $request->file('favicon')->store('favicon', 'public');
        }

        if (empty($updates)) {
            return back()->with('error', 'Pilih minimal satu gambar untuk diunggah.');
        }

        $setting->update($updates);

        return redirect()->route('settings.edit')->with('success', 'Pengaturan tampilan berhasil diperbarui.');
    }

    public function updateWelcomeMessage(Request $request)
    {
        $validated = $request->validate([
            'welcome_message' => ['nullable', 'string', 'max:500'],
        ]);

        SiteSetting::current()->update($validated);

        return redirect()->route('settings.edit')->with('success', 'Pesan selamat datang berhasil diperbarui.');
    }
}
