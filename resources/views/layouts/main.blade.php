<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Formulir Disiplin Positif</title>
    @include('partials.favicon')
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        tailwind.config = { theme: { extend: { fontFamily: { sans: ['Figtree', 'sans-serif'] } } } };
    </script>

    <style>
        body { font-family: 'Figtree', sans-serif; }

        /* Tombol */
        .btn-primary {
            display: inline-flex; align-items: center; justify-content: center;
            background-color: #1d4ed8; color: #fff; font-weight: 600;
            padding: 0.625rem 1.5rem; border-radius: 0.6rem;
            box-shadow: 0 1px 2px rgba(0,0,0,0.06);
            transition: background-color 0.15s ease, box-shadow 0.15s ease, transform 0.1s ease;
        }
        .btn-primary:hover { background-color: #1e40af; box-shadow: 0 4px 10px rgba(29,78,216,0.25); }
        .btn-primary:active { transform: scale(0.97); }

        .btn-secondary {
            display: inline-flex; align-items: center; justify-content: center;
            background-color: #fff; color: #374151; font-weight: 600;
            padding: 0.625rem 1.5rem; border-radius: 0.6rem;
            border: 1px solid #d1d5db;
            transition: background-color 0.15s ease, border-color 0.15s ease, transform 0.1s ease;
        }
        .btn-secondary:hover { background-color: #f9fafb; border-color: #9ca3af; }
        .btn-secondary:active { transform: scale(0.97); }

        .btn-sm { padding: 0.5rem 1.1rem; font-size: 0.875rem; border-radius: 0.5rem; }

        .btn-pill {
            display: inline-block; font-size: 0.75rem; font-weight: 600;
            padding: 0.3rem 0.75rem; border-radius: 9999px;
            transition: background-color 0.15s ease, transform 0.1s ease;
        }
        .btn-pill:active { transform: scale(0.95); }
        .btn-pill-blue { background-color: #eff6ff; color: #1d4ed8; }
        .btn-pill-blue:hover { background-color: #dbeafe; }
        .btn-pill-red { background-color: #fef2f2; color: #dc2626; }
        .btn-pill-red:hover { background-color: #fee2e2; }

        /* Tabel fresh */
        .table-fresh {
            width: 100%; background: #fff; border-radius: 0.85rem; overflow: hidden;
            border: 1px solid #eef0f3; box-shadow: 0 1px 3px rgba(0,0,0,0.03);
            border-collapse: separate; border-spacing: 0; font-size: 0.875rem;
        }
        .table-fresh thead { background-color: #f8fafc; }
        .table-fresh th {
            text-align: left; padding: 0.85rem 1.1rem; font-size: 0.7rem; font-weight: 700;
            letter-spacing: 0.04em; text-transform: uppercase; color: #64748b;
            border-bottom: 1px solid #eef0f3;
        }
        .table-fresh td { padding: 0.9rem 1.1rem; color: #1e293b; }
        .table-fresh tbody tr { border-top: 1px solid #f1f5f9; transition: background-color 0.1s ease; }
        .table-fresh tbody tr:first-child { border-top: none; }
        .table-fresh tbody tr:hover { background-color: #f8fafc; }

        .table-scroll { overflow-x: auto; -webkit-overflow-scrolling: touch; }

        /* Sidebar */
        .sidebar-link {
            display: flex; align-items: center; gap: 0.7rem;
            padding: 0.6rem 0.9rem; border-radius: 0.6rem; font-size: 0.875rem; font-weight: 500;
            color: #475569; transition: background-color 0.12s ease, color 0.12s ease;
        }
        .sidebar-link:hover { background-color: #eff6ff; color: #1d4ed8; }
        .sidebar-link.active { background-color: #1d4ed8; color: #fff; }
        .sidebar-link svg { width: 1.15rem; height: 1.15rem; flex-shrink: 0; }

        .sidebar-group-label {
            display: flex; align-items: center; justify-content: space-between; cursor: pointer;
            padding: 0.6rem 0.9rem; border-radius: 0.6rem; font-size: 0.875rem; font-weight: 500;
            color: #475569; transition: background-color 0.12s ease;
        }
        .sidebar-group-label:hover { background-color: #f1f5f9; }
        .sidebar-submenu { overflow: hidden; max-height: 0; transition: max-height 0.2s ease; }
        .sidebar-submenu.open { max-height: 200px; }
        .sidebar-submenu a {
            display: block; padding: 0.5rem 0.9rem 0.5rem 2.6rem; font-size: 0.825rem;
            color: #64748b; border-radius: 0.5rem;
        }
        .sidebar-submenu a:hover { background-color: #eff6ff; color: #1d4ed8; }
        .sidebar-submenu a.active { color: #1d4ed8; font-weight: 600; }

        .chevron { transition: transform 0.2s ease; }
        .chevron.rotated { transform: rotate(90deg); }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 overflow-x-hidden">

    <div id="page-loader" class="fixed inset-0 z-50 flex items-center justify-center bg-white transition-opacity duration-300">
        <div class="w-10 h-10 border-4 border-blue-200 border-t-blue-600 rounded-full animate-spin"></div>
    </div>

    <div class="flex min-h-screen">
        {{-- Sidebar --}}
        <aside id="sidebar" class="w-64 bg-white border-r border-gray-100 flex-shrink-0 flex flex-col fixed inset-y-0 left-0 z-40 -translate-x-full lg:translate-x-0 transition-transform duration-200">
            <div class="px-5 py-5 border-b border-gray-100">
                <span class="font-bold text-lg text-brand-800" style="color:#1e3a8a">Disiplin Positif</span>
            </div>

            <nav class="flex-1 overflow-y-auto px-3 py-4 space-y-1">
                <a href="{{ route('dashboard') }}" class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 13h4v8H3v-8zM10 3h4v18h-4V3zM17 8h4v13h-4V8z"/></svg>
                    Dashboard
                </a>

                @if(auth()->user()->isAdmin())
                    <div>
                        <div class="sidebar-group-label" onclick="toggleGroup('grp-administrasi')">
                            <span class="flex items-center gap-2">
                                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 21h18M5 21V7l7-4 7 4v14M9 9h1m4 0h1m-6 4h1m4 0h1m-6 4h1m4 0h1"/></svg>
                                Administrasi
                            </span>
                            <svg id="chev-grp-administrasi" class="chevron w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                        </div>
                        <div id="grp-administrasi" class="sidebar-submenu {{ request()->routeIs('students.*') || request()->routeIs('classes.*') ? 'open' : '' }}">
                            <a href="{{ route('students.index') }}" class="{{ request()->routeIs('students.*') ? 'active' : '' }}">Data Siswa</a>
                            <a href="{{ route('classes.index') }}" class="{{ request()->routeIs('classes.*') ? 'active' : '' }}">Kelas</a>
                        </div>
                    </div>
                @else
                    {{-- Guru: hanya boleh lihat & cari data siswa di kelasnya sendiri, tanpa kelola kelas --}}
                    <a href="{{ route('students.index') }}" class="sidebar-link {{ request()->routeIs('students.*') ? 'active' : '' }}">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 21h18M5 21V7l7-4 7 4v14M9 9h1m4 0h1m-6 4h1m4 0h1m-6 4h1m4 0h1"/></svg>
                        Data Siswa
                    </a>
                @endif

                <div>
                    <div class="sidebar-group-label" onclick="toggleGroup('grp-pencatatan')">
                        <span class="flex items-center gap-2">
                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.4-9.4a2 2 0 112.8 2.8L11 19l-4 1 1-4 9.6-9.6z"/></svg>
                            Pencatatan
                        </span>
                        <svg id="chev-grp-pencatatan" class="chevron w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                    </div>
                    <div id="grp-pencatatan" class="sidebar-submenu {{ request()->routeIs('records.*') || request()->routeIs('reports.*') ? 'open' : '' }}">
                        <a href="{{ route('records.create') }}" class="{{ request()->routeIs('records.create') ? 'active' : '' }}">Catat Perilaku</a>
                        <a href="{{ route('records.index') }}" class="{{ request()->routeIs('records.index') ? 'active' : '' }}">Riwayat Catatan</a>
                        <a href="{{ route('reports.index') }}" class="{{ request()->routeIs('reports.*') ? 'active' : '' }}">Poin Siswa</a>
                    </div>
                </div>

                @if(auth()->user()->isAdmin())
                    <a href="{{ route('users.index') }}" class="sidebar-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m6-1.13a4 4 0 10-4-4m4 4a4 4 0 100-4m0 4v6m-6-2a4 4 0 018 0"/></svg>
                        Kelola Akun
                    </a>

                    <div>
                        <div class="sidebar-group-label" onclick="toggleGroup('grp-pengaturan')">
                            <span class="flex items-center gap-2">
                                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="2"/></svg>
                                Pengaturan
                            </span>
                            <svg id="chev-grp-pengaturan" class="chevron w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                        </div>
                        <div id="grp-pengaturan" class="sidebar-submenu {{ request()->routeIs('settings.*') || request()->routeIs('categories.*') ? 'open' : '' }}">
                            <a href="{{ route('settings.edit') }}" class="{{ request()->routeIs('settings.*') ? 'active' : '' }}">Tampilan</a>
                            <a href="{{ route('categories.index') }}" class="{{ request()->routeIs('categories.*') ? 'active' : '' }}">Kategori</a>
                        </div>
                    </div>
                @endif
            </nav>

            <div class="px-3 py-4 border-t border-gray-100">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="sidebar-link w-full text-left" style="color:#dc2626">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        Keluar
                    </button>
                </form>
            </div>
        </aside>

        {{-- Overlay untuk mobile saat sidebar terbuka --}}
        <div id="sidebar-overlay" class="fixed inset-0 bg-black/30 z-30 hidden lg:hidden" onclick="toggleSidebar()"></div>

        {{-- Konten utama --}}
        <div class="flex-1 lg:ml-64 flex flex-col min-w-0">
            {{-- Topbar mobile --}}
            <div class="lg:hidden bg-white border-b border-gray-100 px-4 py-3 flex items-center gap-3">
                <button onclick="toggleSidebar()" class="text-gray-600">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
                <span class="font-bold text-brand-800" style="color:#1e3a8a">Disiplin Positif</span>
            </div>

            <main class="flex-1 max-w-5xl w-full mx-auto p-4 sm:p-6">
                @yield('content')
            </main>
        </div>
    </div>

    <script>
        window.addEventListener('load', function () {
            const loader = document.getElementById('page-loader');
            if (loader) { loader.style.opacity = '0'; setTimeout(() => loader.remove(), 300); }
        });

        function toggleGroup(id) {
            document.getElementById(id).classList.toggle('open');
            document.getElementById('chev-' + id).classList.toggle('rotated');
        }

        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('-translate-x-full');
            document.getElementById('sidebar-overlay').classList.toggle('hidden');
        }

        function confirmDelete(form, message) {
            Swal.fire({
                title: 'Yakin?', text: message || 'Data ini akan dihapus secara permanen.', icon: 'warning',
                showCancelButton: true, confirmButtonColor: '#dc2626', cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, hapus', cancelButtonText: 'Batal',
            }).then((result) => { if (result.isConfirmed) form.submit(); });
            return false;
        }

        @if(session('success'))
            Swal.fire({ toast: true, position: 'top-end', icon: 'success', title: @json(session('success')), showConfirmButton: false, timer: 3000, timerProgressBar: true });
        @endif
        @if(session('error'))
            Swal.fire({ toast: true, position: 'top-end', icon: 'error', title: @json(session('error')), showConfirmButton: false, timer: 4000, timerProgressBar: true });
        @endif

        @if(session('just_logged_in'))
            Swal.fire({
                title: 'Selamat datang, {{ auth()->user()->name }}!',
                text: @json(\App\Models\SiteSetting::current()->welcome_message ?: 'Senang bertemu lagi. Yuk mulai catat perkembangan siswa hari ini.'),
                icon: 'success',
                confirmButtonText: 'Mulai',
                confirmButtonColor: '#1d4ed8',
            });
        @endif
    </script>
</body>
</html>
