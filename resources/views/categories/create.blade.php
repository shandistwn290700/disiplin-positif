@extends('layouts.main')

@section('content')
    <h1 class="text-xl font-bold mb-4">Tambah Kategori</h1>

    <x-validation-errors />

    <form method="POST" action="{{ route('categories.store') }}" class="bg-white shadow rounded p-6 space-y-4" x-data="{ type: 'negatif' }">
        @csrf

        <div>
            <label class="block text-sm font-medium mb-1">Tipe</label>
            <select name="type" id="type" class="w-full border rounded p-2" required
                    onchange="document.getElementById('severity-wrapper').style.display = this.value === 'negatif' ? 'block' : 'none'">
                <option value="negatif" {{ old('type', 'negatif') === 'negatif' ? 'selected' : '' }}>Pelanggaran (Negatif)</option>
                <option value="positif" {{ old('type') === 'positif' ? 'selected' : '' }}>Pencapaian (Positif)</option>
            </select>
        </div>

        <div id="severity-wrapper">
            <label class="block text-sm font-medium mb-1">Kategori Pelanggaran (Tingkat Keparahan)</label>
            <select name="severity" class="w-full border rounded p-2">
                <option value="ringan" {{ old('severity') === 'ringan' ? 'selected' : '' }}>Ringan</option>
                <option value="sedang" {{ old('severity') === 'sedang' ? 'selected' : '' }}>Sedang</option>
                <option value="berat" {{ old('severity') === 'berat' ? 'selected' : '' }}>Berat</option>
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Kode Poin (opsional)</label>
            <input type="text" name="code" value="{{ old('code') }}" placeholder="Contoh: P-05"
                   class="w-full border rounded p-2">
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Nama Pelanggaran / Pencapaian</label>
            <input type="text" name="name" value="{{ old('name') }}" placeholder="Contoh: Terlambat masuk kelas"
                   class="w-full border rounded p-2" required>
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Poin (gunakan minus untuk pelanggaran)</label>
            <input type="number" name="points" value="{{ old('points') }}" placeholder="Contoh: -3 atau 5"
                   class="w-full border rounded p-2" required>
        </div>

        <button type="submit" class="btn-primary w-full sm:w-auto">Simpan</button>
    </form>

    <script>
        // Sembunyikan field severity kalau tipe = positif, saat halaman pertama dimuat
        document.addEventListener('DOMContentLoaded', function () {
            const typeSelect = document.getElementById('type');
            const wrapper = document.getElementById('severity-wrapper');
            wrapper.style.display = typeSelect.value === 'negatif' ? 'block' : 'none';
        });
    </script>
@endsection
