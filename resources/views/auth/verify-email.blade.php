<x-guest-layout>
    <div class="mb-6">
        <div class="icon-tile bg-brand-50 text-brand-700 mb-4"><x-icon name="envelope" /></div>
        <h1 class="text-xl font-extrabold tracking-tight text-slate-900">Verifikasi email</h1>
        <p class="text-sm text-slate-500 mt-1.5">
            Terima kasih sudah mendaftar! Sebelum mulai, silakan verifikasi alamat email kamu lewat tautan yang baru saja kami kirim. Jika belum menerima email, kami bisa mengirimkannya lagi.
        </p>
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="alert alert-success mb-5">
            <x-icon name="check-circle" />
            <span>Tautan verifikasi baru sudah dikirim ke alamat email yang kamu daftarkan.</span>
        </div>
    @endif

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf

            <x-primary-button class="w-full sm:w-auto">
                Kirim Ulang Email Verifikasi
            </x-primary-button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit" class="w-full text-sm font-medium text-slate-500 hover:text-red-600 transition">
                Keluar
            </button>
        </form>
    </div>
</x-guest-layout>
