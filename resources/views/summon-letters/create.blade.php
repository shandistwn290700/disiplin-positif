@extends('layouts.main')

@section('content')
    <x-page-header title="Buat Surat Pemanggilan" subtitle="Tentukan jadwal pertemuan dengan orang tua siswa." :back="route('summon.index')" />

    <div class="max-w-2xl space-y-5">
        <x-validation-errors />

        @php
            $studentInitials = collect(preg_split('/\s+/', trim($student->name)))
                ->filter()->take(2)
                ->map(fn ($word) => mb_strtoupper(mb_substr($word, 0, 1)))
                ->implode('');
        @endphp

        <div class="card p-5 sm:p-6 flex flex-col sm:flex-row sm:items-center gap-4">
            <span class="avatar !w-12 !h-12 !text-base">{{ $studentInitials }}</span>
            <div class="flex-1 min-w-0">
                <p class="text-xs font-medium text-slate-400 uppercase tracking-wider">Siswa</p>
                <p class="font-bold text-lg text-slate-900 truncate">{{ $student->name }}</p>
                <p class="text-sm text-slate-500">Kelas {{ $student->schoolClass->name }}</p>
            </div>
            <div class="sm:text-right">
                <p class="text-xs font-medium text-slate-400 uppercase tracking-wider">Total Poin Saat Ini</p>
                <p class="text-2xl font-extrabold text-red-600 tabular-nums">{{ $totalPoints }}</p>
            </div>
        </div>

        <form method="POST" action="{{ route('summon.store', $student) }}" class="card">
            @csrf

            <div class="card-body space-y-5">
                <div class="grid sm:grid-cols-2 gap-5">
                    <div>
                        <label class="form-label">Hari, Tanggal Pertemuan</label>
                        <input type="date" name="meeting_date" value="{{ old('meeting_date', now()->addDays(3)->toDateString()) }}"
                               min="{{ now()->toDateString() }}" class="form-control w-full" required>
                    </div>

                    <div>
                        <label class="form-label">Waktu</label>
                        <input type="time" name="meeting_time" value="{{ old('meeting_time', '09:00') }}"
                               class="form-control w-full" required>
                    </div>
                </div>

                <div class="alert alert-info">
                    <x-icon name="info" />
                    <span>Nomor surat dan data siswa akan otomatis terisi. Surat akan langsung terbuka sebagai PDF setelah disimpan.</span>
                </div>
            </div>

            <div class="card-footer flex flex-col-reverse sm:flex-row sm:justify-end gap-2">
                <a href="{{ route('summon.index') }}" class="btn-secondary w-full sm:w-auto">Batal</a>
                <button type="submit" class="btn-primary w-full sm:w-auto">
                    <x-icon name="document" />
                    Buat &amp; Lihat Surat
                </button>
            </div>
        </form>
    </div>
@endsection
