<!DOCTYPE html>
<html>
<head>
    <title>Laporan Tarik Tunai</title>
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
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN TARIK TUNAI</h1>
        <p>Tanggal Cetak: {{ $tanggal }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>NIS</th>
                <th>Nama Santri</th>
                <th>Kelas</th>
                <th>Tanggal</th>
                <th>Jumlah</th>
                <th>Jenis Saldo</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($historiSaldo as $index => $histori)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $histori->santri->nis }}</td>
                <td>{{ $histori->santri->nama }}</td>
                <td>{{ optional($histori->santri->tingkatan)->nama }}</td>
                <td>{{ $histori->created_at->format('d/m/Y H:i') }}</td>
                <td class="text-right">Rp {{ number_format($histori->jumlah, 0, ',', '.') }}</td>
                <td>{{ ucfirst($histori->jenis_saldo) }}</td>
                <td>{{ $histori->keterangan }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="text-center">Tidak ada data tarik tunai</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Dicetak pada: {{ $tanggal }}</p>
    </div>
</body>
</html> 