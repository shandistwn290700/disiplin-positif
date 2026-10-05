{{-- Aset & gaya bersama untuk semua halaman (layout utama, halaman tamu, halaman depan, halaman error) --}}
<link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800&display=swap" rel="stylesheet" />
<script src="https://cdn.tailwindcss.com"></script>
<script>
    tailwind.config = {
        theme: {
            extend: {
                fontFamily: { sans: ['"Plus Jakarta Sans"', 'ui-sans-serif', 'system-ui', 'sans-serif'] },
                colors: {
                    brand: {
                        50: '#eff6ff', 100: '#dbeafe', 200: '#bfdbfe', 300: '#93c5fd', 400: '#60a5fa',
                        500: '#3b82f6', 600: '#2563eb', 700: '#1d4ed8', 800: '#1e40af', 900: '#1e3a8a', 950: '#172554',
                    },
                },
            },
        },
    };
</script>
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.1/dist/cdn.min.js"></script>

<style>
    :root {
        --brand-50: #eff6ff; --brand-100: #dbeafe; --brand-200: #bfdbfe; --brand-500: #3b82f6;
        --brand-600: #2563eb; --brand-700: #1d4ed8; --brand-800: #1e40af; --brand-900: #1e3a8a;
        --ink: #0f172a; --ink-2: #334155; --muted: #64748b; --subtle: #94a3b8;
        --line: #e6eaf1; --line-soft: #f1f4f8; --surface: #ffffff; --bg: #f5f7fb;
        --ring: 0 0 0 4px rgba(59, 130, 246, 0.16);
    }

    [x-cloak] { display: none !important; }
    html { -webkit-text-size-adjust: 100%; }
    body { font-family: 'Plus Jakarta Sans', ui-sans-serif, system-ui, sans-serif; -webkit-font-smoothing: antialiased; }

    /* ---------- Judul halaman ---------- */
    .page-title { font-size: 1.5rem; line-height: 2rem; font-weight: 800; letter-spacing: -0.02em; color: var(--ink); }
    .page-subtitle { margin-top: 0.25rem; font-size: 0.875rem; color: var(--muted); }
    .section-title { font-size: 0.95rem; font-weight: 700; color: var(--ink); }
    .section-subtitle { font-size: 0.8125rem; color: var(--muted); margin-top: 0.15rem; }

    /* ---------- Tombol ---------- */
    .btn-primary, .btn-secondary, .btn-danger {
        display: inline-flex; align-items: center; justify-content: center; gap: 0.5rem;
        font-weight: 600; font-size: 0.875rem; line-height: 1.25rem; white-space: nowrap;
        padding: 0.625rem 1.25rem; border-radius: 0.7rem; cursor: pointer;
        transition: background-color .15s ease, box-shadow .15s ease, border-color .15s ease, transform .1s ease, color .15s ease;
    }
    .btn-primary {
        color: #fff; border: 1px solid var(--brand-700);
        background: linear-gradient(180deg, var(--brand-600) 0%, var(--brand-700) 100%);
        box-shadow: 0 1px 2px rgba(15, 23, 42, .08), inset 0 1px 0 rgba(255, 255, 255, .14);
    }
    .btn-primary:hover { background: linear-gradient(180deg, var(--brand-700) 0%, var(--brand-800) 100%); box-shadow: 0 6px 16px -4px rgba(29, 78, 216, .45); }
    .btn-secondary { color: var(--ink-2); background: #fff; border: 1px solid #d9dee7; box-shadow: 0 1px 2px rgba(15, 23, 42, .04); }
    .btn-secondary:hover { background: #f8fafc; border-color: #c4ccd8; color: var(--ink); }
    .btn-danger { color: #fff; border: 1px solid #b91c1c; background: linear-gradient(180deg, #ef4444 0%, #dc2626 100%); box-shadow: 0 1px 2px rgba(15, 23, 42, .08); }
    .btn-danger:hover { background: linear-gradient(180deg, #dc2626 0%, #b91c1c 100%); box-shadow: 0 6px 16px -4px rgba(220, 38, 38, .45); }
    .btn-primary:active, .btn-secondary:active, .btn-danger:active { transform: scale(.97); }
    .btn-primary:focus-visible, .btn-secondary:focus-visible, .btn-danger:focus-visible, .btn-pill:focus-visible { outline: none; box-shadow: var(--ring); }
    .btn-sm { padding: 0.5rem 0.95rem; font-size: 0.8125rem; border-radius: 0.6rem; }
    .btn-primary svg, .btn-secondary svg, .btn-danger svg { width: 1rem; height: 1rem; flex-shrink: 0; }

    .btn-pill {
        display: inline-flex; align-items: center; gap: 0.3rem; font-size: 0.75rem; font-weight: 600;
        padding: 0.35rem 0.75rem; border-radius: 9999px; white-space: nowrap; cursor: pointer;
        transition: background-color .15s ease, transform .1s ease;
    }
    .btn-pill:active { transform: scale(.95); }
    .btn-pill svg { width: 0.875rem; height: 0.875rem; }
    .btn-pill-blue { background-color: var(--brand-50); color: var(--brand-700); }
    .btn-pill-blue:hover { background-color: var(--brand-100); }
    .btn-pill-red { background-color: #fef2f2; color: #dc2626; }
    .btn-pill-red:hover { background-color: #fee2e2; }

    /* ---------- Kartu ---------- */
    .card { background: var(--surface); border: 1px solid var(--line); border-radius: 1rem; box-shadow: 0 1px 2px rgba(15, 23, 42, .04), 0 1px 3px rgba(15, 23, 42, .03); }
    .card-header { display: flex; align-items: flex-start; gap: 0.85rem; padding: 1.25rem 1.5rem; border-bottom: 1px solid var(--line-soft); }
    .card-body { padding: 1.5rem; }
    .card-footer { padding: 1rem 1.5rem; border-top: 1px solid var(--line-soft); background: #fafbfd; border-radius: 0 0 1rem 1rem; }
    .icon-tile { display: inline-flex; align-items: center; justify-content: center; width: 2.5rem; height: 2.5rem; border-radius: 0.75rem; flex-shrink: 0; }
    .icon-tile svg { width: 1.25rem; height: 1.25rem; }

    /* ---------- Form ---------- */
    .form-label { display: block; font-size: 0.8125rem; font-weight: 600; color: var(--ink-2); margin-bottom: 0.4rem; }
    .form-hint { font-size: 0.75rem; color: var(--muted); margin-top: 0.4rem; }
    .form-control {
        display: block; background-color: #fff; color: var(--ink);
        border: 1px solid #d5dbe5; border-radius: 0.7rem;
        padding: 0.625rem 0.875rem; font-size: 0.875rem; line-height: 1.25rem;
        box-shadow: 0 1px 2px rgba(15, 23, 42, .03);
        transition: border-color .15s ease, box-shadow .15s ease;
    }
    .form-control::placeholder { color: var(--subtle); }
    .form-control:hover { border-color: #c2cad7; }
    .form-control:focus { outline: none; border-color: var(--brand-500); box-shadow: var(--ring); }
    select.form-control {
        -webkit-appearance: none; appearance: none; padding-right: 2.5rem;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%2364748b' stroke-width='2'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='m19.5 8.25-7.5 7.5-7.5-7.5'/%3E%3C/svg%3E");
        background-repeat: no-repeat; background-position: right 0.8rem center; background-size: 1rem;
    }
    textarea.form-control { min-height: 5.5rem; resize: vertical; }
    input[type=file].form-control { padding: 0.4rem; cursor: pointer; color: var(--muted); }
    input[type=file].form-control::file-selector-button {
        margin-right: 0.85rem; border: 0; border-radius: 0.5rem; cursor: pointer;
        padding: 0.45rem 0.9rem; font-weight: 600; font-size: 0.8125rem;
        background: var(--brand-50); color: var(--brand-700); transition: background-color .15s ease;
    }
    input[type=file].form-control:hover::file-selector-button { background: var(--brand-100); }
    .input-icon { position: relative; }
    .input-icon > svg { position: absolute; left: 0.85rem; top: 50%; transform: translateY(-50%); width: 1.05rem; height: 1.05rem; color: var(--subtle); pointer-events: none; }
    .input-icon > .form-control { padding-left: 2.5rem; }
    input[type=checkbox] { accent-color: var(--brand-600); width: 1rem; height: 1rem; }

    /* ---------- Tabel ---------- */
    .table-scroll {
        overflow-x: auto; -webkit-overflow-scrolling: touch;
        background: var(--surface); border: 1px solid var(--line); border-radius: 1rem;
        box-shadow: 0 1px 2px rgba(15, 23, 42, .04), 0 1px 3px rgba(15, 23, 42, .03);
    }
    .table-fresh { width: 100%; border-collapse: separate; border-spacing: 0; font-size: 0.875rem; }
    .table-fresh thead th {
        text-align: left; padding: 0.8rem 1.15rem; background: #f8fafc; white-space: nowrap;
        font-size: 0.6875rem; font-weight: 700; letter-spacing: 0.06em; text-transform: uppercase; color: var(--muted);
        border-bottom: 1px solid var(--line);
    }
    .table-fresh tbody td { padding: 0.9rem 1.15rem; color: var(--ink-2); border-top: 1px solid var(--line-soft); vertical-align: middle; }
    .table-fresh tbody tr:first-child td { border-top: none; }
    .table-fresh tbody tr { transition: background-color .12s ease; }
    .table-fresh tbody tr:hover td { background-color: #f8fafd; }
    .table-fresh .cell-strong { font-weight: 600; color: var(--ink); }
    .table-fresh .cell-muted { color: var(--muted); }
    .table-fresh .cell-actions { text-align: right; white-space: nowrap; }
    .table-fresh .cell-actions > * + * { margin-left: 0.4rem; }

    /* ---------- Badge ---------- */
    .badge {
        display: inline-flex; align-items: center; gap: 0.35rem; white-space: nowrap;
        font-size: 0.75rem; font-weight: 600; line-height: 1rem; padding: 0.25rem 0.625rem; border-radius: 9999px;
    }
    .badge-dot::before { content: ''; width: 0.4rem; height: 0.4rem; border-radius: 9999px; background: currentColor; }
    .badge-green { background: #ecfdf5; color: #047857; box-shadow: inset 0 0 0 1px rgba(16, 185, 129, .2); }
    .badge-red { background: #fef2f2; color: #b91c1c; box-shadow: inset 0 0 0 1px rgba(239, 68, 68, .2); }
    .badge-amber { background: #fffbeb; color: #b45309; box-shadow: inset 0 0 0 1px rgba(245, 158, 11, .25); }
    .badge-orange { background: #fff7ed; color: #c2410c; box-shadow: inset 0 0 0 1px rgba(249, 115, 22, .22); }
    .badge-blue { background: var(--brand-50); color: var(--brand-700); box-shadow: inset 0 0 0 1px rgba(59, 130, 246, .2); }
    .badge-gray { background: #f1f5f9; color: #475569; box-shadow: inset 0 0 0 1px rgba(100, 116, 139, .15); }
    .badge-code { font-family: ui-monospace, SFMono-Regular, Menlo, monospace; font-size: 0.72rem; background: #f1f5f9; color: #334155; padding: 0.2rem 0.5rem; border-radius: 0.4rem; }

    /* ---------- Avatar ---------- */
    .avatar {
        display: inline-flex; align-items: center; justify-content: center; flex-shrink: 0;
        width: 2.25rem; height: 2.25rem; border-radius: 9999px; font-size: 0.8rem; font-weight: 700;
        color: var(--brand-700); background: linear-gradient(135deg, var(--brand-100), #e0e7ff);
    }

    /* ---------- Alert ---------- */
    .alert { display: flex; gap: 0.75rem; align-items: flex-start; padding: 1rem 1.15rem; border-radius: 0.85rem; font-size: 0.875rem; border: 1px solid; }
    .alert > svg { width: 1.25rem; height: 1.25rem; flex-shrink: 0; margin-top: 0.05rem; }
    .alert-info { background: #f0f7ff; border-color: #cfe2ff; color: #1e3a8a; }
    .alert-warning { background: #fffbeb; border-color: #fde68a; color: #92400e; }
    .alert-success { background: #ecfdf5; border-color: #a7f3d0; color: #065f46; }

    /* ---------- Empty state ---------- */
    .empty-state { display: flex; flex-direction: column; align-items: center; gap: 0.6rem; padding: 2.5rem 1rem; text-align: center; color: var(--muted); font-size: 0.875rem; }
    .empty-state svg { width: 2.5rem; height: 2.5rem; color: #cbd5e1; }

    /* ---------- Segmented control ---------- */
    .segmented { display: inline-flex; padding: 0.25rem; gap: 0.25rem; background: #eef1f6; border-radius: 0.8rem; }
    .segmented a { padding: 0.45rem 0.95rem; border-radius: 0.6rem; font-size: 0.8125rem; font-weight: 600; color: var(--muted); transition: all .15s ease; }
    .segmented a:hover { color: var(--ink); }
    .segmented a.active { background: #fff; color: var(--brand-700); box-shadow: 0 1px 3px rgba(15, 23, 42, .1); }

    /* ---------- Pagination bawaan Laravel ---------- */
    nav[role=navigation] { font-size: 0.875rem; }

    /* ---------- SweetAlert ---------- */
    .swal2-popup { font-family: inherit !important; border-radius: 1.1rem !important; }
    .swal2-styled { border-radius: 0.65rem !important; font-weight: 600 !important; }
    .swal2-toast { border-radius: 0.85rem !important; box-shadow: 0 10px 30px -10px rgba(15, 23, 42, .3) !important; }

    @media (prefers-reduced-motion: reduce) {
        *, *::before, *::after { transition-duration: 0.01ms !important; animation-duration: 0.01ms !important; }
    }
</style>
