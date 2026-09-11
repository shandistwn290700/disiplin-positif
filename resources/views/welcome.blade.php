<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Disiplin Positif — Sistem Pencatatan Disiplin Siswa</title>
    @include('partials.favicon')
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Figtree', 'sans-serif'] },
                    colors: {
                        brand: {
                            50: '#EFF6FF', 100: '#DBEAFE', 600: '#2563EB',
                            700: '#1D4ED8', 800: '#1E3A8A', 900: '#0F172A',
                        },
                    },
                },
            },
        };
    </script>
</head>
<body class="font-sans text-brand-900 bg-white">

    {{-- Header --}}
    <header class="border-b border-gray-100">
        <div class="max-w-6xl mx-auto px-6 py-5 flex items-center justify-between">
            <span class="text-lg font-bold text-brand-800">Disiplin Positif</span>

            <nav class="flex items-center gap-3 text-sm">
                @auth
                    <a href="{{ route('records.index') }}"
                       class="px-4 py-2 rounded-lg bg-brand-700 text-white font-medium hover:bg-brand-800 transition">
                        Buka Aplikasi
                    </a>
                @else
                    <a href="{{ route('login') }}"
                       class="px-5 py-2 rounded-lg bg-brand-700 text-white font-medium hover:bg-brand-800 transition shadow-sm">
                        Masuk
                    </a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                           class="px-4 py-2 rounded-lg bg-brand-700 text-white font-medium hover:bg-brand-800 transition">
                            Daftar
                        </a>
                    @endif
                @endauth
            </nav>
        </div>
    </header>

    {{-- Hero --}}
    <section class="max-w-6xl mx-auto px-6 pt-16 pb-20 grid md:grid-cols-2 gap-12 items-center">
        <div>
            <h1 class="text-4xl md:text-5xl font-extrabold leading-tight text-brand-900">
                Catat kebaikan dan pelanggaran, bangun karakter siswa.
            </h1>
            <p class="mt-5 text-lg text-gray-600 leading-relaxed max-w-md">
                Guru mencatat setiap kejadian di kelas, sistem menghitung poinnya secara otomatis,
                dan wali kelas maupun admin bisa memantau perkembangan siswa kapan saja.
            </p>

            <div class="mt-8 flex gap-3">
                @auth
                    <a href="{{ route('records.index') }}"
                       class="px-6 py-3 rounded-lg bg-brand-700 text-white font-semibold hover:bg-brand-800 transition">
                        Buka Aplikasi
                    </a>
                @else
                    <a href="{{ route('login') }}"
                       class="px-6 py-3 rounded-lg bg-brand-700 text-white font-semibold hover:bg-brand-800 transition">
                        Masuk ke Aplikasi
                    </a>
                @endauth
            </div>
        </div>

        {{-- Gambar hero dengan efek parallax --}}
        <div class="relative">
            <div class="relative bg-brand-50 rounded-2xl aspect-[4/3] overflow-hidden">
                @php $heroImage = \App\Models\SiteSetting::current()->hero_image; @endphp

                @if($heroImage)
                    <img id="heroImage" src="{{ asset('storage/' . $heroImage) }}" alt="Disiplin Positif"
                         class="absolute inset-0 w-full h-[130%] -top-[15%] object-cover will-change-transform">
                @else
                    {{-- Placeholder kalau admin belum upload gambar --}}
                    <div class="absolute inset-0 flex items-center justify-center text-brand-300">
                        <svg class="w-20 h-20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5l6-6 4 4 8-8M21 6.5v6h-6" />
                        </svg>
                    </div>
                @endif
            </div>

            {{-- Kartu poin melayang --}}
            <div class="absolute -bottom-5 -left-5 bg-white rounded-xl shadow-lg border border-gray-100 px-5 py-4">
                <p class="text-xs text-gray-500">Poin kebaikan minggu ini</p>
                <p class="text-2xl font-bold text-green-600">+128</p>
            </div>
        </div>
    </section>

    {{-- Cara kerja --}}
    <section class="bg-brand-50 border-y border-gray-100">
        <div class="max-w-6xl mx-auto px-6 py-16">
            <h2 class="text-2xl font-bold text-brand-900 mb-10">Cara kerja aplikasi</h2>

            <div class="grid md:grid-cols-3 gap-10">
                <div>
                    <div class="w-10 h-10 rounded-full bg-brand-700 text-white flex items-center justify-center font-bold">1</div>
                    <h3 class="mt-4 font-semibold text-brand-900">Guru mencatat kejadian</h3>
                    <p class="mt-2 text-sm text-gray-600 leading-relaxed">
                        Setiap pelanggaran atau pencapaian siswa dicatat langsung dari kelas, lengkap dengan kategori dan tanggal kejadian.
                    </p>
                </div>
                <div>
                    <div class="w-10 h-10 rounded-full bg-brand-700 text-white flex items-center justify-center font-bold">2</div>
                    <h3 class="mt-4 font-semibold text-brand-900">Poin dihitung otomatis</h3>
                    <p class="mt-2 text-sm text-gray-600 leading-relaxed">
                        Setiap kategori punya bobot poin sendiri, sehingga rekap disiplin per siswa selalu konsisten dan akurat.
                    </p>
                </div>
                <div>
                    <div class="w-10 h-10 rounded-full bg-brand-700 text-white flex items-center justify-center font-bold">3</div>
                    <h3 class="mt-4 font-semibold text-brand-900">Wali kelas & admin memantau</h3>
                    <p class="mt-2 text-sm text-gray-600 leading-relaxed">
                        Laporan rekap poin per siswa bisa dilihat kapan saja untuk mendukung pembinaan yang lebih tepat sasaran.
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- Footer --}}
    <footer class="max-w-6xl mx-auto px-6 py-8 text-sm text-gray-400">
        &copy; {{ date('Y') }} Disiplin Positif — SDIT Bahtera Nuh
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
