<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Daftar Saldo Santri</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            padding: 0;
            font-size: 24px;
        }
        .tanggal {
            text-align: right;
            margin-bottom: 20px;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
            font-size: 12px;
        }
        th {
            background-color: #f2f2f2;
        }
        .text-right {
            text-align: right;
        }
        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: center;
            font-size: 10px;
            padding: 10px 0;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Daftar Saldo Santri</h1>
        <p>Pondok Pesantren</p>
    </div>

    <div class="tanggal">
        Dicetak pada: {{ $tanggal }}
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 5%">No</th>
                <th style="width: 15%">NIS</th>
                <th style="width: 25%">Nama Santri</th>
                <th style="width: 15%">Kelas</th>
                <th style="width: 13%">Saldo Utama</th>
                <th style="width: 13%">Saldo Belanja</th>
                <th style="width: 14%">Saldo Tabungan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($santri as $index => $s)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $s->nis }}</td>
                <td>{{ $s->nama }}</td>
                <td>{{ optional($s->tingkatan)->nama }}</td>
                <td class="text-right">Rp {{ number_format($s->saldo_utama, 0, ',', '.') }}</td>
                <td class="text-right">Rp {{ number_format($s->saldo_belanja, 0, ',', '.') }}</td>
                <td class="text-right">Rp {{ number_format($s->saldo_tabungan, 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align: center">Tidak ada data santri</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Dokumen ini dicetak melalui Sistem Informasi Pondok Pesantren
    </div>
</body>
</html> 