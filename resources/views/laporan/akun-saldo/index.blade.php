@extends('layouts.app')

@section('title', 'Laporan Akun dan Saldo')

@push('styles')
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
    .card-summary {
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        margin-bottom: 20px;
    }
    .card-summary .card-body {
        padding: 20px;
    }
    .summary-title {
        font-size: 16px;
        font-weight: 600;
        color: #555;
        margin-bottom: 10px;
    }
    .summary-value {
        font-size: 24px;
        font-weight: 700;
        color: #198754;
    }
    .summary-icon {
        font-size: 40px;
        color: #198754;
        opacity: 0.2;
        position: absolute;
        right: 20px;
        top: 20px;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Laporan Akun dan Saldo</h3>
                    @if($isSearching)
                    <form action="{{ route('laporan-akun-saldo.print') }}" method="GET" class="d-inline">
                        <input type="hidden" name="nis" value="{{ request('nis') }}">
                        <input type="hidden" name="nama" value="{{ request('nama') }}">
                        <input type="hidden" name="tingkatan_id" value="{{ request('tingkatan_id') }}">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-printer me-1"></i>Print PDF
                        </button>
                    </form>
                    @endif
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <form action="{{ route('laporan-akun-saldo.index') }}" method="GET" id="filterForm">
                                <input type="hidden" name="search" value="1">
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
                                    <div class="col-md-3 d-flex align-items-end">
                                        <div class="form-group w-100">
                                            <button type="submit" class="btn btn-success">
                                                <i class="bi bi-search me-1"></i>Cari
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    @if($isSearching)
                    <!-- Summary Cards -->
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <div class="card card-summary">
                                <div class="card-body position-relative">
                                    <div class="summary-title">Total Saldo Utama</div>
                                    <div class="summary-value">Rp {{ number_format($totalSaldoUtama, 0, ',', '.') }}</div>
                                    <i class="bi bi-wallet2 summary-icon"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card card-summary">
                                <div class="card-body position-relative">
                                    <div class="summary-title">Total Saldo Belanja</div>
                                    <div class="summary-value">Rp {{ number_format($totalSaldoBelanja, 0, ',', '.') }}</div>
                                    <i class="bi bi-cart summary-icon"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card card-summary">
                                <div class="card-body position-relative">
                                    <div class="summary-title">Total Saldo Tabungan</div>
                                    <div class="summary-value">Rp {{ number_format($totalSaldoTabungan, 0, ',', '.') }}</div>
                                    <i class="bi bi-piggy-bank summary-icon"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="dataTable">
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
                                    <td>Rp {{ number_format($s->saldo_utama, 0, ',', '.') }}</td>
                                    <td>Rp {{ number_format($s->saldo_belanja, 0, ',', '.') }}</td>
                                    <td>Rp {{ number_format($s->saldo_tabungan, 0, ',', '.') }}</td>
                                    <td>Rp {{ number_format($s->saldo_utama + $s->saldo_belanja + $s->saldo_tabungan, 0, ',', '.') }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center">Tidak ada data saldo</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="alert alert-info">
                        Silahkan masukkan kriteria pencarian dan klik tombol "Cari" untuk menampilkan data.
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        @if($isSearching)
        $('#dataTable').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json'
            }
        });
        @endif
    });
</script>
@endpush 