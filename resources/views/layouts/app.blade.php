{{-- Layout komponen <x-app-layout> memakai tampilan yang sama dengan layout utama (sidebar) --}}
@include('layouts.main', ['slot' => $slot])
