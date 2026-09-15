<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Surat Pemanggilan - {{ $letter->student->name }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            color: #111827;
            line-height: 1.5;
        }
        .kop { text-align: center; }
        .kop .baris1 { font-size: 12px; font-weight: bold; }
        .kop .baris2 { font-size: 16px; font-weight: bold; letter-spacing: 2px; }
        .kop .baris3 { font-size: 11px; }
        .kop .baris4 { font-size: 11px; }
        .garis-tebal { border-top: 3px solid #111827; margin-top: 4px; }
        .garis-tipis { border-top: 1px solid #111827; margin-top: 1px; margin-bottom: 14px; }

        table.info { width: 100%; margin-bottom: 14px; }
        table.info td { vertical-align: top; padding: 0; border: none; }
        .label-col { width: 70px; }

        .isi p { text-align: justify; margin: 8px 0; }

        table.data-siswa { margin: 10px 0 10px 20px; }
        table.data-siswa td { border: none; padding: 2px 0; }
        table.data-siswa .label { width: 110px; }

        table.ketentuan { margin: 10px 0 10px 20px; }
        table.ketentuan td { border: none; padding: 2px 0; }
        table.ketentuan .label { width: 130px; }

        table.ttd { width: 100%; margin-top: 30px; text-align: center; }
        table.ttd td { border: none; padding: 0; vertical-align: top; }
        .ttd .spasi { height: 55px; }
        .ttd .nama { font-weight: bold; text-decoration: underline; }
    </style>
</head>
<body>

    {{-- Kop surat --}}
    <div class="kop">
        @if($setting->school_government_line)
            <div class="baris1">{{ strtoupper($setting->school_government_line) }}</div>
        @endif
        <div class="baris2">{{ strtoupper($setting->school_name ?? 'NAMA SEKOLAH') }}</div>
        @if($setting->school_address)
            <div class="baris3">{{ $setting->school_address }}</div>
        @endif
        @if($setting->school_email)
            <div class="baris4">Pos-el : {{ $setting->school_email }}</div>
        @endif
    </div>
    <div class="garis-tebal"></div>
    <div class="garis-tipis"></div>

    {{-- Nomor surat & tanggal --}}
    <table class="info">
        <tr>
            <td style="width:60%;">
                <table style="width:100%;">
                    <tr><td class="label-col">Nomor</td><td>: {{ $letter->letter_number }}</td></tr>
                    <tr><td class="label-col">Lamp.</td><td>: -</td></tr>
                    <tr><td class="label-col">Hal</td><td>: Pemanggilan Orang Tua</td></tr>
                </table>
            </td>
            <td style="width:40%; text-align:right; vertical-align:top;">
                {{ $setting->school_city ?? '' }}, {{ $letter->created_at->locale('id')->translatedFormat('d F Y') }}
            </td>
        </tr>
    </table>

    <p>Kepada :<br>
    Yth. Bapak/Ibu Wali Murid<br>
    ({{ $letter->student->name }})<br>
    di<br>
    &emsp;&emsp;tempat</p>

    <div class="isi">
        <p>Assalamu'alaikum Warahmatullahi Wabarakatuh,</p>

        <p>Puji dan Syukur marilah kita panjatkan ke hadirat Allah Azza wa Jalla. Selawat serta salam
        semoga senantiasa dilimpahcurahkan kepada Nabi Muhammad Shallallahu 'alaihi Wasallam, kepada
        keluarganya, Sahabatnya, hingga sampai kepada kita selaku umat yang menjalankan ajarannya.</p>

        <p>Selanjutnya, kami mengundang Bapak/Ibu wali murid dari :</p>

        <table class="data-siswa">
            <tr><td class="label">Nama Siswa</td><td>: {{ $letter->student->name }}</td></tr>
            <tr><td class="label">Kelas</td><td>: {{ $letter->student->schoolClass->name }}</td></tr>
        </table>

        <p>Untuk hadir dengan ketentuan sebagai berikut :</p>

        <table class="ketentuan">
            <tr><td class="label">Hari, tanggal</td><td>: {{ $letter->meeting_date->locale('id')->translatedFormat('l, d F Y') }}</td></tr>
            <tr><td class="label">Waktu</td><td>: {{ $letter->meeting_time }} WIB</td></tr>
            <tr><td class="label">Tempat</td><td>: {{ $setting->school_name ?? '-' }}</td></tr>
            <tr><td class="label">Keterangan</td><td>: Menemui Waka Kesiswaan</td></tr>
        </table>

        <p>Demikian surat ini disampaikan, atas perhatian dan kehadirannya kami ucapkan
        Jazakumullahu Khairan Katsiran.</p>

        <p>Wassalamu'alaikum Warahmatullahi Wabarakatuh,</p>
    </div>

    {{-- Tanda tangan --}}
    <table class="ttd">
        <tr>
            <td style="width:50%;"></td>
            <td style="width:50%;">Kepala Sekolah</td>
        </tr>
        <tr>
            <td>Waka Kesiswaan,</td>
            <td>{{ $setting->school_name ?? '' }},</td>
        </tr>
        <tr>
            <td class="spasi"></td>
            <td class="spasi"></td>
        </tr>
        <tr>
            <td class="nama">{{ $setting->waka_kesiswaan_name ?? '(.....................)' }}</td>
            <td class="nama">{{ $setting->principal_name ?? '(.....................)' }}</td>
        </tr>
    </table>

</body>
</html>
