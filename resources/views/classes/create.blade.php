@extends('layouts.main')

@section('content')
    <h1 class="text-xl font-bold mb-4">Tambah Kelas</h1>

    <x-validation-errors />

    <form method="POST" action="{{ route('classes.store') }}" class="bg-white shadow rounded p-6 space-y-4">
        @csrf

        <div>
            <label class="block text-sm font-medium mb-1">Nama Kelas</label>
            <input type="text" name="name" value="{{ old('name') }}" placeholder="Contoh: 1A - Abu Bakar Ash-Shidiq"
                   class="w-full border rounded p-2" required>
        </div>

        <button type="submit" class="btn-primary w-full sm:w-auto">Simpan</button>
    </form>
@endsection
