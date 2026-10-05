{{-- Tampilan dasar semua halaman error (juga dipakai halaman error bawaan Laravel seperti 401 & 429) --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    @include('partials.favicon')
    @include('partials.theme')
</head>
<body class="min-h-screen flex items-center justify-center p-6 antialiased" style="background: var(--bg)">
    <div class="absolute inset-x-0 top-0 h-72 bg-gradient-to-b from-brand-50 to-transparent -z-10"></div>

    <div class="card w-full max-w-md text-center px-6 py-10 sm:px-10">
        <div class="mx-auto w-14 h-14 rounded-2xl flex items-center justify-center @yield('tone', 'bg-brand-50 text-brand-600')">
            <x-icon :name="trim($__env->yieldContent('icon', 'info'))" class="w-7 h-7" />
        </div>
        <p class="mt-5 text-5xl font-extrabold tracking-tight @yield('code-color', 'text-brand-700')">@yield('code')</p>
        <h1 class="text-xl font-bold text-slate-900 mt-3">
            @hasSection('heading')
                @yield('heading')
            @else
                @yield('title')
            @endif
        </h1>
        <p class="text-slate-500 mt-2 text-sm leading-relaxed">@yield('message')</p>

        @hasSection('action')
            <div class="mt-7">@yield('action')</div>
        @endif
    </div>
</body>
</html>
