@extends('layouts.main')

@section('content')
    <h1 class="text-xl font-bold mb-1">Pemanggilan Orang Tua</h1>
    <p class="text-sm text-gray-500 mb-6">
        Siswa otomatis masuk antrian saat total poinnya turun {{ $threshold }} atau lebih dari titik surat terakhir dibuat.
    </p>

    {{-- Antrian perlu dipanggil --}}
    <div class="flex items-center gap-2 mb-3">
        <h2 class="font-semibold text-gray-700">Perlu Dibuatkan Surat</h2>
        @if($queue->count() > 0)
            <span class="btn-pill btn-pill-red">{{ $queue->count() }}</span>
        @endif
    </div>

    @if($queue->isEmpty())
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6 text-center text-gray-400 text-sm mb-8">
            Tidak ada siswa yang perlu dipanggil saat ini.
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
                        <td>{{ $item['student']->name }}</td>
                        <td>{{ $item['student']->schoolClass->name }}</td>
                        <td class="font-semibold text-red-600">{{ $item['total_points'] }}</td>
                        <td>
                            @if(auth()->user()->isAdmin())
                                <a href="{{ route('summon.create', $item['student']) }}" class="btn-primary btn-sm">
                                    Buat Surat
                                </a>
                            @else
                                <span class="text-gray-400 text-sm">Hanya admin</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table></div>
    @endif

    {{-- Riwayat surat --}}
    <h2 class="font-semibold text-gray-700 mb-3">Riwayat Surat Pemanggilan</h2>

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
                    <td class="whitespace-nowrap">{{ $letter->letter_number }}</td>
                    <td>{{ $letter->student->name }}</td>
                    <td>{{ $letter->student->schoolClass->name }}</td>
                    <td class="text-red-600">{{ $letter->points_at_generation }}</td>
                    <td>{{ $letter->meeting_date->translatedFormat('d M Y') }}, {{ $letter->meeting_time }}</td>
                    <td>{{ $letter->generatedBy->name }}</td>
                    <td>
                        <a href="{{ route('summon.pdf', $letter) }}" target="_blank" class="btn-pill btn-pill-blue">Lihat PDF</a>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" class="text-center text-gray-400">Belum ada surat yang pernah dibuat.</td></tr>
            @endforelse
        </tbody>
    </table></div>

    <div class="mt-4">{{ $history->links() }}</div>
@endsection
