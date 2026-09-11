@extends('layouts.main')

@section('content')
    <h1 class="text-xl font-bold mb-4">Tambah Catatan Disiplin</h1>

    @if($errors->any())
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4 text-sm">
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('records.store') }}" class="bg-white shadow rounded p-6 space-y-4">
        @csrf

        <div>
            <label class="block text-sm font-medium mb-1">Siswa</label>
            <select name="student_id" class="w-full border rounded p-2" required>
                <option value="">-- Pilih Siswa --</option>
                @foreach($students as $student)
                    <option value="{{ $student->id }}" @selected(old('student_id') == $student->id)>
                        {{ $student->name }} ({{ $student->nis }})
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Kategori Pelanggaran / Pencapaian</label>
            <select name="category_id" class="w-full border rounded p-2" required>
                <option value="">-- Pilih Kategori --</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>
                        @if($category->code)[{{ $category->code }}] @endif
                        {{ $category->name }}
                        @if($category->severityLabel())({{ $category->severityLabel() }})@endif
                        {{ $category->points > 0 ? '+' : '' }}{{ $category->points }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Tanggal</label>
            <input type="date" name="date" value="{{ old('date', date('Y-m-d')) }}"
                   class="w-full border rounded p-2" required>
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Deskripsi (opsional)</label>
            <textarea name="description" rows="3" class="w-full border rounded p-2">{{ old('description') }}</textarea>
        </div>

        <button type="submit" class="btn-primary w-full sm:w-auto">Simpan</button>
    </form>
@endsection
