@extends('errors.minimal')

@section('title', 'Akses Ditolak')
@section('icon', 'lock')
@section('tone', 'bg-amber-50 text-amber-600')
@section('code-color', 'text-amber-500')
@section('code', '403')
@section('message')
    {{ $exception->getMessage() ?: 'Kamu tidak memiliki izin untuk mengakses halaman ini.' }}
@endsection
@section('action')
    <a href="{{ url('/') }}" class="btn-primary"><x-icon name="home" /> Kembali ke Beranda</a>
@endsection
