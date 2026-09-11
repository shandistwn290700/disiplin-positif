@extends('layouts.main')

@section('content')
    <h1 class="text-xl font-bold mb-4">Ubah Data Siswa</h1>

    @if($errors->any())
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4 text-sm">
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('students.update', $student) }}" class="bg-white shadow rounded p-6 space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-sm font-medium mb-1">NIS</label>
            <input type="text" name="nis" value="{{ old('nis', $student->nis) }}" class="w-full border rounded p-2" required>
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Nama</label>
            <input type="text" name="name" value="{{ old('name', $student->name) }}" class="w-full border rounded p-2" required>
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Kelas</label>
            <select name="class_id" class="w-full border rounded p-2" required>
                @foreach($classes as $class)
                    <option value="{{ $class->id }}" @selected(old('class_id', $student->class_id) == $class->id)>
                        {{ $class->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn-primary w-full sm:w-auto">Simpan Perubahan</button>
    </form>
@endsection
