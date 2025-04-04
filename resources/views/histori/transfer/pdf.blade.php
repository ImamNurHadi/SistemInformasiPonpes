<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Histori Transfer QR Code</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            font-size: 18px;
            font-weight: bold;
        }
        .periode {
            text-align: center;
            margin-bottom: 15px;
            font-style: italic;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
            text-align: left;
            padding: 8px;
            font-weight: bold;
        }
        td {
            padding: 8px;
            vertical-align: top;
        }
        .footer {
            margin-top: 30px;
            text-align: right;
            font-size: 12px;
        }
        .pagenum:before {
            content: counter(page);
        }
        .total {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN HISTORI TRANSFER QR CODE</h1>
        <p>{{ env('APP_NAME', 'Sistem Informasi Pondok Pesantren') }}</p>
    </div>
    
    @if(!empty($periodeTeks))
    <div class="periode">
        {{ $periodeTeks }}
    </div>
    @endif
    
    <table>
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 15%;">Tanggal</th>
                <th style="width: 18%;">Pengirim</th>
                <th style="width: 18%;">Penerima</th>
                <th style="width: 10%;">Dari Saldo</th>
                <th style="width: 10%;">Ke Saldo</th>
                <th style="width: 12%;">Jumlah</th>
                <th style="width: 12%;">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @if($historiTransfer->count() > 0)
                @php $total = 0; @endphp
                @foreach($historiTransfer as $index => $item)
                    @php $total += $item->jumlah; @endphp
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item->tanggal->format('d/m/Y H:i') }}</td>
                        <td>
                            {{ $item->pengirim->nama }}<br>
                            <small>NIS: {{ $item->pengirim->nis }}</small><br>
                            <small>Kelas: {{ $item->pengirim->tingkatan->nama ?? '-' }}</small>
                        </td>
                        <td>
                            {{ $item->penerima->nama }}<br>
                            <small>NIS: {{ $item->penerima->nis }}</small><br>
                            <small>Kelas: {{ $item->penerima->tingkatan->nama ?? '-' }}</small>
                        </td>
                        <td>{{ ucfirst($item->tipe_sumber) }}</td>
                        <td>{{ ucfirst($item->tipe_tujuan) }}</td>
                        <td>Rp {{ number_format($item->jumlah, 0, ',', '.') }}</td>
                        <td>{{ $item->keterangan }}</td>
                    </tr>
                @endforeach
                <tr class="total">
                    <td colspan="6" style="text-align: right;">Total:</td>
                    <td>Rp {{ number_format($total, 0, ',', '.') }}</td>
                    <td></td>
                </tr>
            @else
                <tr>
                    <td colspan="8" style="text-align: center;">Tidak ada data histori transfer</td>
                </tr>
            @endif
        </tbody>
    </table>
    
    <div class="footer">
        <p>Dicetak pada: {{ $tanggal }}</p>
    </div>
</body>
</html> 