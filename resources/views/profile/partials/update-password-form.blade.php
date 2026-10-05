<section>
    <header class="card-header">
        <span class="icon-tile bg-amber-50 text-amber-600"><x-icon name="lock" /></span>
        <div>
            <h2 class="section-title">Ganti Password</h2>
            <p class="section-subtitle">Pastikan akunmu memakai password yang panjang dan acak agar tetap aman.</p>
        </div>
    </header>

    <form method="post" action="{{ route('password.update') }}">
        @csrf
        @method('put')

        <div class="card-body space-y-5 max-w-xl">
            <div>
                <x-input-label for="update_password_current_password" value="Password Saat Ini" />
                <x-text-input id="update_password_current_password" name="current_password" type="password" class="block w-full" autocomplete="current-password" />
                <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="update_password_password" value="Password Baru" />
                <x-text-input id="update_password_password" name="password" type="password" class="block w-full" autocomplete="new-password" />
                <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="update_password_password_confirmation" value="Konfirmasi Password Baru" />
                <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password" class="block w-full" autocomplete="new-password" />
                <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
            </div>
        </div>

        <div class="card-footer flex items-center justify-end gap-4">
            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="inline-flex items-center gap-1.5 text-sm font-medium text-emerald-600"
                ><x-icon name="check-circle" class="w-4 h-4" /> Tersimpan.</p>
            @endif

            <x-primary-button>Simpan Password</x-primary-button>
        </div>
    </form>
</section>
