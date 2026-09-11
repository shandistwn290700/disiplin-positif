<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Disiplin Positif') }}</title>
    @include('partials.favicon')
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen flex">
        <div class="hidden lg:flex lg:w-1/2 bg-blue-700 text-white flex-col justify-between p-12">
            <div>
                <h1 class="text-2xl font-bold">Disiplin Positif</h1>
                <p class="text-blue-200 mt-1 text-sm">Sistem pencatatan disiplin siswa</p>
            </div>
            <div>
                <p class="text-3xl font-semibold leading-snug">
                    Bangun karakter siswa<br>lewat catatan yang jujur<br>dan konsisten.
                </p>
                <p class="text-blue-200 mt-4 text-sm">Guru mencatat, admin memantau, siswa berkembang.</p>
            </div>
            <p class="text-blue-300 text-xs">&copy; {{ date('Y') }} Disiplin Positif</p>
        </div>

        <div class="w-full lg:w-1/2 flex flex-col justify-center items-center bg-gray-50 px-6 py-12">
            <div class="w-full max-w-sm">
                <div class="lg:hidden text-center mb-8">
                    <h1 class="text-xl font-bold text-blue-700">Disiplin Positif</h1>
                </div>
                <div class="bg-white shadow-sm rounded-xl p-8 border border-gray-100">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </div>
</body>
</html>
