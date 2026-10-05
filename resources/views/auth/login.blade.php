<x-guest-layout>
    <div class="mb-7">
        <h1 class="text-2xl font-extrabold tracking-tight text-slate-900">Selamat datang</h1>
        <p class="text-sm text-slate-500 mt-1.5">Masuk dengan akun yang diberikan admin sekolah.</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-5" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" value="Email" />
            <div class="input-icon">
                <x-icon name="envelope" />
                <x-text-input id="email" class="block w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="nama@sekolah.sch.id" />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <div class="flex items-center justify-between">
                <x-input-label for="password" value="Password" />
                @if (Route::has('password.request'))
                    <a class="text-xs font-semibold text-brand-700 hover:text-brand-800 mb-1.5" href="{{ route('password.request') }}">
                        Lupa password?
                    </a>
                @endif
            </div>
            <div class="input-icon">
                <x-icon name="lock" />
                <x-text-input id="password" class="block w-full"
                                type="password"
                                name="password"
                                required autocomplete="current-password" placeholder="••••••••" />
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <label for="remember_me" class="inline-flex items-center gap-2 cursor-pointer select-none">
            <input id="remember_me" type="checkbox" class="rounded" name="remember">
            <span class="text-sm text-slate-600">Ingat saya</span>
        </label>

        <x-primary-button class="w-full !py-3">
            Masuk
            <x-icon name="arrow-right" class="w-4 h-4" />
        </x-primary-button>
    </form>
</x-guest-layout>
