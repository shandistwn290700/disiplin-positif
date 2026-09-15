<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Terjadi Kesalahan</title>
    @include('partials.favicon')
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center p-6">
    <div class="text-center max-w-md">
        <p class="text-6xl font-extrabold text-red-600">500</p>
        <h1 class="text-xl font-bold text-gray-900 mt-3">Terjadi Kesalahan pada Server</h1>
        <p class="text-gray-500 mt-2">
            Maaf, ada sesuatu yang tidak berjalan semestinya di sisi kami. Tim teknis sudah otomatis
            mendapat catatan errornya. Silakan coba lagi dalam beberapa saat.
        </p>
        <a href="{{ url('/') }}" class="inline-block mt-6 px-5 py-2.5 rounded-lg bg-blue-700 text-white font-medium hover:bg-blue-800 transition">
            Kembali ke Beranda
        </a>
    </div>
</body>
</html>
