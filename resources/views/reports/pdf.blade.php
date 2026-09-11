<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Laporan Rekap Poin Siswa</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            color: #1f2937;
        }
        h1 {
            font-size: 18px;
            margin-bottom: 2px;
        }
        .subtitle {
            font-size: 11px;
            color: #6b7280;
            margin-bottom: 16px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #d1d5db;
            padding: 6px 8px;
            text-align: left;
        }
        th {
            background-color: #f3f4f6;
        }
        .text-right {
            text-align: right;
        }
        .positif {
            color: #16a34a;
            font-weight: bold;
        }
        .negatif {
            color: #dc2626;
            font-weight: bold;
        }
        .no-col {
            width: 30px;
            text-align: center;
        }
    </style>
</head>
<body>
    <h1>Laporan Rekap Poin Siswa</h1>
    <div class="subtitle">Dicetak pada {{ $generatedAt->translatedFormat('d F Y, H:i') }}</div>

    <table>
        <thead>
            <tr>
                <th class="no-col">No</th>
                <th>Nama</th>
                <th>Kelas</th>
                <th class="text-right">Total Poin</th>
            </tr>
        </thead>
        <tbody>
            @forelse($students as $index => $student)
                <tr>
                    <td class="no-col">{{ $index + 1 }}</td>
                    <td>{{ $student->name }}</td>
                    <td>{{ $student->schoolClass->name ?? '-' }}</td>
                    <td class="text-right {{ $student->total_points >= 0 ? 'positif' : 'negatif' }}">
                        {{ $student->total_points }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" style="text-align:center; color:#9ca3af;">Belum ada data.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
