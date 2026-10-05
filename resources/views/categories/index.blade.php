@extends('layouts.main')

@section('content')
    <x-page-header title="Kelola Kategori" subtitle="Jenis perilaku beserta bobot poinnya.">
        <a href="{{ route('categories.create') }}" class="btn-primary btn-sm">
            <x-icon name="plus" />
            Tambah Kategori
        </a>
    </x-page-header>

    <div class="table-scroll"><table class="table-fresh">
        <thead>
            <tr>
                <th>Kode</th>
                <th>Nama</th>
                <th>Tipe</th>
                <th>Tingkat</th>
                <th>Poin</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse($categories as $category)
                @php
                    $isPositive = $category->type === 'positif';
                    $severityBadge = ['ringan' => 'badge-amber', 'sedang' => 'badge-orange', 'berat' => 'badge-red'][$category->severity] ?? null;
                @endphp
                <tr>
                    <td>
                        @if($category->code)
                            <span class="badge-code">{{ $category->code }}</span>
                        @else
                            <span class="text-slate-300">—</span>
                        @endif
                    </td>
                    <td class="cell-strong">{{ $category->name }}</td>
                    <td>
                        <span class="badge badge-dot {{ $isPositive ? 'badge-green' : 'badge-red' }}">
                            {{ ucfirst($category->type) }}
                        </span>
                    </td>
                    <td>
                        @if($severityBadge)
                            <span class="badge {{ $severityBadge }}">{{ $category->severityLabel() }}</span>
                        @else
                            <span class="text-slate-300">—</span>
                        @endif
                    </td>
                    <td class="font-semibold tabular-nums {{ $isPositive ? 'text-emerald-600' : 'text-red-600' }}">
                        {{ $category->points > 0 ? '+' : '' }}{{ $category->points }}
                    </td>
                    <td class="cell-actions">
                        <form method="POST" action="{{ route('categories.destroy', $category) }}" class="inline"
                              onsubmit="return confirmDelete(this, 'Kategori ini akan dihapus permanen.')">
                            @csrf @method('DELETE')
                            <button class="btn-pill btn-pill-red"><x-icon name="trash" /> Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6"><x-empty-state icon="tag">Belum ada kategori.</x-empty-state></td></tr>
            @endforelse
        </tbody>
    </table></div>
@endsection
