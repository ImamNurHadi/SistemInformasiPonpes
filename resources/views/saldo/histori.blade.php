@extends('layouts.app')

@section('title', 'Histori Saldo')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Histori Saldo</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    @if(auth()->user()->isAdmin())
                                    <th>NIS</th>
                                    <th>Nama Santri</th>
                                    @endif
                                    <th>Tanggal</th>
                                    <th>Jumlah</th>
                                    <th>Keterangan</th>
                                    <th>Tipe</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($historiSaldo as $index => $histori)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    @if(auth()->user()->isAdmin())
                                    <td>{{ $histori->santri->nis }}</td>
                                    <td>{{ $histori->santri->nama }}</td>
                                    @endif
                                    <td>{{ $histori->created_at->format('d/m/Y H:i') }}</td>
                                    <td>Rp {{ number_format($histori->jumlah, 0, ',', '.') }}</td>
                                    <td>{{ $histori->keterangan ?? '-' }}</td>
                                    <td>
                                        <span class="badge bg-{{ $histori->tipe == 'masuk' ? 'success' : 'danger' }}">
                                            {{ ucfirst($histori->tipe) }}
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="{{ auth()->user()->isAdmin() ? '7' : '4' }}" class="text-center">
                                        Tidak ada data histori saldo
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 