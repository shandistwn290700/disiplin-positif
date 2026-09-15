<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

// Semua method dibatasi middleware role:admin di routes/web.php
class CategoryController extends Controller
{
    public function index()
    {
        // Natural sort berdasarkan kode: huruf diurutkan alfabet, angka diurutkan dari yang
        // terkecil (bukan diurutkan sebagai teks biasa, supaya "P-2" tidak muncul setelah "P-10").
        // Kalau kode kosong, jatuh ke nama sebagai gantinya.
        $categories = Category::all()->sort(function ($a, $b) {
            return strnatcasecmp($a->code ?: $a->name, $b->code ?: $b->name);
        })->values();

        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'code' => ['nullable', 'string', 'max:50', 'unique:categories,code'],
            'type' => ['required', 'in:positif,negatif'],
            'severity' => ['nullable', 'required_if:type,negatif', 'in:ringan,sedang,berat'],
            'points' => ['required', 'integer'],
        ]);

        // Kategori positif tidak punya tingkat keparahan
        if ($validated['type'] === 'positif') {
            $validated['severity'] = null;
        }

        Category::create($validated);

        return redirect()->route('categories.index')->with('success', 'Kategori ditambahkan.');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return back()->with('success', 'Kategori dihapus.');
    }
}
