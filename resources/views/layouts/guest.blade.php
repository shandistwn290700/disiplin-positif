<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Disiplin Positif') }}</title>
    @include('partials.favicon')
    @include('partials.theme')
</head>
<body class="antialiased text-slate-700" style="background: var(--bg)">
    <div class="min-h-screen flex">
        {{-- Panel kiri: identitas aplikasi --}}
        <div class="hidden lg:flex lg:w-[46%] xl:w-1/2 relative overflow-hidden bg-gradient-to-br from-brand-700 via-brand-800 to-brand-950 text-white flex-col justify-between p-12 xl:p-16">
            {{-- Ornamen dekoratif --}}
            <div class="absolute -top-32 -right-32 w-96 h-96 rounded-full bg-brand-500/30 blur-3xl"></div>
            <div class="absolute -bottom-40 -left-24 w-[28rem] h-[28rem] rounded-full bg-indigo-500/20 blur-3xl"></div>
            <svg class="absolute inset-0 w-full h-full opacity-[0.07]" aria-hidden="true">
                <defs>
                    <pattern id="grid-pattern" width="32" height="32" patternUnits="userSpaceOnUse">
                        <path d="M32 0H0V32" fill="none" stroke="white" stroke-width="1" />
                    </pattern>
                </defs>
                <rect width="100%" height="100%" fill="url(#grid-pattern)" />
            </svg>

            <a href="{{ url('/') }}" class="relative flex items-center gap-3">
                <span class="w-11 h-11 rounded-xl bg-white/15 ring-1 ring-white/25 backdrop-blur flex items-center justify-center">
                    <x-icon name="shield" class="w-6 h-6" />
                </span>
                <span>
                    <span class="block text-lg font-extrabold tracking-tight">Disiplin Positif</span>
                    <span class="block text-brand-200 text-xs">Sistem pencatatan disiplin siswa</span>
                </span>
            </a>

            <div class="relative max-w-md">
                <p class="text-[2rem] xl:text-[2.4rem] font-extrabold leading-[1.15] tracking-tight">
                    Bangun karakter siswa lewat catatan yang jujur dan konsisten.
                </p>
                <ul class="mt-8 space-y-4 text-brand-100">
                    <li class="flex items-center gap-3">
                        <span class="w-8 h-8 rounded-lg bg-white/10 ring-1 ring-white/15 flex items-center justify-center"><x-icon name="clipboard" class="w-4 h-4" /></span>
                        Guru mencatat langsung dari kelas
                    </li>
                    <li class="flex items-center gap-3">
                        <span class="w-8 h-8 rounded-lg bg-white/10 ring-1 ring-white/15 flex items-center justify-center"><x-icon name="chart" class="w-4 h-4" /></span>
                        Poin dihitung otomatis &amp; konsisten
                    </li>
                    <li class="flex items-center gap-3">
                        <span class="w-8 h-8 rounded-lg bg-white/10 ring-1 ring-white/15 flex items-center justify-center"><x-icon name="sparkles" class="w-4 h-4" /></span>
                        Admin memantau, siswa berkembang
                    </li>
                </ul>
            </div>

            <p class="relative text-brand-300 text-xs">&copy; {{ date('Y') }} Disiplin Positif</p>
        </div>

        {{-- Panel kanan: formulir --}}
        <div class="w-full lg:w-[54%] xl:w-1/2 flex flex-col justify-center items-center px-5 py-12 sm:px-8">
            <div class="w-full max-w-[26rem]">
                <a href="{{ url('/') }}" class="lg:hidden flex items-center justify-center gap-2.5 mb-8">
                    <span class="w-10 h-10 rounded-xl bg-gradient-to-br from-brand-500 to-brand-700 text-white flex items-center justify-center shadow-md shadow-brand-600/25">
                        <x-icon name="shield" class="w-5 h-5" />
                    </span>
                    <span class="text-xl font-extrabold tracking-tight text-slate-900">Disiplin Positif</span>
                </a>

                <div class="card p-7 sm:p-9 shadow-xl shadow-slate-200/60">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </div>
</body>
</html>
