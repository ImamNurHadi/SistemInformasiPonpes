<!DOCTYPE html>
<html>
<head>
    <title>Laporan Pembelanjaan Santri</title>
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
        <h1>LAPORAN PEMBELANJAAN SANTRI</h1>
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
                <th>Jenis Transaksi</th>
                <th>Harga Satuan</th>
                <th>Kuantitas</th>
                <th>Sub Total</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transaksi as $index => $t)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $t->santri->nis }}</td>
                <td>{{ $t->santri->nama }}</td>
                <td>{{ optional($t->santri->tingkatan)->nama }}</td>
                <td>{{ $t->created_at->format('d/m/Y H:i') }}</td>
                <td>{{ ucfirst($t->jenis) }}</td>
                <td class="text-right">Rp {{ number_format($t->harga_satuan, 0, ',', '.') }}</td>
                <td class="text-right">{{ $t->kuantitas }}</td>
                <td class="text-right">Rp {{ number_format($t->total, 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="9" class="text-center">Tidak ada data transaksi</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Dicetak pada: {{ $tanggal }}</p>
    </div>
</body>
</html> 