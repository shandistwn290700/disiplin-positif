<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ForcePasswordController extends Controller
{
    public function edit()
    {
        return view('auth.force-password');
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => [
                'required', 'confirmed',
                Password::defaults(),
            ],
        ], [
            'current_password.current_password' => 'Password saat ini yang kamu masukkan salah.',
        ]);

        $request->user()->update([
            'password' => Hash::make($validated['password']),
            'must_change_password' => false,
        ]);

        return redirect()->route('dashboard')->with('success', 'Password berhasil diganti. Selamat datang!');
    }
}
