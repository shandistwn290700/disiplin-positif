@extends('errors.minimal')

@section('title', 'Halaman Tidak Ditemukan')
@section('icon', 'search')
@section('code', '404')
@section('message', 'Halaman yang kamu cari tidak ada atau sudah dipindahkan.')
@section('action')
    <a href="{{ url('/') }}" class="btn-primary"><x-icon name="home" /> Kembali ke Beranda</a>
@endsection
