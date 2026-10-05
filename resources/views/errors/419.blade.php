@extends('errors.minimal')

@section('title', 'Sesi Berakhir')
@section('heading', 'Sesi Sudah Berakhir')
@section('icon', 'clock')
@section('code', '419')
@section('message', 'Halaman ini sudah terlalu lama terbuka tanpa aktivitas. Silakan muat ulang dan coba lagi.')
@section('action')
    <a href="javascript:history.back()" class="btn-primary"><x-icon name="refresh" /> Muat Ulang Halaman</a>
@endsection
