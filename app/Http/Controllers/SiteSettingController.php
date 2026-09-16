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

        try {
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
        } catch (\Throwable $e) {
            report($e);

            return back()->with('error', 'Gagal menyimpan file. Pastikan ukuran file tidak terlalu besar dan coba lagi.');
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

    public function updateSchoolIdentity(Request $request)
    {
        $validated = $request->validate([
            'school_government_line' => ['nullable', 'string', 'max:255'],
            'school_name' => ['nullable', 'string', 'max:255'],
            'school_address' => ['nullable', 'string', 'max:255'],
            'school_email' => ['nullable', 'email', 'max:255'],
            'school_city' => ['nullable', 'string', 'max:100'],
            'waka_kesiswaan_name' => ['nullable', 'string', 'max:255'],
            'principal_name' => ['nullable', 'string', 'max:255'],
            'summon_letter_threshold' => ['required', 'integer', 'lt:0'],
            'government_logo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:1024'],
            'school_logo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:1024'],
        ]);

        $setting = SiteSetting::current();

        try {
            if ($request->hasFile('government_logo')) {
                if ($setting->government_logo) {
                    Storage::disk('public')->delete($setting->government_logo);
                }
                $validated['government_logo'] = $request->file('government_logo')->store('logo', 'public');
            } else {
                unset($validated['government_logo']);
            }

            if ($request->hasFile('school_logo')) {
                if ($setting->school_logo) {
                    Storage::disk('public')->delete($setting->school_logo);
                }
                $validated['school_logo'] = $request->file('school_logo')->store('logo', 'public');
            } else {
                unset($validated['school_logo']);
            }
        } catch (\Throwable $e) {
            report($e);

            return back()->with('error', 'Gagal mengunggah logo. Silakan coba lagi.');
        }

        $setting->update($validated);

        return redirect()->route('settings.edit')->with('success', 'Identitas sekolah berhasil diperbarui.');
    }
}
