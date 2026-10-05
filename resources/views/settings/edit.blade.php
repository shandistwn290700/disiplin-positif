@extends('layouts.main')

@section('content')
    <x-page-header title="Pengaturan Tampilan" subtitle="Atur gambar, ikon, pesan sambutan, dan identitas sekolah." />

    <x-validation-errors />

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5 mb-5">
        {{-- Gambar Hero --}}
        <div class="card flex flex-col">
            <div class="card-header">
                <span class="icon-tile bg-brand-50 text-brand-600"><x-icon name="photo" /></span>
                <div>
                    <h2 class="section-title">Gambar Hero (Halaman Depan)</h2>
                    <p class="section-subtitle">Rekomendasi 1200 x 1500 px (rasio 4:5). JPG, PNG, atau WebP, maks 5MB.</p>
                </div>
            </div>

            <form method="POST" action="{{ route('settings.update') }}" enctype="multipart/form-data" class="flex flex-col flex-1">
                @csrf
                <div class="card-body space-y-4 flex-1">
                    @if($setting->hero_image)
                        <div>
                            <p class="text-xs font-medium text-slate-500 mb-2">Gambar saat ini:</p>
                            <img src="{{ asset('storage/' . $setting->hero_image) }}" alt="Gambar hero saat ini" class="rounded-xl max-h-56 border border-slate-200 shadow-sm">
                        </div>
                    @else
                        <div class="rounded-xl border-2 border-dashed border-slate-200 bg-slate-50/60 p-6 text-center text-sm text-slate-400">
                            Belum ada gambar yang di-upload.
                        </div>
                    @endif

                    <div>
                        <label class="form-label">
                            {{ $setting->hero_image ? 'Ganti dengan gambar baru' : 'Upload gambar' }}
                        </label>
                        <input type="file" name="hero_image" accept="image/*" class="form-control w-full">
                    </div>
                </div>
                <div class="card-footer flex justify-end">
                    <button type="submit" class="btn-primary w-full sm:w-auto">Simpan Gambar Hero</button>
                </div>
            </form>
        </div>

        {{-- Favicon --}}
        <div class="card flex flex-col">
            <div class="card-header">
                <span class="icon-tile bg-violet-50 text-violet-600"><x-icon name="sparkles" /></span>
                <div>
                    <h2 class="section-title">Favicon (Ikon Tab Browser)</h2>
                    <p class="section-subtitle">Rekomendasi 512 x 512 px (persegi). PNG atau ICO, maks 1MB.</p>
                </div>
            </div>

            <form method="POST" action="{{ route('settings.update') }}" enctype="multipart/form-data" class="flex flex-col flex-1">
                @csrf
                <div class="card-body space-y-4 flex-1">
                    @if($setting->favicon)
                        <div class="flex items-center gap-3 rounded-xl border border-slate-200 bg-slate-50/60 p-3">
                            <img src="{{ asset('storage/' . $setting->favicon) }}" alt="Favicon saat ini" class="w-10 h-10 rounded-lg border border-slate-200 bg-white">
                            <p class="text-sm text-slate-600">Favicon saat ini</p>
                        </div>
                    @else
                        <div class="rounded-xl border-2 border-dashed border-slate-200 bg-slate-50/60 p-6 text-center text-sm text-slate-400">
                            Belum ada favicon yang di-upload (memakai ikon default browser).
                        </div>
                    @endif

                    <div>
                        <label class="form-label">
                            {{ $setting->favicon ? 'Ganti dengan favicon baru' : 'Upload favicon' }}
                        </label>
                        <input type="file" name="favicon" accept="image/png,image/x-icon" class="form-control w-full">
                    </div>
                </div>
                <div class="card-footer flex justify-end">
                    <button type="submit" class="btn-primary w-full sm:w-auto">Simpan Favicon</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Pesan Selamat Datang --}}
    <div class="card mb-5">
        <div class="card-header">
            <span class="icon-tile bg-emerald-50 text-emerald-600"><x-icon name="chat" /></span>
            <div>
                <h2 class="section-title">Pesan Selamat Datang Setelah Login</h2>
                <p class="section-subtitle">
                    Pesan ini muncul sebagai popup sekali setiap kali admin/guru berhasil login.
                    Kosongkan untuk memakai pesan default.
                </p>
            </div>
        </div>

        <form method="POST" action="{{ route('settings.welcome-message') }}">
            @csrf
            <div class="card-body">
                <label class="form-label">Pesan</label>
                <textarea name="welcome_message" rows="3" maxlength="500"
                          class="form-control w-full"
                          placeholder="Contoh: Selamat datang kembali! Jangan lupa catat perkembangan siswa hari ini.">{{ old('welcome_message', $setting->welcome_message) }}</textarea>
                <p class="form-hint">Maksimal 500 karakter.</p>
            </div>
            <div class="card-footer flex justify-end">
                <button type="submit" class="btn-primary w-full sm:w-auto">Simpan Pesan</button>
            </div>
        </form>
    </div>

    {{-- Identitas Sekolah & Surat --}}
    <div class="card">
        <div class="card-header">
            <span class="icon-tile bg-amber-50 text-amber-600"><x-icon name="building" /></span>
            <div>
                <h2 class="section-title">Identitas Sekolah &amp; Surat Pemanggilan</h2>
                <p class="section-subtitle">
                    Data ini dipakai untuk kop surat &amp; tanda tangan pada Surat Pemanggilan Orang Tua yang dibuat otomatis.
                </p>
            </div>
        </div>

        <form method="POST" action="{{ route('settings.school-identity') }}" enctype="multipart/form-data">
            @csrf
            <div class="card-body space-y-6">
                <div class="grid sm:grid-cols-2 gap-5">
                    <div>
                        <label class="form-label">Logo Pemerintah/Kabupaten (kiri kop surat)</label>
                        <div class="flex items-center gap-3">
                            <div class="w-16 h-16 flex-shrink-0 rounded-xl border border-slate-200 bg-slate-50 flex items-center justify-center overflow-hidden">
                                @if($setting->government_logo)
                                    <img src="{{ asset('storage/' . $setting->government_logo) }}" alt="Logo Pemerintah" class="w-14 h-14 object-contain">
                                @else
                                    <x-icon name="photo" class="w-6 h-6 text-slate-300" />
                                @endif
                            </div>
                            <input type="file" name="government_logo" accept="image/*" class="form-control w-full min-w-0">
                        </div>
                        <p class="form-hint">Ukuran ideal: 300x300px, persegi, latar transparan (PNG), maks 1MB.</p>
                    </div>
                    <div>
                        <label class="form-label">Logo Sekolah (kanan kop surat)</label>
                        <div class="flex items-center gap-3">
                            <div class="w-16 h-16 flex-shrink-0 rounded-xl border border-slate-200 bg-slate-50 flex items-center justify-center overflow-hidden">
                                @if($setting->school_logo)
                                    <img src="{{ asset('storage/' . $setting->school_logo) }}" alt="Logo Sekolah" class="w-14 h-14 object-contain">
                                @else
                                    <x-icon name="photo" class="w-6 h-6 text-slate-300" />
                                @endif
                            </div>
                            <input type="file" name="school_logo" accept="image/*" class="form-control w-full min-w-0">
                        </div>
                        <p class="form-hint">Ukuran ideal: 300x300px, persegi, latar transparan (PNG), maks 1MB.</p>
                    </div>
                </div>

                <div class="grid sm:grid-cols-2 gap-5 pt-6 border-t border-slate-100">
                    <div>
                        <label class="form-label">Baris Pemerintah <span class="font-normal text-slate-400">(opsional)</span></label>
                        <input type="text" name="school_government_line" value="{{ old('school_government_line', $setting->school_government_line) }}"
                               placeholder="Contoh: Pemerintah Kabupaten Bandung" class="form-control w-full">
                    </div>
                    <div>
                        <label class="form-label">Nama Sekolah</label>
                        <input type="text" name="school_name" value="{{ old('school_name', $setting->school_name) }}"
                               placeholder="Contoh: SDIT Bahtera Nuh" class="form-control w-full">
                    </div>
                    <div class="sm:col-span-2">
                        <label class="form-label">Alamat Sekolah</label>
                        <input type="text" name="school_address" value="{{ old('school_address', $setting->school_address) }}"
                               class="form-control w-full">
                    </div>
                    <div>
                        <label class="form-label">Email Sekolah</label>
                        <input type="email" name="school_email" value="{{ old('school_email', $setting->school_email) }}"
                               class="form-control w-full">
                    </div>
                    <div>
                        <label class="form-label">Kota (untuk baris tanggal surat)</label>
                        <input type="text" name="school_city" value="{{ old('school_city', $setting->school_city) }}"
                               placeholder="Contoh: Katapang" class="form-control w-full">
                    </div>
                </div>

                <div class="grid sm:grid-cols-2 gap-5 pt-6 border-t border-slate-100">
                    <div>
                        <label class="form-label">Nama Waka Kesiswaan</label>
                        <input type="text" name="waka_kesiswaan_name" value="{{ old('waka_kesiswaan_name', $setting->waka_kesiswaan_name) }}"
                               class="form-control w-full">
                    </div>
                    <div>
                        <label class="form-label">Nama Kepala Sekolah</label>
                        <input type="text" name="principal_name" value="{{ old('principal_name', $setting->principal_name) }}"
                               class="form-control w-full">
                    </div>
                    <div class="sm:col-span-2">
                        <label class="form-label">Ambang Batas Poin Pemanggilan</label>
                        <input type="number" name="summon_letter_threshold"
                               value="{{ old('summon_letter_threshold', $setting->summon_letter_threshold ?? -100) }}"
                               class="form-control w-full sm:w-40" required>
                        <p class="form-hint">Siswa masuk antrian saat poin turun sejumlah ini dari titik surat terakhir. Isi angka negatif, misal -100.</p>
                    </div>
                </div>
            </div>

            <div class="card-footer flex justify-end">
                <button type="submit" class="btn-primary w-full sm:w-auto">
                    <x-icon name="check" />
                    Simpan Identitas Sekolah
                </button>
            </div>
        </form>
    </div>
@endsection
