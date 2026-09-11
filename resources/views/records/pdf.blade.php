<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Catatan Disiplin</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 11px;
            color: #1f2937;
        }
        h1 {
            font-size: 18px;
            margin-bottom: 2px;
        }
        .subtitle {
            font-size: 10px;
            color: #6b7280;
            margin-bottom: 16px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #d1d5db;
            padding: 5px 7px;
            text-align: left;
        }
        th {
            background-color: #f3f4f6;
        }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .positif { color: #16a34a; font-weight: bold; }
        .negatif { color: #dc2626; font-weight: bold; }
        .no-col { width: 26px; }
    </style>
</head>
<body>
    <h1>Catatan Disiplin</h1>
    <div class="subtitle">Dicetak pada {{ $generatedAt->translatedFormat('d F Y, H:i') }}</div>

    <table>
        <thead>
            <tr>
                <th class="no-col text-center">No</th>
                <th>Tanggal</th>
                <th>Siswa</th>
                <th>Kode</th>
                <th>Kategori</th>
                <th>Tingkat</th>
                <th class="text-right">Poin</th>
                <th>Dicatat Oleh</th>
            </tr>
        </thead>
        <tbody>
            @forelse($records as $index => $record)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $record->date->format('d M Y') }}</td>
                    <td>{{ $record->student->name }}</td>
                    <td>{{ $record->category->code ?? '-' }}</td>
                    <td>{{ $record->category->name ?? '-' }}</td>
                    <td>{{ $record->category->severityLabel() ?? '-' }}</td>
                    <td class="text-right {{ ($record->category->points ?? 0) >= 0 ? 'positif' : 'negatif' }}">
                        {{ $record->category->points ?? 0 }}
                    </td>
                    <td>{{ $record->recordedBy->name ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center" style="color:#9ca3af;">Belum ada catatan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
