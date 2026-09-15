@extends('layouts.main')

@section('content')
    <h1 class="text-xl font-bold mb-4">Buat Surat Pemanggilan</h1>

    <x-validation-errors />

    <div class="bg-white shadow rounded-xl p-6 mb-4 border border-gray-100">
        <p class="text-sm text-gray-500">Siswa</p>
        <p class="font-semibold text-lg">{{ $student->name }}</p>
        <p class="text-sm text-gray-500 mt-2">Kelas</p>
        <p>{{ $student->schoolClass->name }}</p>
        <p class="text-sm text-gray-500 mt-2">Total Poin Saat Ini</p>
        <p class="font-semibold text-red-600">{{ $totalPoints }}</p>
    </div>

    <form method="POST" action="{{ route('summon.store', $student) }}" class="bg-white shadow rounded-xl p-6 space-y-4 border border-gray-100">
        @csrf

        <div>
            <label class="block text-sm font-medium mb-1">Hari, Tanggal Pertemuan</label>
            <input type="date" name="meeting_date" value="{{ old('meeting_date', now()->addDays(3)->toDateString()) }}"
                   min="{{ now()->toDateString() }}" class="w-full sm:w-auto border rounded p-2" required>
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Waktu</label>
            <input type="time" name="meeting_time" value="{{ old('meeting_time', '09:00') }}"
                   class="w-full sm:w-auto border rounded p-2" required>
        </div>

        <p class="text-xs text-gray-500">
            Nomor surat dan data siswa akan otomatis terisi. Surat akan langsung terbuka sebagai PDF setelah disimpan.
        </p>

        <button type="submit" class="btn-primary w-full sm:w-auto">Buat &amp; Lihat Surat</button>
    </form>
@endsection
