@extends('layouts.app')

@section('title', 'Laporan Transaksi Santri')

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
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
            <h2 class="m-0 font-weight-bold text-success">Laporan Transaksi Santri</h2>
            <button type="button" class="btn btn-primary" id="printBtn">
                <i class="bi bi-printer"></i> Print PDF
            </button>
        </div>
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-12">
                    <form action="" method="GET" id="filterForm">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
                                    <input type="text" class="form-control" id="tanggal_mulai" name="tanggal_mulai" 
                                        value="{{ request('tanggal_mulai') }}" placeholder="Pilih tanggal mulai...">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="tanggal_selesai" class="form-label">Tanggal Selesai</label>
                                    <input type="text" class="form-control" id="tanggal_selesai" name="tanggal_selesai" 
                                        value="{{ request('tanggal_selesai') }}" placeholder="Pilih tanggal selesai...">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="jenis_transaksi" class="form-label">Jenis Transaksi</label>
                                    <select class="form-select" id="jenis_transaksi" name="jenis_transaksi">
                                        <option value="">Semua Jenis</option>
                                        <option value="kantin" {{ request('jenis_transaksi') == 'kantin' ? 'selected' : '' }}>Kantin</option>
                                        <option value="koperasi" {{ request('jenis_transaksi') == 'koperasi' ? 'selected' : '' }}>Koperasi</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3 d-flex align-items-end">
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

            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="dataTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>NIS</th>
                            <th>Nama Santri</th>
                            <th>Jenis Transaksi</th>
                            <th>Nama Barang</th>
                            <th>Harga Satuan</th>
                            <th>Kuantitas</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Data will be loaded here -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    $(document).ready(function() {
        // Initialize DataTable
        $('#dataTable').DataTable();

        // Initialize date pickers
        flatpickr("#tanggal_mulai", {
            dateFormat: "Y-m-d"
        });
        
        flatpickr("#tanggal_selesai", {
            dateFormat: "Y-m-d"
        });

        // Print button functionality
        $('#printBtn').click(function() {
            const tanggalMulai = $('#tanggal_mulai').val();
            const tanggalSelesai = $('#tanggal_selesai').val();
            const jenisTransaksi = $('#jenis_transaksi').val();
            
            let url = '{{ route("laporan-transaksi.index") }}?print=true';
            
            if (tanggalMulai) url += `&tanggal_mulai=${tanggalMulai}`;
            if (tanggalSelesai) url += `&tanggal_selesai=${tanggalSelesai}`;
            if (jenisTransaksi) url += `&jenis_transaksi=${jenisTransaksi}`;
            
            window.open(url, '_blank');
        });
    });
</script>
@endpush 