@extends('layouts.app')

@section('title', 'Histori Saldo')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Histori Saldo</h3>
                    @if(auth()->user()->isOperator())
                    <a href="{{ route('topup.index') }}" class="btn btn-success">
                        <i class="bi bi-plus-circle me-1"></i>Top Up Baru
                    </a>
                    @endif
                </div>
                <div class="card-body">
                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="historiTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    @if(auth()->user()->isAdmin() || auth()->user()->isOperator())
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
                                    @if(auth()->user()->isAdmin() || auth()->user()->isOperator())
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
                                    <td colspan="{{ auth()->user()->isAdmin() || auth()->user()->isOperator() ? '7' : '5' }}" class="text-center">
                                        @if(!auth()->user()->isAdmin() && !auth()->user()->isOperator() && !auth()->user()->santri)
                                            Anda tidak memiliki akses ke data histori saldo
                                        @else
                                            Tidak ada data histori saldo
                                        @endif
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

@push('scripts')
<script>
    $(document).ready(function() {
        $('#historiTable').DataTable({
            order: [[3, 'desc']], // Sort by tanggal column descending
            language: {
                url: '//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json'
            }
        });
    });
</script>
@endpush
@endsection 