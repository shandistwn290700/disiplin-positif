@extends('layouts.main')

@section('content')
    <h1 class="text-xl font-bold mb-4">Pengaturan Tampilan</h1>

    @if($errors->any())
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4 text-sm">
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Gambar Hero --}}
    <div class="bg-white shadow rounded p-6 mb-6">
        <h2 class="font-semibold mb-2">Gambar Hero (Halaman Depan)</h2>

        <div class="bg-blue-50 text-blue-800 text-sm p-4 rounded mb-4">
            <p class="font-medium">Ukuran yang direkomendasikan: 1200 x 1500 px (rasio 4:5)</p>
            <p class="mt-1">Format JPG, PNG, atau WebP, maksimal 5MB.</p>
        </div>

        @if($setting->hero_image)
            <div class="mb-4">
                <p class="text-sm text-gray-600 mb-2">Gambar saat ini:</p>
                <img src="{{ asset('storage/' . $setting->hero_image) }}" alt="Gambar hero saat ini" class="rounded-lg max-w-xs border">
            </div>
        @else
            <p class="text-sm text-gray-500 mb-4">Belum ada gambar yang di-upload.</p>
        @endif

        <form method="POST" action="{{ route('settings.update') }}" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium mb-1">
                    {{ $setting->hero_image ? 'Ganti dengan gambar baru' : 'Upload gambar' }}
                </label>
                <input type="file" name="hero_image" accept="image/*" class="w-full border rounded p-2">
            </div>
            <button type="submit" class="btn-primary w-full sm:w-auto">Simpan Gambar Hero</button>
        </form>
    </div>

    {{-- Favicon --}}
    <div class="bg-white shadow rounded p-6">
        <h2 class="font-semibold mb-2">Favicon (Ikon Tab Browser)</h2>

        <div class="bg-blue-50 text-blue-800 text-sm p-4 rounded mb-4">
            <p class="font-medium">Ukuran yang direkomendasikan: 512 x 512 px (persegi)</p>
            <p class="mt-1">Format PNG atau ICO, maksimal 1MB. Ikon akan muncul di tab browser.</p>
        </div>

        @if($setting->favicon)
            <div class="mb-4 flex items-center gap-3">
                <p class="text-sm text-gray-600">Favicon saat ini:</p>
                <img src="{{ asset('storage/' . $setting->favicon) }}" alt="Favicon saat ini" class="w-10 h-10 rounded border">
            </div>
        @else
            <p class="text-sm text-gray-500 mb-4">Belum ada favicon yang di-upload (memakai ikon default browser).</p>
        @endif

        <form method="POST" action="{{ route('settings.update') }}" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium mb-1">
                    {{ $setting->favicon ? 'Ganti dengan favicon baru' : 'Upload favicon' }}
                </label>
                <input type="file" name="favicon" accept="image/png,image/x-icon" class="w-full border rounded p-2">
            </div>
            <button type="submit" class="btn-primary w-full sm:w-auto">Simpan Favicon</button>
        </form>
    </div>
    {{-- Pesan Selamat Datang --}}
    <div class="bg-white shadow rounded p-6 mt-6">
        <h2 class="font-semibold mb-2">Pesan Selamat Datang Setelah Login</h2>
        <p class="text-sm text-gray-500 mb-4">
            Pesan ini muncul sebagai popup sekali setiap kali admin/guru berhasil login.
            Kosongkan untuk memakai pesan default.
        </p>

        <form method="POST" action="{{ route('settings.welcome-message') }}" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium mb-1">Pesan</label>
                <textarea name="welcome_message" rows="3" maxlength="500"
                          class="w-full border rounded p-2"
                          placeholder="Contoh: Selamat datang kembali! Jangan lupa catat perkembangan siswa hari ini.">{{ old('welcome_message', $setting->welcome_message) }}</textarea>
            </div>
            <button type="submit" class="btn-primary w-full sm:w-auto">Simpan Pesan</button>
        </form>
    </div>
@endsection
