<x-guest-layout>
    <div class="mb-6">
        <div class="icon-tile bg-brand-50 text-brand-700 mb-4"><x-icon name="lock" /></div>
        <h1 class="text-xl font-extrabold tracking-tight text-slate-900">Lupa password?</h1>
        <p class="text-sm text-slate-500 mt-1.5">
            Tidak masalah. Masukkan alamat email akunmu, kami akan mengirimkan tautan untuk membuat password baru.
        </p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-5" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" value="Email" />
            <div class="input-icon">
                <x-icon name="envelope" />
                <x-text-input id="email" class="block w-full" type="email" name="email" :value="old('email')" required autofocus />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <x-primary-button class="w-full !py-3">
            Kirim Tautan Reset Password
        </x-primary-button>

        <a href="{{ route('login') }}" class="flex items-center justify-center gap-1.5 text-sm font-medium text-slate-500 hover:text-brand-700">
            <x-icon name="arrow-left" class="w-4 h-4" />
            Kembali ke halaman masuk
        </a>
    </form>
</x-guest-layout>
