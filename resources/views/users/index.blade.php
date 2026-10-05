@extends('layouts.main')

@section('content')
    <x-page-header title="Kelola Akun" subtitle="Akun admin dan guru yang dapat mengakses aplikasi.">
        <a href="{{ route('users.create') }}" class="btn-primary btn-sm">
            <x-icon name="plus" />
            Buat Akun
        </a>
    </x-page-header>

    <div class="table-scroll"><table class="table-fresh">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Role</th>
                <th>Kelas (wali)</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
                @php
                    $initials = collect(preg_split('/\s+/', trim($user->name)))
                        ->filter()->take(2)
                        ->map(fn ($word) => mb_strtoupper(mb_substr($word, 0, 1)))
                        ->implode('');
                @endphp
                <tr>
                    <td>
                        <span class="flex items-center gap-3">
                            <span class="avatar">{{ $initials }}</span>
                            <span class="min-w-0">
                                <span class="block font-semibold text-slate-900">
                                    {{ $user->name }}
                                    @if($user->id === auth()->id())
                                        <span class="ml-1 text-[0.7rem] font-medium text-slate-400">(Anda)</span>
                                    @endif
                                </span>
                                <span class="block text-xs text-slate-500">{{ $user->email }}</span>
                            </span>
                        </span>
                    </td>
                    <td>
                        <span class="badge {{ $user->role === 'admin' ? 'badge-blue' : 'badge-gray' }}">
                            {{ ucfirst($user->role) }}
                        </span>
                    </td>
                    <td class="cell-muted">{{ $user->schoolClass->name ?? '-' }}</td>
                    <td class="cell-actions">
                        <a href="{{ route('users.edit', $user) }}" class="btn-pill btn-pill-blue"><x-icon name="pencil" /> Ubah</a>
                        @if($user->id !== auth()->id())
                            <form method="POST" action="{{ route('users.destroy', $user) }}" class="inline"
                                  onsubmit="return confirmDelete(this, 'Akun ini akan dihapus permanen.')">
                                @csrf @method('DELETE')
                                <button class="btn-pill btn-pill-red"><x-icon name="trash" /> Hapus</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="4"><x-empty-state icon="users">Belum ada akun.</x-empty-state></td></tr>
            @endforelse
        </tbody>
    </table></div>

    <div class="mt-5">{{ $users->links() }}</div>
@endsection
