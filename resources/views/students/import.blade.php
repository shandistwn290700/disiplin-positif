@extends('layouts.main')

@section('content')
    <x-page-header title="Import Siswa dari Excel" subtitle="Tambahkan banyak siswa sekaligus dari satu file." :back="route('students.index')" />

    <div class="max-w-3xl space-y-5">
        <x-validation-errors />

        <div class="card">
            <div class="card-header">
                <span class="icon-tile bg-brand-50 text-brand-600"><x-icon name="info" /></span>
                <div>
                    <h2 class="section-title">Format file Excel (.xlsx / .xls / .csv)</h2>
                    <p class="section-subtitle">Baris pertama adalah header (akan dilewati otomatis). Kolom yang dibaca:</p>
                </div>
            </div>

            <div class="card-body space-y-4">
                <div class="overflow-x-auto rounded-xl border border-slate-200">
                    <table class="w-full text-xs">
                        <thead>
                            <tr class="bg-slate-50 text-slate-500">
                                <th class="px-3 py-2.5 text-left font-semibold border-b border-slate-200">Kolom A: NIS</th>
                                <th class="px-3 py-2.5 text-left font-semibold border-b border-slate-200">Kolom B: Nama</th>
                                <th class="px-3 py-2.5 text-left font-semibold border-b border-slate-200">Kolom C: Kelas</th>
                            </tr>
                        </thead>
                        <tbody class="text-slate-700">
                            <tr>
                                <td class="px-3 py-2.5 font-mono">q23312</td>
                                <td class="px-3 py-2.5">Shandi Sutiawan</td>
                                <td class="px-3 py-2.5">1A</td>
                            </tr>
                            <tr class="border-t border-slate-100">
                                <td class="px-3 py-2.5 font-mono">q23313</td>
                                <td class="px-3 py-2.5">Fulan bin Fulan</td>
                                <td class="px-3 py-2.5">6B</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <p class="text-sm text-slate-600">
                    Kolom "Kelas" cukup diisi kode singkatnya saja (1A, 1B, 2A, ... 6B) —
                    tidak perlu tulis nama sahabat Nabi lengkapnya. Kode harus sesuai
                    dengan kelas yang sudah terdaftar di menu Kategori Kelas.
                </p>
            </div>
        </div>

        <form method="POST" action="{{ route('students.import') }}" enctype="multipart/form-data" class="card">
            @csrf

            <div class="card-body">
                <label class="form-label">File Excel</label>
                <div class="rounded-xl border-2 border-dashed border-slate-200 bg-slate-50/60 p-5 sm:p-6 flex flex-col sm:flex-row sm:items-center gap-4 hover:border-brand-300 transition">
                    <span class="icon-tile bg-white text-brand-600 shadow-sm"><x-icon name="upload" /></span>
                    <div class="flex-1 min-w-0">
                        <input type="file" name="excel_file" accept=".xlsx,.xls,.csv" class="form-control w-full" required>
                        <p class="form-hint">Format yang didukung: .xlsx, .xls, .csv</p>
                    </div>
                </div>
            </div>

            <div class="card-footer flex flex-col-reverse sm:flex-row sm:justify-end gap-2">
                <a href="{{ route('students.index') }}" class="btn-secondary w-full sm:w-auto">Batal</a>
                <button type="submit" class="btn-primary w-full sm:w-auto">
                    <x-icon name="upload" />
                    Import dari Excel
                </button>
            </div>
        </form>
    </div>
@endsection
