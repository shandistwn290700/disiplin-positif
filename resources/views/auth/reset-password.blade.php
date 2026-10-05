<x-guest-layout>
    <div class="mb-6">
        <div class="icon-tile bg-brand-50 text-brand-700 mb-4"><x-icon name="lock" /></div>
        <h1 class="text-xl font-extrabold tracking-tight text-slate-900">Atur ulang password</h1>
        <p class="text-sm text-slate-500 mt-1.5">Buat password baru untuk akunmu.</p>
    </div>

    <form method="POST" action="{{ route('password.store') }}" class="space-y-5">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div>
            <x-input-label for="email" value="Email" />
            <x-text-input id="email" class="block w-full" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" value="Password Baru" />
            <x-text-input id="password" class="block w-full" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div>
            <x-input-label for="password_confirmation" value="Konfirmasi Password Baru" />

            <x-text-input id="password_confirmation" class="block w-full"
                                type="password"
                                name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <x-primary-button class="w-full !py-3">
            Simpan Password Baru
        </x-primary-button>
    </form>
</x-guest-layout>
