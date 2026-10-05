@extends('layouts.main')

@section('content')
    <x-page-header title="Pemanggilan Orang Tua"
                   :subtitle="'Siswa otomatis masuk antrian saat total poinnya turun ' . $threshold . ' atau lebih dari titik surat terakhir dibuat.'" />

    {{-- Antrian perlu dipanggil --}}
    <div class="flex items-center gap-2.5 mb-3">
        <span class="icon-tile !w-8 !h-8 !rounded-lg bg-red-50 text-red-600"><x-icon name="megaphone" /></span>
        <h2 class="section-title">Perlu Dibuatkan Surat</h2>
        @if($queue->count() > 0)
            <span class="badge badge-red tabular-nums">{{ $queue->count() }}</span>
        @endif
    </div>

    @if($queue->isEmpty())
        <div class="card mb-8">
            <x-empty-state icon="check-circle">Tidak ada siswa yang perlu dipanggil saat ini.</x-empty-state>
        </div>
    @else
        <div class="table-scroll mb-8"><table class="table-fresh">
            <thead>
                <tr>
                    <th>Nama Siswa</th>
                    <th>Kelas</th>
                    <th>Total Poin</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($queue as $item)
                    <tr>
                        <td class="cell-strong">{{ $item['student']->name }}</td>
                        <td class="cell-muted">{{ $item['student']->schoolClass->name }}</td>
                        <td><span class="badge badge-red tabular-nums">{{ $item['total_points'] }}</span></td>
                        <td class="cell-actions">
                            @if(auth()->user()->isAdmin())
                                <a href="{{ route('summon.create', $item['student']) }}" class="btn-primary btn-sm">
                                    <x-icon name="document" />
                                    Buat Surat
                                </a>
                            @else
                                <span class="text-slate-400 text-xs">Hanya admin</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table></div>
    @endif

    {{-- Riwayat surat --}}
    <div class="flex items-center gap-2.5 mb-3">
        <span class="icon-tile !w-8 !h-8 !rounded-lg bg-brand-50 text-brand-600"><x-icon name="clock" /></span>
        <h2 class="section-title">Riwayat Surat Pemanggilan</h2>
    </div>

    <div class="table-scroll"><table class="table-fresh">
        <thead>
            <tr>
                <th>Nomor Surat</th>
                <th>Siswa</th>
                <th>Kelas</th>
                <th>Poin Saat Itu</th>
                <th>Jadwal Pertemuan</th>
                <th>Dibuat Oleh</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse($history as $letter)
                <tr>
                    <td class="whitespace-nowrap"><span class="badge-code">{{ $letter->letter_number }}</span></td>
                    <td class="cell-strong">{{ $letter->student->name }}</td>
                    <td class="cell-muted">{{ $letter->student->schoolClass->name }}</td>
                    <td><span class="badge badge-red tabular-nums">{{ $letter->points_at_generation }}</span></td>
                    <td class="whitespace-nowrap">
                        <span class="inline-flex items-center gap-1.5">
                            <x-icon name="calendar" class="w-4 h-4 text-slate-400" />
                            {{ $letter->meeting_date->translatedFormat('d M Y') }}, {{ $letter->meeting_time }}
                        </span>
                    </td>
                    <td class="cell-muted">{{ $letter->generatedBy->name }}</td>
                    <td class="cell-actions">
                        <a href="{{ route('summon.pdf', $letter) }}" target="_blank" class="btn-pill btn-pill-blue"><x-icon name="eye" /> Lihat PDF</a>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7"><x-empty-state icon="document">Belum ada surat yang pernah dibuat.</x-empty-state></td></tr>
            @endforelse
        </tbody>
    </table></div>

    <div class="mt-5">{{ $history->links() }}</div>
@endsection
