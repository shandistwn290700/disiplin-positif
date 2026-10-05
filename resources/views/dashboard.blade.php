@extends('layouts.main')

@section('content')
    <x-page-header title="Dashboard"
                   :subtitle="'Ringkasan perilaku siswa ' . ($period === 'month' ? 'bulan ini' : 'minggu ini') . '.'">
        <div class="segmented">
            <a href="{{ route('dashboard', ['period' => 'week']) }}" class="{{ $period === 'week' ? 'active' : '' }}">Minggu Ini</a>
            <a href="{{ route('dashboard', ['period' => 'month']) }}" class="{{ $period === 'month' ? 'active' : '' }}">Bulan Ini</a>
        </div>
    </x-page-header>

    {{-- Kartu statistik --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
        <div class="card p-5 relative overflow-hidden">
            <div class="absolute -right-6 -top-6 w-24 h-24 rounded-full bg-emerald-50"></div>
            <div class="relative flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500">Perilaku Baik</p>
                    <p class="text-3xl font-extrabold tracking-tight text-emerald-600 mt-2">{{ $totalPositif }}</p>
                    <p class="text-xs text-slate-400 mt-1">catatan positif</p>
                </div>
                <span class="icon-tile bg-emerald-100 text-emerald-600"><x-icon name="thumb-up" /></span>
            </div>
        </div>
        <div class="card p-5 relative overflow-hidden">
            <div class="absolute -right-6 -top-6 w-24 h-24 rounded-full bg-red-50"></div>
            <div class="relative flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500">Pelanggaran</p>
                    <p class="text-3xl font-extrabold tracking-tight text-red-600 mt-2">{{ $totalNegatif }}</p>
                    <p class="text-xs text-slate-400 mt-1">catatan pelanggaran</p>
                </div>
                <span class="icon-tile bg-red-100 text-red-600"><x-icon name="warning" /></span>
            </div>
        </div>
        <div class="card p-5 relative overflow-hidden">
            <div class="absolute -right-6 -top-6 w-24 h-24 rounded-full {{ $netPoin >= 0 ? 'bg-brand-50' : 'bg-red-50' }}"></div>
            <div class="relative flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500">Poin Bersih</p>
                    <p class="text-3xl font-extrabold tracking-tight mt-2 {{ $netPoin >= 0 ? 'text-brand-600' : 'text-red-600' }}">
                        {{ $netPoin > 0 ? '+' : '' }}{{ $netPoin }}
                    </p>
                    <p class="text-xs text-slate-400 mt-1">total poin periode ini</p>
                </div>
                <span class="icon-tile {{ $netPoin >= 0 ? 'bg-brand-100 text-brand-600' : 'bg-red-100 text-red-600' }}"><x-icon name="scale" /></span>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mb-6">
        {{-- Chart tren harian --}}
        <div class="card p-5 lg:col-span-2">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h2 class="section-title">Tren Harian</h2>
                    <p class="section-subtitle">Perilaku baik vs pelanggaran per hari</p>
                </div>
            </div>
            <div class="relative h-64 sm:h-72">
                <canvas id="trendChart"></canvas>
            </div>
        </div>

        {{-- Chart tingkat keparahan pelanggaran --}}
        <div class="card p-5">
            <div class="mb-4">
                <h2 class="section-title">Tingkat Keparahan</h2>
                <p class="section-subtitle">Sebaran pelanggaran per tingkat</p>
            </div>
            <div class="relative h-64 sm:h-72">
                <canvas id="severityChart"></canvas>
            </div>
        </div>
    </div>

    {{-- Export laporan bulanan untuk Yayasan --}}
    <div class="card">
        <div class="card-header">
            <span class="icon-tile bg-brand-50 text-brand-600"><x-icon name="document" /></span>
            <div>
                <h2 class="section-title">Export Laporan Bulanan</h2>
                <p class="section-subtitle">Untuk keperluan laporan ke Yayasan — pilih bulan, lalu unduh dalam format Excel atau PDF.</p>
            </div>
        </div>

        <form class="card-body flex flex-col sm:flex-row sm:items-end gap-3">
            <div class="w-full sm:w-auto">
                <label class="form-label">Pilih Bulan</label>
                <input type="month" name="month" value="{{ now()->format('Y-m') }}"
                       class="form-control w-full sm:w-56">
            </div>
            <button type="submit" formaction="{{ route('records.export.excel') }}" formmethod="GET"
                    class="btn-secondary w-full sm:w-auto">
                <x-icon name="download" class="text-emerald-600" />
                Export Excel
            </button>
            <button type="submit" formaction="{{ route('records.export.pdf') }}" formmethod="GET"
                    class="btn-secondary w-full sm:w-auto">
                <x-icon name="document" class="text-red-600" />
                Export PDF
            </button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4"></script>
    <script>
        Chart.defaults.font.family = "'Plus Jakarta Sans', ui-sans-serif, system-ui, sans-serif";
        Chart.defaults.color = '#64748b';
        Chart.defaults.borderColor = '#eef2f7';

        const tooltipStyle = {
            backgroundColor: '#0f172a', padding: 10, cornerRadius: 8, boxPadding: 4,
            titleFont: { weight: '600' }, bodyFont: { weight: '500' },
        };

        const trendCtx = document.getElementById('trendChart');
        const gradient = (ctx, rgb) => {
            const g = ctx.getContext('2d').createLinearGradient(0, 0, 0, ctx.parentElement.clientHeight || 280);
            g.addColorStop(0, `rgba(${rgb}, 0.22)`);
            g.addColorStop(1, `rgba(${rgb}, 0)`);
            return g;
        };

        new Chart(trendCtx, {
            type: 'line',
            data: {
                labels: @json($dailyLabels),
                datasets: [
                    {
                        label: 'Perilaku Baik',
                        data: @json($dailyPositif),
                        borderColor: '#10b981',
                        backgroundColor: gradient(trendCtx, '16,185,129'),
                        borderWidth: 2.5,
                        pointRadius: 3,
                        pointHoverRadius: 5,
                        pointBackgroundColor: '#fff',
                        pointBorderWidth: 2,
                        tension: 0.35,
                        fill: true,
                    },
                    {
                        label: 'Pelanggaran',
                        data: @json($dailyNegatif),
                        borderColor: '#ef4444',
                        backgroundColor: gradient(trendCtx, '239,68,68'),
                        borderWidth: 2.5,
                        pointRadius: 3,
                        pointHoverRadius: 5,
                        pointBackgroundColor: '#fff',
                        pointBorderWidth: 2,
                        tension: 0.35,
                        fill: true,
                    },
                ],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: { mode: 'index', intersect: false },
                plugins: {
                    legend: { position: 'bottom', labels: { usePointStyle: true, pointStyle: 'circle', boxWidth: 8, boxHeight: 8, padding: 18 } },
                    tooltip: tooltipStyle,
                },
                scales: {
                    x: { grid: { display: false } },
                    y: { beginAtZero: true, ticks: { stepSize: 1, precision: 0 }, border: { display: false } },
                },
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
                    backgroundColor: ['#fbbf24', '#fb923c', '#ef4444'],
                    borderRadius: 8,
                    borderSkipped: false,
                    maxBarThickness: 44,
                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false }, tooltip: tooltipStyle },
                scales: {
                    x: { grid: { display: false } },
                    y: { beginAtZero: true, ticks: { stepSize: 1, precision: 0 }, border: { display: false } },
                },
            },
        });
    </script>
@endsection
