<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Histori Saldo</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header img {
            max-width: 100px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
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
        .text-center {
            text-align: center;
        }
        .footer {
            margin-top: 20px;
            font-size: 10px;
            text-align: right;
        }
        .filter-info {
            margin-bottom: 10px;
            font-size: 11px;
        }
    </style>
</head>
<body>
    <div class="header">
        <img src="{{ public_path('img/logo_qinna.png') }}" alt="Logo">
        <h2>Laporan Histori Saldo</h2>
        <p>Pondok Pesantren</p>
    </div>

    <div class="filter-info">
        <p>
            <strong>Filter:</strong><br>
            @if(request('nis'))
            NIS: {{ request('nis') }}<br>
            @endif
            @if(request('nama'))
            Nama: {{ request('nama') }}<br>
            @endif
            @if(request('tingkatan_id'))
            Kelas: {{ $tingkatan->where('id', request('tingkatan_id'))->first()->nama ?? '' }}<br>
            @endif
            @if(request('tipe'))
            Tipe Transaksi: {{ request('tipe') == 'masuk' ? 'Masuk' : 'Keluar' }}<br>
            @endif
            @if(request('tanggal_mulai'))
            Periode: {{ \Carbon\Carbon::parse(request('tanggal_mulai'))->format('d/m/Y') }}
            @if(request('tanggal_akhir'))
            - {{ \Carbon\Carbon::parse(request('tanggal_akhir'))->format('d/m/Y') }}
            @endif
            @endif
        </p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>NIS</th>
                <th>Nama Santri</th>
                <th>Kelas</th>
                <th>Tipe</th>
                <th>Jumlah</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($historiSaldo as $item)
            <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td>{{ $item->created_at->format('d/m/Y H:i') }}</td>
                <td>{{ $item->santri->nis }}</td>
                <td>{{ $item->santri->nama }}</td>
                <td>{{ optional($item->santri->tingkatan)->nama }}</td>
                <td>{{ ucfirst($item->tipe) }}</td>
                <td class="text-right">Rp {{ number_format($item->jumlah, 0, ',', '.') }}</td>
                <td>{{ $item->keterangan }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="text-center">Tidak ada data histori saldo</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Dicetak pada: {{ now()->format('d/m/Y H:i:s') }}</p>
    </div>
</body>
</html> 