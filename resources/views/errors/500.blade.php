@extends('errors.minimal')

@section('title', 'Terjadi Kesalahan')
@section('heading', 'Terjadi Kesalahan pada Server')
@section('icon', 'warning')
@section('tone', 'bg-red-50 text-red-600')
@section('code-color', 'text-red-600')
@section('code', '500')
@section('message', 'Maaf, ada sesuatu yang tidak berjalan semestinya di sisi kami. Tim teknis sudah otomatis mendapat catatan errornya. Silakan coba lagi dalam beberapa saat.')
@section('action')
    <a href="{{ url('/') }}" class="btn-primary"><x-icon name="home" /> Kembali ke Beranda</a>
@endsection
