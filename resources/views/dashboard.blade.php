@extends('layouts.main')

@section('content')
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3 mb-6">
        <h1 class="text-xl font-bold">Dashboard</h1>
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('dashboard', ['period' => 'week']) }}"
               class="{{ $period === 'week' ? 'btn-primary' : 'btn-secondary' }} btn-sm">Minggu Ini</a>
            <a href="{{ route('dashboard', ['period' => 'month']) }}"
               class="{{ $period === 'month' ? 'btn-primary' : 'btn-secondary' }} btn-sm">Bulan Ini</a>
        </div>
    </div>

    {{-- Kartu statistik --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
            <p class="text-sm text-gray-500">Perilaku Baik</p>
            <p class="text-3xl font-bold text-green-600 mt-1">{{ $totalPositif }}</p>
        </div>
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
            <p class="text-sm text-gray-500">Pelanggaran</p>
            <p class="text-3xl font-bold text-red-600 mt-1">{{ $totalNegatif }}</p>
        </div>
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
            <p class="text-sm text-gray-500">Poin Bersih</p>
            <p class="text-3xl font-bold mt-1 {{ $netPoin >= 0 ? 'text-blue-600' : 'text-red-600' }}">
                {{ $netPoin > 0 ? '+' : '' }}{{ $netPoin }}
            </p>
        </div>
    </div>

    {{-- Chart tren harian --}}
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5 mb-6">
        <h2 class="font-semibold text-sm text-gray-600 mb-4">Tren Harian</h2>
        <canvas id="trendChart" height="90"></canvas>
    </div>

    {{-- Chart tingkat keparahan pelanggaran --}}
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5 mb-6">
        <h2 class="font-semibold text-sm text-gray-600 mb-4">Tingkat Keparahan Pelanggaran</h2>
        <canvas id="severityChart" height="90"></canvas>
    </div>

    {{-- Export laporan bulanan untuk Yayasan --}}
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
        <h2 class="font-semibold text-sm text-gray-600 mb-1">Export Laporan Bulanan</h2>
        <p class="text-xs text-gray-500 mb-4">Untuk keperluan laporan ke Yayasan — pilih bulan, lalu unduh dalam format Excel atau PDF.</p>

        <form class="flex flex-col sm:flex-row sm:items-end gap-3">
            <div class="w-full sm:w-auto">
                <label class="block text-xs font-medium text-gray-500 mb-1">Pilih Bulan</label>
                <input type="month" name="month" value="{{ now()->format('Y-m') }}"
                       class="w-full sm:w-auto border rounded p-2 text-sm">
            </div>
            <button type="submit" formaction="{{ route('records.export.excel') }}" formmethod="GET"
                    class="btn-secondary btn-sm w-full sm:w-auto">Export Excel</button>
            <button type="submit" formaction="{{ route('records.export.pdf') }}" formmethod="GET"
                    class="btn-secondary btn-sm w-full sm:w-auto">Export PDF</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4"></script>
    <script>
        new Chart(document.getElementById('trendChart'), {
            type: 'line',
            data: {
                labels: @json($dailyLabels),
                datasets: [
                    {
                        label: 'Perilaku Baik',
                        data: @json($dailyPositif),
                        borderColor: '#16a34a',
                        backgroundColor: 'rgba(22,163,74,0.1)',
                        tension: 0.3,
                        fill: true,
                    },
                    {
                        label: 'Pelanggaran',
                        data: @json($dailyNegatif),
                        borderColor: '#dc2626',
                        backgroundColor: 'rgba(220,38,38,0.1)',
                        tension: 0.3,
                        fill: true,
                    },
                ],
            },
            options: {
                responsive: true,
                plugins: { legend: { position: 'bottom' } },
                scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } },
            },
        });

        new Chart(document.getElementById('severityChart'), {
            type: 'bar',
            data: {
                labels: ['Ringan', 'Sedang', 'Berat'],
                datasets: [{
                    label: 'Jumlah Pelanggaran',
                    data: [
                        {{ $severityCounts['ringan'] }},
                        {{ $severityCounts['sedang'] }},
                        {{ $severityCounts['berat'] }},
                    ],
                    backgroundColor: ['#fbbf24', '#fb923c', '#dc2626'],
                    borderRadius: 6,
                }],
            },
            options: {
                responsive: true,
                plugins: { legend: { display: false } },
                scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } },
            },
        });
    </script>
@endsection
