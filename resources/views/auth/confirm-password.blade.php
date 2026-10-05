<x-guest-layout>
    <div class="mb-6">
        <div class="icon-tile bg-amber-50 text-amber-600 mb-4"><x-icon name="shield" /></div>
        <h1 class="text-xl font-extrabold tracking-tight text-slate-900">Konfirmasi password</h1>
        <p class="text-sm text-slate-500 mt-1.5">
            Ini adalah area aman aplikasi. Silakan konfirmasi password kamu sebelum melanjutkan.
        </p>
    </div>

    <form method="POST" action="{{ route('password.confirm') }}" class="space-y-5">
        @csrf

        <!-- Password -->
        <div>
            <x-input-label for="password" value="Password" />

            <x-text-input id="password" class="block w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <x-primary-button class="w-full !py-3">
            Konfirmasi
        </x-primary-button>
    </form>
</x-guest-layout>
