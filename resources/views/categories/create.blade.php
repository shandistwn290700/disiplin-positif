@extends('layouts.main')

@section('content')
    <x-page-header title="Tambah Kategori" subtitle="Tentukan jenis perilaku dan bobot poinnya." :back="route('categories.index')" />

    <div class="max-w-2xl">
        <x-validation-errors />

        <form method="POST" action="{{ route('categories.store') }}" class="card" x-data="{ type: 'negatif' }">
            @csrf

            <div class="card-body space-y-5">
                <div class="grid sm:grid-cols-2 gap-5">
                    <div>
                        <label class="form-label">Tipe</label>
                        <select name="type" id="type" class="form-control w-full" required
                                onchange="document.getElementById('severity-wrapper').style.display = this.value === 'negatif' ? 'block' : 'none'">
                            <option value="negatif" {{ old('type', 'negatif') === 'negatif' ? 'selected' : '' }}>Pelanggaran (Negatif)</option>
                            <option value="positif" {{ old('type') === 'positif' ? 'selected' : '' }}>Pencapaian (Positif)</option>
                        </select>
                    </div>

                    <div id="severity-wrapper">
                        <label class="form-label">Tingkat Keparahan</label>
                        <select name="severity" class="form-control w-full">
                            <option value="ringan" {{ old('severity') === 'ringan' ? 'selected' : '' }}>Ringan</option>
                            <option value="sedang" {{ old('severity') === 'sedang' ? 'selected' : '' }}>Sedang</option>
                            <option value="berat" {{ old('severity') === 'berat' ? 'selected' : '' }}>Berat</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="form-label">Kode Poin <span class="font-normal text-slate-400">(opsional)</span></label>
                    <input type="text" name="code" value="{{ old('code') }}" placeholder="Contoh: P-05"
                           class="form-control w-full sm:w-48">
                </div>

                <div>
                    <label class="form-label">Nama Pelanggaran / Pencapaian</label>
                    <input type="text" name="name" value="{{ old('name') }}" placeholder="Contoh: Terlambat masuk kelas"
                           class="form-control w-full" required>
                </div>

                <div>
                    <label class="form-label">Poin</label>
                    <input type="number" name="points" value="{{ old('points') }}" placeholder="Contoh: -3 atau 5"
                           class="form-control w-full sm:w-48" required>
                    <p class="form-hint">Gunakan angka minus untuk pelanggaran.</p>
                </div>
            </div>

            <div class="card-footer flex flex-col-reverse sm:flex-row sm:justify-end gap-2">
                <a href="{{ route('categories.index') }}" class="btn-secondary w-full sm:w-auto">Batal</a>
                <button type="submit" class="btn-primary w-full sm:w-auto">
                    <x-icon name="check" />
                    Simpan
                </button>
            </div>
        </form>
    </div>

    <script>
        // Sembunyikan field severity kalau tipe = positif, saat halaman pertama dimuat
        document.addEventListener('DOMContentLoaded', function () {
            const typeSelect = document.getElementById('type');
            const wrapper = document.getElementById('severity-wrapper');
            wrapper.style.display = typeSelect.value === 'negatif' ? 'block' : 'none';
        });
    </script>
@endsection
