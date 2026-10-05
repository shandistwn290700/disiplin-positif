@extends('layouts.main')

@section('content')
    <x-page-header title="Catatan Disiplin" subtitle="Riwayat seluruh catatan perilaku baik dan pelanggaran siswa.">
        <a href="{{ route('records.export.excel') }}" class="btn-secondary btn-sm">
            <x-icon name="download" class="text-emerald-600" />
            Export Excel
        </a>
        <a href="{{ route('records.export.pdf') }}" class="btn-secondary btn-sm">
            <x-icon name="document" class="text-red-600" />
            Export PDF
        </a>
        <a href="{{ route('records.create') }}" class="btn-primary btn-sm">
            <x-icon name="plus" />
            Tambah Catatan
        </a>
    </x-page-header>

    @include('partials.filter-bar', ['action' => route('records.index')])

    <div class="table-scroll"><table class="table-fresh">
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Siswa</th>
                <th>Kode</th>
                <th>Kategori</th>
                <th>Tingkat</th>
                <th>Poin</th>
                <th>Dicatat oleh</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse($records as $record)
                @php
                    $isPositive = $record->category->type === 'positif';
                    $severityBadge = ['ringan' => 'badge-amber', 'sedang' => 'badge-orange', 'berat' => 'badge-red'][$record->category->severity] ?? null;
                @endphp
                <tr>
                    <td class="cell-muted whitespace-nowrap">{{ $record->date->format('d M Y') }}</td>
                    <td class="cell-strong">{{ $record->student->name }}</td>
                    <td>
                        @if($record->category->code)
                            <span class="badge-code">{{ $record->category->code }}</span>
                        @else
                            <span class="text-slate-300">—</span>
                        @endif
                    </td>
                    <td>
                        <span class="inline-flex items-center gap-2 {{ $isPositive ? 'text-emerald-700' : 'text-red-700' }}">
                            <span class="w-1.5 h-1.5 rounded-full flex-shrink-0 {{ $isPositive ? 'bg-emerald-500' : 'bg-red-500' }}"></span>
                            {{ $record->category->name }}
                        </span>
                    </td>
                    <td>
                        @if($severityBadge)
                            <span class="badge {{ $severityBadge }}">{{ $record->category->severityLabel() }}</span>
                        @else
                            <span class="text-slate-300">—</span>
                        @endif
                    </td>
                    <td>
                        <span class="badge {{ $isPositive ? 'badge-green' : 'badge-red' }} tabular-nums">
                            {{ $record->category->points > 0 ? '+' : '' }}{{ $record->category->points }}
                        </span>
                    </td>
                    <td class="cell-muted whitespace-nowrap">{{ $record->recordedBy->name }}</td>
                    <td class="cell-actions">
                        <form method="POST" action="{{ route('records.destroy', $record) }}" class="inline"
                              onsubmit="return confirmDelete(this, 'Catatan ini akan dihapus permanen.')">
                            @csrf @method('DELETE')
                            <button class="btn-pill btn-pill-red"><x-icon name="trash" /> Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="8"><x-empty-state icon="clipboard">Belum ada catatan.</x-empty-state></td></tr>
            @endforelse
        </tbody>
    </table></div>

    <div class="mt-5">{{ $records->links() }}</div>
@endsection
