<!DOCTYPE html>
<html>
<head>
    <title>Laporan Akun dan Saldo</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            padding: 0;
            font-size: 18px;
        }
        .header p {
            margin: 5px 0;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
        .text-right {
            text-align: right;
        }
        .footer {
            margin-top: 20px;
            text-align: right;
            font-size: 10px;
        }
        .summary {
            margin-bottom: 20px;
        }
        .summary table {
            width: 100%;
        }
        .summary th {
            text-align: left;
            width: 200px;
        }
        .summary td {
            text-align: right;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN AKUN DAN SALDO</h1>
        <p>Tanggal Cetak: {{ $tanggal }}</p>
    </div>

    <div class="summary">
        <table>
            <tr>
                <th>Total Saldo Utama</th>
                <td class="text-right">Rp {{ number_format($totalSaldoUtama, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <th>Total Saldo Belanja</th>
                <td class="text-right">Rp {{ number_format($totalSaldoBelanja, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <th>Total Saldo Tabungan</th>
                <td class="text-right">Rp {{ number_format($totalSaldoTabungan, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <th>Total Keseluruhan</th>
                <td class="text-right">Rp {{ number_format($totalSaldoUtama + $totalSaldoBelanja + $totalSaldoTabungan, 0, ',', '.') }}</td>
            </tr>
        </table>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>NIS</th>
                <th>Nama Santri</th>
                <th>Kelas</th>
                <th>Saldo Utama</th>
                <th>Saldo Belanja</th>
                <th>Saldo Tabungan</th>
                <th>Total Saldo</th>
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
                <td class="text-right">Rp {{ number_format($s->saldo_utama + $s->saldo_belanja + $s->saldo_tabungan, 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="text-center">Tidak ada data saldo</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Dicetak pada: {{ $tanggal }}</p>
    </div>
</body>
</html> 