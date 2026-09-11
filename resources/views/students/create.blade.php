@extends('layouts.main')

@section('content')
    <h1 class="text-xl font-bold mb-4">Tambah Siswa</h1>

    <form method="POST" action="{{ route('students.store') }}" class="bg-white shadow rounded p-6 space-y-4">
        @csrf

        <div>
            <label class="block text-sm font-medium mb-1">NIS</label>
            <input type="text" name="nis" value="{{ old('nis') }}" class="w-full border rounded p-2" required>
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Nama</label>
            <input type="text" name="name" value="{{ old('name') }}" class="w-full border rounded p-2" required>
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Kelas</label>
            <select name="class_id" class="w-full border rounded p-2" required>
                <option value="">-- Pilih Kelas --</option>
                @foreach($classes as $class)
                    <option value="{{ $class->id }}">{{ $class->name }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn-primary w-full sm:w-auto">Simpan</button>
    </form>
@endsection
