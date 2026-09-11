<?php

namespace App\Http\Controllers;

use App\Models\SchoolClass;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

// Semua method dibatasi middleware role:admin di routes/web.php
class UserController extends Controller
{
    /**
     * Daftar akun. Urutan: guru dikelompokkan per kelas (1A s.d. 6B, alfabet nama di dalamnya),
     * lalu akun admin (tidak terikat kelas) di bagian akhir, urut alfabet nama.
     */
    public function index()
    {
        $users = User::with('schoolClass')
            ->select('users.*')
            ->leftJoin('classes', 'classes.id', '=', 'users.class_id')
            ->orderByRaw('CASE WHEN users.class_id IS NULL THEN 1 ELSE 0 END')
            ->orderBy('classes.name')
            ->orderBy('users.name')
            ->paginate(20);

        return view('users.index', compact('users'));
    }

    public function create()
    {
        $classes = SchoolClass::orderBy('name')->get();
        return view('users.create', compact('classes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
            'role' => ['required', 'in:admin,guru'],
            'class_id' => ['nullable', 'required_if:role,guru', 'exists:classes,id'],
        ]);

        // Admin tidak perlu terhubung ke kelas manapun
        if ($validated['role'] === 'admin') {
            $validated['class_id'] = null;
        }

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'class_id' => $validated['class_id'] ?? null,
        ]);

        return redirect()->route('users.index')->with('success', 'Akun berhasil dibuat.');
    }

    public function destroy(Request $request, User $user)
    {
        // Admin tidak bisa menghapus akunnya sendiri lewat halaman ini,
        // supaya tidak ada kejadian semua akun admin terhapus dan tidak ada yang bisa masuk lagi.
        if ($user->id === $request->user()->id) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $user->delete();

        return back()->with('success', 'Akun dihapus.');
    }

    public function edit(User $user)
    {
        $classes = SchoolClass::orderBy('name')->get();
        return view('users.edit', compact('user', 'classes'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email,' . $user->id],
            'password' => ['nullable', 'string', 'min:8'],
            'role' => ['required', 'in:admin,guru'],
            'class_id' => ['nullable', 'required_if:role,guru', 'exists:classes,id'],
        ]);

        if ($validated['role'] === 'admin') {
            $validated['class_id'] = null;
        }

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->role = $validated['role'];
        $user->class_id = $validated['class_id'];

        // Password hanya diganti kalau diisi; kalau dikosongkan, password lama tetap dipakai
        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return redirect()->route('users.index')->with('success', 'Akun diperbarui.');
    }
}
