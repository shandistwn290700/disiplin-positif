<section>
    <header class="card-header">
        <span class="icon-tile bg-brand-50 text-brand-600"><x-icon name="user" /></span>
        <div>
            <h2 class="section-title">Informasi Profil</h2>
            <p class="section-subtitle">Perbarui nama dan alamat email akunmu.</p>
        </div>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}">
        @csrf
        @method('patch')

        <div class="card-body space-y-5 max-w-xl">
            <div>
                <x-input-label for="name" value="Nama" />
                <x-text-input id="name" name="name" type="text" class="block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
                <x-input-error class="mt-2" :messages="$errors->get('name')" />
            </div>

            <div>
                <x-input-label for="email" value="Email" />
                <x-text-input id="email" name="email" type="email" class="block w-full" :value="old('email', $user->email)" required autocomplete="username" />
                <x-input-error class="mt-2" :messages="$errors->get('email')" />

                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                    <div class="alert alert-warning mt-3">
                        <x-icon name="warning" />
                        <div>
                            <p>
                                Alamat email kamu belum terverifikasi.
                                <button form="send-verification" class="font-semibold underline hover:no-underline">
                                    Klik di sini untuk mengirim ulang email verifikasi.
                                </button>
                            </p>

                            @if (session('status') === 'verification-link-sent')
                                <p class="mt-2 font-medium text-emerald-700">
                                    Tautan verifikasi baru sudah dikirim ke alamat email kamu.
                                </p>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <div class="card-footer flex items-center justify-end gap-4">
            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="inline-flex items-center gap-1.5 text-sm font-medium text-emerald-600"
                ><x-icon name="check-circle" class="w-4 h-4" /> Tersimpan.</p>
            @endif

            <x-primary-button>Simpan</x-primary-button>
        </div>
    </form>
</section>
