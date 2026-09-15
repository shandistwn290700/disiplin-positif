@extends('layouts.main')

@section('content')
    <h1 class="text-xl font-bold mb-4">Ubah Kelas</h1>

    <x-validation-errors />

    <form method="POST" action="{{ route('classes.update', $class) }}" class="bg-white shadow rounded p-6 space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-sm font-medium mb-1">Nama Kelas</label>
            <input type="text" name="name" value="{{ old('name', $class->name) }}"
                   class="w-full border rounded p-2" required>
        </div>

        <button type="submit" class="btn-primary w-full sm:w-auto">Simpan Perubahan</button>
    </form>
@endsection
