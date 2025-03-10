@extends('layouts.app')

@section('title', 'Laporan Tarik Tunai')

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
            <h2 class="m-0 font-weight-bold text-success">Laporan Tarik Tunai</h2>
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
                                    <label for="jenis_saldo" class="form-label">Jenis Saldo</label>
                                    <select class="form-select" id="jenis_saldo" name="jenis_saldo">
                                        <option value="">Semua Jenis</option>
                                        <option value="utama" {{ request('jenis_saldo') == 'utama' ? 'selected' : '' }}>Utama</option>
                                        <option value="belanja" {{ request('jenis_saldo') == 'belanja' ? 'selected' : '' }}>Belanja</option>
                                        <option value="tabungan" {{ request('jenis_saldo') == 'tabungan' ? 'selected' : '' }}>Tabungan</option>
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
                            <th>Jenis Saldo</th>
                            <th>Jumlah</th>
                            <th>Keterangan</th>
                            <th>Operator</th>
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
            const jenisSaldo = $('#jenis_saldo').val();
            
            let url = '{{ route("laporan-tarik-tunai.index") }}?print=true';
            
            if (tanggalMulai) url += `&tanggal_mulai=${tanggalMulai}`;
            if (tanggalSelesai) url += `&tanggal_selesai=${tanggalSelesai}`;
            if (jenisSaldo) url += `&jenis_saldo=${jenisSaldo}`;
            
            window.open(url, '_blank');
        });
    });
</script>
@endpush 