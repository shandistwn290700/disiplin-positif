<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Disiplin Positif — Sistem Pencatatan Disiplin Siswa</title>
    @include('partials.favicon')
    @include('partials.theme')
</head>
<body class="font-sans text-slate-900 bg-white antialiased">

    {{-- Header --}}
    <header class="sticky top-0 z-30 bg-white/80 backdrop-blur-md border-b border-slate-100">
        <div class="max-w-6xl mx-auto px-5 sm:px-6 h-16 flex items-center justify-between">
            <a href="{{ url('/') }}" class="flex items-center gap-2.5">
                <span class="w-9 h-9 rounded-xl bg-gradient-to-br from-brand-500 to-brand-700 text-white flex items-center justify-center shadow-md shadow-brand-600/25">
                    <x-icon name="shield" class="w-5 h-5" />
                </span>
                <span class="text-lg font-extrabold tracking-tight">Disiplin Positif</span>
            </a>

            <nav class="flex items-center gap-2 text-sm">
                @auth
                    <a href="{{ route('records.index') }}" class="btn-primary btn-sm">
                        Buka Aplikasi
                    </a>
                @else
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn-secondary btn-sm">
                            Daftar
                        </a>
                    @endif
                    <a href="{{ route('login') }}" class="btn-primary btn-sm">
                        Masuk
                    </a>
                @endauth
            </nav>
        </div>
    </header>

    {{-- Hero --}}
    <section class="relative isolate overflow-hidden">
        <div class="absolute inset-0 -z-10 bg-gradient-to-b from-brand-50/70 via-white to-white"></div>
        <div class="absolute -z-10 top-[-10rem] right-[-10rem] w-[32rem] h-[32rem] rounded-full bg-brand-200/40 blur-3xl"></div>

        <div class="max-w-6xl mx-auto px-5 sm:px-6 pt-14 sm:pt-20 pb-20 sm:pb-24 grid md:grid-cols-2 gap-14 items-center">
            <div>
                <span class="inline-flex items-center gap-2 rounded-full bg-white border border-brand-100 shadow-sm px-3.5 py-1.5 text-xs font-semibold text-brand-700">
                    <x-icon name="sparkles" class="w-4 h-4" />
                    Sistem Pencatatan Disiplin Siswa
                </span>
                <h1 class="mt-6 text-4xl md:text-5xl font-extrabold leading-[1.1] tracking-tight text-slate-900">
                    Catat kebaikan dan pelanggaran, <span class="bg-gradient-to-r from-brand-600 to-indigo-600 bg-clip-text text-transparent">bangun karakter siswa.</span>
                </h1>
                <p class="mt-6 text-lg text-slate-600 leading-relaxed max-w-md">
                    Guru mencatat setiap kejadian di kelas, sistem menghitung poinnya secara otomatis,
                    dan wali kelas maupun admin bisa memantau perkembangan siswa kapan saja.
                </p>

                <div class="mt-9 flex flex-wrap gap-3">
                    @auth
                        <a href="{{ route('records.index') }}" class="btn-primary !px-6 !py-3 !text-base">
                            Buka Aplikasi
                            <x-icon name="arrow-right" />
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn-primary !px-6 !py-3 !text-base">
                            Masuk ke Aplikasi
                            <x-icon name="arrow-right" />
                        </a>
                    @endauth
                </div>
            </div>

            {{-- Gambar hero dengan efek parallax --}}
            <div class="relative">
                <div class="absolute -inset-3 rounded-[2rem] bg-gradient-to-br from-brand-200/60 to-indigo-200/40 blur-xl"></div>
                <div class="relative bg-brand-50 rounded-3xl aspect-[4/3] overflow-hidden ring-1 ring-slate-900/5 shadow-2xl shadow-brand-900/10">
                    @php $heroImage = \App\Models\SiteSetting::current()->hero_image; @endphp

                    @if($heroImage)
                        <img id="heroImage" src="{{ asset('storage/' . $heroImage) }}" alt="Disiplin Positif"
                             class="absolute inset-0 w-full h-[130%] -top-[15%] object-cover will-change-transform">
                    @else
                        {{-- Placeholder kalau admin belum upload gambar --}}
                        <div class="absolute inset-0 flex items-center justify-center bg-gradient-to-br from-brand-50 to-indigo-50 text-brand-300">
                            <svg class="w-20 h-20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5l6-6 4 4 8-8M21 6.5v6h-6" />
                            </svg>
                        </div>
                    @endif
                </div>

                {{-- Kartu poin melayang --}}
                <div class="absolute -bottom-6 -left-4 sm:-left-6 bg-white rounded-2xl shadow-xl shadow-slate-900/10 ring-1 ring-slate-900/5 px-5 py-4 flex items-center gap-3">
                    <span class="icon-tile bg-emerald-100 text-emerald-600"><x-icon name="thumb-up" /></span>
                    <div>
                        <p class="text-xs text-slate-500">Poin kebaikan minggu ini</p>
                        <p class="text-2xl font-extrabold text-emerald-600 leading-tight">+128</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Cara kerja --}}
    <section class="bg-slate-50 border-y border-slate-100">
        <div class="max-w-6xl mx-auto px-5 sm:px-6 py-20">
            <div class="max-w-xl">
                <p class="text-sm font-semibold text-brand-700">Cara kerja</p>
                <h2 class="mt-2 text-3xl font-extrabold tracking-tight text-slate-900">Tiga langkah sederhana</h2>
            </div>

            <div class="mt-12 grid md:grid-cols-3 gap-5">
                <div class="card p-6 hover:shadow-lg hover:-translate-y-0.5 transition">
                    <div class="flex items-center justify-between">
                        <span class="icon-tile bg-brand-50 text-brand-600"><x-icon name="clipboard" /></span>
                        <span class="text-4xl font-extrabold text-slate-100">01</span>
                    </div>
                    <h3 class="mt-5 font-bold text-slate-900">Guru mencatat kejadian</h3>
                    <p class="mt-2 text-sm text-slate-600 leading-relaxed">
                        Setiap pelanggaran atau pencapaian siswa dicatat langsung dari kelas, lengkap dengan kategori dan tanggal kejadian.
                    </p>
                </div>
                <div class="card p-6 hover:shadow-lg hover:-translate-y-0.5 transition">
                    <div class="flex items-center justify-between">
                        <span class="icon-tile bg-emerald-50 text-emerald-600"><x-icon name="chart" /></span>
                        <span class="text-4xl font-extrabold text-slate-100">02</span>
                    </div>
                    <h3 class="mt-5 font-bold text-slate-900">Poin dihitung otomatis</h3>
                    <p class="mt-2 text-sm text-slate-600 leading-relaxed">
                        Setiap kategori punya bobot poin sendiri, sehingga rekap disiplin per siswa selalu konsisten dan akurat.
                    </p>
                </div>
                <div class="card p-6 hover:shadow-lg hover:-translate-y-0.5 transition">
                    <div class="flex items-center justify-between">
                        <span class="icon-tile bg-amber-50 text-amber-600"><x-icon name="eye" /></span>
                        <span class="text-4xl font-extrabold text-slate-100">03</span>
                    </div>
                    <h3 class="mt-5 font-bold text-slate-900">Wali kelas &amp; admin memantau</h3>
                    <p class="mt-2 text-sm text-slate-600 leading-relaxed">
                        Laporan rekap poin per siswa bisa dilihat kapan saja untuk mendukung pembinaan yang lebih tepat sasaran.
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- Footer --}}
    <footer class="max-w-6xl mx-auto px-5 sm:px-6 py-8 flex flex-col sm:flex-row items-center justify-between gap-2 text-sm text-slate-400">
        <span>&copy; {{ date('Y') }} Disiplin Positif — SDIT Bahtera Nuh</span>
        <span class="inline-flex items-center gap-1.5"><x-icon name="shield" class="w-4 h-4" /> Bangun karakter, bukan sekadar hukuman.</span>
    </footer>
    <script>
        // Efek parallax sederhana: gambar bergerak lebih lambat dari kecepatan scroll halaman
        window.addEventListener('scroll', function () {
            const img = document.getElementById('heroImage');
            if (!img) return;

            const rect = img.parentElement.getBoundingClientRect();
            // Hanya hitung transform kalau kotak gambar terlihat di layar (hemat performa)
            if (rect.bottom > 0 && rect.top < window.innerHeight) {
                const offset = window.scrollY * 0.12;
                img.style.transform = `translateY(${offset}px)`;
            }
        });
    </script>

</body>
</html>
