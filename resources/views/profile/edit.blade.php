@extends('layouts.main')

@section('content')
    <x-page-header title="Profil Saya" subtitle="Kelola informasi akun dan keamanan password kamu." />

    <div class="max-w-3xl space-y-5">
        <div class="card">
            @include('profile.partials.update-profile-information-form')
        </div>

        <div class="card">
            @include('profile.partials.update-password-form')
        </div>

        <div class="card border-red-100">
            @include('profile.partials.delete-user-form')
        </div>
    </div>
@endsection
