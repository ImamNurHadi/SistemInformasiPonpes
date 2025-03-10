@extends('layouts.app')

@section('title', 'Laporan Tarik Tunai')

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
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h2 class="m-0 font-weight-bold text-success">Laporan Tarik Tunai</h2>
            @if($isSearching)
            <form action="{{ route('laporan-tarik-tunai.print') }}" method="GET" class="d-inline">
                <input type="hidden" name="nis" value="{{ request('nis') }}">
                <input type="hidden" name="nama" value="{{ request('nama') }}">
                <input type="hidden" name="tingkatan_id" value="{{ request('tingkatan_id') }}">
                <input type="hidden" name="jenis_saldo" value="{{ request('jenis_saldo') }}">
                <input type="hidden" name="tanggal_mulai" value="{{ request('tanggal_mulai') }}">
                <input type="hidden" name="tanggal_akhir" value="{{ request('tanggal_akhir') }}">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-printer"></i> Print PDF
                </button>
            </form>
            @endif
        </div>
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-12">
                    <form action="{{ route('laporan-tarik-tunai.index') }}" method="GET" id="filterForm">
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
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="jenis_saldo" class="form-label">Jenis Saldo</label>
                                    <select class="form-select" id="jenis_saldo" name="jenis_saldo">
                                        <option value="">Semua Jenis</option>
                                        <option value="utama" {{ request('jenis_saldo') == 'utama' ? 'selected' : '' }}>Utama</option>
                                        <option value="belanja" {{ request('jenis_saldo') == 'belanja' ? 'selected' : '' }}>Belanja</option>
                                        <option value="tabungan" {{ request('jenis_saldo') == 'tabungan' ? 'selected' : '' }}>Tabungan</option>
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
                                    <a href="{{ route('laporan-tarik-tunai.index') }}" class="btn btn-secondary">
                                        <i class="bi bi-arrow-clockwise me-1"></i>Reset
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            @if($isSearching)
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="dataTable">
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
                            <td>Rp {{ number_format($histori->jumlah, 0, ',', '.') }}</td>
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
            </div>
            @else
            <div class="alert alert-info">
                Silahkan masukkan kriteria pencarian dan klik tombol "Cari" untuk menampilkan data.
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        @if($isSearching)
        $('#dataTable').DataTable({
            order: [[4, 'desc']], // Sort by tanggal column descending
            language: {
                url: '//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json'
            }
        });
        @endif

        // Initialize select2 for tingkatan and jenis_saldo dropdowns
        $('#tingkatan_id, #jenis_saldo').select2({
            theme: 'bootstrap-5',
            width: '100%'
        });
    });
</script>
@endpush 