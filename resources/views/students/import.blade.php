@extends('layouts.main')

@section('content')
    <h1 class="text-xl font-bold mb-4">Import Siswa dari Excel</h1>

    @if($errors->any())
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4 text-sm">
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-blue-50 text-blue-800 text-sm p-4 rounded mb-4">
        <p class="font-medium mb-2">Format file Excel (.xlsx / .xls / .csv):</p>
        <p>Baris pertama adalah header (akan dilewati otomatis). Kolom yang dibaca:</p>

        <table class="mt-2 text-xs bg-white rounded w-full">
            <thead>
                <tr class="bg-gray-100">
                    <th class="p-2 text-left border">Kolom A: NIS</th>
                    <th class="p-2 text-left border">Kolom B: Nama</th>
                    <th class="p-2 text-left border">Kolom C: Kelas</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="p-2 border">q23312</td>
                    <td class="p-2 border">Shandi Sutiawan</td>
                    <td class="p-2 border">1A</td>
                </tr>
                <tr>
                    <td class="p-2 border">q23313</td>
                    <td class="p-2 border">Fulan bin Fulan</td>
                    <td class="p-2 border">6B</td>
                </tr>
            </tbody>
        </table>

        <p class="mt-2">
            Kolom "Kelas" cukup diisi kode singkatnya saja (1A, 1B, 2A, ... 6B) —
            tidak perlu tulis nama sahabat Nabi lengkapnya. Kode harus sesuai
            dengan kelas yang sudah terdaftar di menu Kategori Kelas.
        </p>
    </div>

    <form method="POST" action="{{ route('students.import') }}" enctype="multipart/form-data"
          class="bg-white shadow rounded p-6 space-y-4">
        @csrf

        <div>
            <label class="block text-sm font-medium mb-1">File Excel</label>
            <input type="file" name="excel_file" accept=".xlsx,.xls,.csv" class="w-full border rounded p-2" required>
        </div>

        <button type="submit" class="btn-primary w-full sm:w-auto">Import dari Excel</button>
    </form>
@endsection
