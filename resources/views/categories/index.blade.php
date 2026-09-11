@extends('layouts.main')

@section('content')
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3 mb-4">
        <h1 class="text-xl font-bold">Kelola Kategori</h1>
        <a href="{{ route('categories.create') }}" class="btn-primary btn-sm">
            + Tambah Kategori
        </a>
    </div>

    <div class="table-scroll"><table class="table-fresh">
        <thead>
            <tr>
                <th class="p-3 text-left">Kode</th>
                <th class="p-3 text-left">Nama</th>
                <th class="p-3 text-left">Tipe</th>
                <th class="p-3 text-left">Tingkat</th>
                <th class="p-3 text-left">Poin</th>
                <th class="p-3"></th>
            </tr>
        </thead>
        <tbody>
            @foreach($categories as $category)
                <tr class="border-t">
                    <td class="p-3">{{ $category->code ?? '-' }}</td>
                    <td class="p-3">{{ $category->name }}</td>
                    <td class="p-3">
                        <span class="{{ $category->type === 'positif' ? 'text-green-600' : 'text-red-600' }}">
                            {{ ucfirst($category->type) }}
                        </span>
                    </td>
                    <td class="p-3">{{ $category->severityLabel() ?? '-' }}</td>
                    <td class="p-3">{{ $category->points > 0 ? '+' : '' }}{{ $category->points }}</td>
                    <td class="p-3">
                        <form method="POST" action="{{ route('categories.destroy', $category) }}"
                              onsubmit="return confirmDelete(this, 'Kategori ini akan dihapus permanen.')">
                            @csrf @method('DELETE')
                            <button class="btn-pill btn-pill-red">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table></div>
@endsection
