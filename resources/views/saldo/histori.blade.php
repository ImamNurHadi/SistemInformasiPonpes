@extends('layouts.app')

@section('title', 'Histori Saldo')

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
<style>
    .btn-search-green {
        background-color: #198754 !important;
        border-color: #198754 !important;
        color: white !important;
    }
    .btn-search-green:hover {
        background-color: #157347 !important;
        border-color: #146c43 !important;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Histori Saldo</h3>
                    <div>
                        <form action="{{ route('histori-saldo.print') }}" method="GET" class="d-inline me-2">
                            <input type="hidden" name="nis" value="{{ request('nis') }}">
                            <input type="hidden" name="nama" value="{{ request('nama') }}">
                            <input type="hidden" name="tingkatan_id" value="{{ request('tingkatan_id') }}">
                            <input type="hidden" name="tipe" value="{{ request('tipe') }}">
                            <input type="hidden" name="tanggal_mulai" value="{{ request('tanggal_mulai') }}">
                            <input type="hidden" name="tanggal_akhir" value="{{ request('tanggal_akhir') }}">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-printer me-1"></i>Print PDF
                            </button>
                        </form>
                        @if(auth()->user()->isOperator())
                        <a href="{{ route('topup.index') }}" class="btn btn-success d-inline">
                            <i class="bi bi-plus-circle me-1"></i>Top Up Baru
                        </a>
                        @endif
                    </div>
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

                    @if(auth()->user()->isAdmin() || auth()->user()->isOperator())
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <form action="{{ route('histori-saldo.index') }}" method="GET" id="filterForm">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="nis" class="form-label">NIS</label>
                                            <input type="text" class="form-control" id="nis" name="nis" 
                                                value="{{ request('nis') }}" placeholder="Cari NIS...">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="nama" class="form-label">Nama Santri</label>
                                            <input type="text" class="form-control" id="nama" name="nama" 
                                                value="{{ request('nama') }}" placeholder="Cari nama...">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="tingkatan_id" class="form-label">Kelas</label>
                                            <select class="form-select" id="tingkatan_id" name="tingkatan_id">
                                                <option value="">Semua Kelas</option>
                                                @foreach($tingkatan as $t)
                                                    <option value="{{ $t->id }}" {{ request('tingkatan_id') == $t->id ? 'selected' : '' }}>
                                                        {{ $t->nama }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="tipe" class="form-label">Tipe Transaksi</label>
                                            <select class="form-select" id="tipe" name="tipe">
                                                <option value="">Semua Tipe</option>
                                                <option value="masuk" {{ request('tipe') == 'masuk' ? 'selected' : '' }}>Masuk</option>
                                                <option value="keluar" {{ request('tipe') == 'keluar' ? 'selected' : '' }}>Keluar</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
                                            <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai" 
                                                value="{{ request('tanggal_mulai') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="tanggal_akhir" class="form-label">Tanggal Akhir</label>
                                            <input type="date" class="form-control" id="tanggal_akhir" name="tanggal_akhir" 
                                                value="{{ request('tanggal_akhir') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6 d-flex align-items-end">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-search-green me-2">
                                                <i class="bi bi-search me-1"></i>Cari
                                            </button>
                                            <a href="{{ route('histori-saldo.index') }}" class="btn btn-secondary">
                                                <i class="bi bi-arrow-clockwise me-1"></i>Reset
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
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
                                    <th>Kelas</th>
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
                                    <td>{{ optional($histori->santri->tingkatan)->nama }}</td>
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
                                    <td colspan="{{ auth()->user()->isAdmin() || auth()->user()->isOperator() ? '8' : '5' }}" class="text-center">
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

        // Initialize select2 for tingkatan and tipe dropdowns
        $('#tingkatan_id, #tipe').select2({
            theme: 'bootstrap-5',
            placeholder: 'Pilih...',
            allowClear: true
        });

        // Date range validation
        $('#tanggal_mulai, #tanggal_akhir').change(function() {
            var tanggalMulai = $('#tanggal_mulai').val();
            var tanggalAkhir = $('#tanggal_akhir').val();

            if (tanggalMulai && tanggalAkhir) {
                if (tanggalMulai > tanggalAkhir) {
                    alert('Tanggal akhir harus lebih besar dari tanggal mulai');
                    $('#tanggal_akhir').val('');
                }
            }
        });
    });
</script>
@endpush
@endsection 