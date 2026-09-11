<?php

namespace App\Http\Controllers;

use App\Models\SchoolClass;
use Illuminate\Http\Request;

// Semua method dibatasi middleware role:admin di routes/web.php
class SchoolClassController extends Controller
{
    public function index()
    {
        $classes = SchoolClass::withCount('students')->orderBy('name')->get();
        return view('classes.index', compact('classes'));
    }

    public function create()
    {
        return view('classes.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:classes,name'],
        ]);

        SchoolClass::create($validated);

        return redirect()->route('classes.index')->with('success', 'Kelas ditambahkan.');
    }

    public function edit(SchoolClass $class)
    {
        return view('classes.edit', compact('class'));
    }

    public function update(Request $request, SchoolClass $class)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:classes,name,' . $class->id],
        ]);

        $class->update($validated);

        return redirect()->route('classes.index')->with('success', 'Kelas diperbarui.');
    }

    public function destroy(SchoolClass $class)
    {
        // Cegah hapus kelas yang masih punya siswa, supaya tidak ada siswa "yatim" tanpa kelas
        if ($class->students()->exists()) {
            return back()->with('error', 'Kelas tidak bisa dihapus karena masih ada siswa di dalamnya.');
        }

        $class->delete();

        return back()->with('success', 'Kelas dihapus.');
    }
}
