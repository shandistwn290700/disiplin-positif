@extends('layouts.main')

@section('content')
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3 mb-4">
        <h1 class="text-xl font-bold">Kelola Akun</h1>
        <a href="{{ route('users.create') }}" class="btn-primary btn-sm">
            + Buat Akun
        </a>
    </div>


    <div class="table-scroll"><table class="table-fresh">
        <thead>
            <tr>
                <th class="p-3 text-left">Nama</th>
                <th class="p-3 text-left">Email</th>
                <th class="p-3 text-left">Role</th>
                <th class="p-3 text-left">Kelas (wali)</th>
                <th class="p-3"></th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr class="border-t">
                    <td class="p-3">{{ $user->name }}</td>
                    <td class="p-3">{{ $user->email }}</td>
                    <td class="p-3">
                        <span class="{{ $user->role === 'admin' ? 'text-blue-600' : 'text-gray-600' }}">
                            {{ ucfirst($user->role) }}
                        </span>
                    </td>
                    <td class="p-3">{{ $user->schoolClass->name ?? '-' }}</td>
                    <td class="p-3 space-x-3">
                        <a href="{{ route('users.edit', $user) }}" class="btn-pill btn-pill-blue">Ubah</a>
                        @if($user->id !== auth()->id())
                            <form method="POST" action="{{ route('users.destroy', $user) }}" class="inline"
                                  onsubmit="return confirmDelete(this, 'Akun ini akan dihapus permanen.')">
                                @csrf @method('DELETE')
                                <button class="btn-pill btn-pill-red">Hapus</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table></div>

    <div class="mt-4">{{ $users->links() }}</div>
@endsection
