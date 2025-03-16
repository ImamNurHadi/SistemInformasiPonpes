<!DOCTYPE html>
<html>
<head>
    <title>Laporan Pembayaran Santri</title>
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
        <h1>LAPORAN PEMBAYARAN SANTRI</h1>
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
                <th>Jenis Pembayaran</th>
                <th>Keterangan</th>
                <th>Jumlah</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pembayaran as $index => $p)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $p->santri->nis }}</td>
                <td>{{ $p->santri->nama }}</td>
                <td>{{ optional($p->santri->tingkatan)->nama }}</td>
                <td>{{ $p->created_at->format('d/m/Y H:i') }}</td>
                <td>{{ ucfirst(str_replace('_', ' ', $p->jenis_pembayaran)) }}</td>
                <td>{{ $p->keterangan ?? '-' }}</td>
                <td class="text-right">Rp {{ number_format($p->jumlah, 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="text-center">Tidak ada data pembayaran</td>
            </tr>
            @endforelse
        </tbody>
        @if(count($pembayaran) > 0)
        <tfoot>
            <tr>
                <th colspan="7" class="text-right">Total:</th>
                <th class="text-right">Rp {{ number_format($pembayaran->sum('jumlah'), 0, ',', '.') }}</th>
            </tr>
        </tfoot>
        @endif
    </table>

    <div class="footer">
        <p>Dicetak pada: {{ $tanggal }}</p>
    </div>
</body>
</html> 