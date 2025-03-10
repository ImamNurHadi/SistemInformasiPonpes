@extends('layouts.app')

@section('title', 'Laporan Pembayaran')

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
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h2 class="m-0 font-weight-bold text-success">Laporan Pembayaran</h2>
            @if($isSearching)
            <form action="{{ route('laporan-pembayaran.print') }}" method="GET" class="d-inline">
                <input type="hidden" name="nis" value="{{ request('nis') }}">
                <input type="hidden" name="nama" value="{{ request('nama') }}">
                <input type="hidden" name="tingkatan_id" value="{{ request('tingkatan_id') }}">
                <input type="hidden" name="tanggal_mulai" value="{{ request('tanggal_mulai') }}">
                <input type="hidden" name="tanggal_selesai" value="{{ request('tanggal_selesai') }}">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-printer"></i> Print PDF
                </button>
            </form>
            @endif
        </div>
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-12">
                    <form action="{{ route('laporan-pembayaran.index') }}" method="GET" id="filterForm">
                        <input type="hidden" name="search" value="1">
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="nis" class="form-label">NIS</label>
                                    <input type="text" class="form-control" id="nis" name="nis" 
                                        value="{{ request('nis') }}" placeholder="Cari NIS...">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="nama" class="form-label">Nama Santri</label>
                                    <input type="text" class="form-control" id="nama" name="nama" 
                                        value="{{ request('nama') }}" placeholder="Cari nama...">
                                </div>
                            </div>
                            <div class="col-md-2">
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
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
                                    <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai" 
                                        value="{{ request('tanggal_mulai') }}">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="tanggal_selesai" class="form-label">Tanggal Selesai</label>
                                    <input type="date" class="form-control" id="tanggal_selesai" name="tanggal_selesai" 
                                        value="{{ request('tanggal_selesai') }}">
                                </div>
                            </div>
                            <div class="col-md-2 d-flex align-items-end">
                                <div class="form-group w-100">
                                    <button type="submit" class="btn btn-search-green w-100">
                                        <i class="bi bi-search"></i> Cari
                                    </button>
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
                            <td>Rp {{ number_format($t->harga_satuan, 0, ',', '.') }}</td>
                            <td>{{ $t->kuantitas }}</td>
                            <td>Rp {{ number_format($t->total, 0, ',', '.') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center">Tidak ada data transaksi</td>
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
<script>
    $(document).ready(function() {
        @if($isSearching)
        // Initialize DataTable
        $('#dataTable').DataTable({
            order: [[4, 'desc']], // Sort by tanggal column descending
            language: {
                url: '//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json'
            }
        });
        @endif
    });
</script>
@endpush 