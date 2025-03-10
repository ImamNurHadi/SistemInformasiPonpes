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
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h2 class="m-0 font-weight-bold text-success">Laporan Akun dan Saldo</h2>
            <button type="button" class="btn btn-primary" id="printBtn">
                <i class="bi bi-printer"></i> Print PDF
            </button>
        </div>
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-12">
                    <form action="" method="GET" id="filterForm">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="tingkatan_id" class="form-label">Tingkatan</label>
                                    <select class="form-select" id="tingkatan_id" name="tingkatan_id">
                                        <option value="">Semua Tingkatan</option>
                                        <!-- Tingkatan options will be loaded here -->
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="komplek_id" class="form-label">Komplek</label>
                                    <select class="form-select" id="komplek_id" name="komplek_id">
                                        <option value="">Semua Komplek</option>
                                        <!-- Komplek options will be loaded here -->
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 d-flex align-items-end">
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

            <!-- Summary Cards -->
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="card card-summary">
                        <div class="card-body position-relative">
                            <div class="summary-title">Total Saldo Utama</div>
                            <div class="summary-value">Rp 0</div>
                            <i class="bi bi-wallet2 summary-icon"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-summary">
                        <div class="card-body position-relative">
                            <div class="summary-title">Total Saldo Belanja</div>
                            <div class="summary-value">Rp 0</div>
                            <i class="bi bi-cart summary-icon"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-summary">
                        <div class="card-body position-relative">
                            <div class="summary-title">Total Saldo Tabungan</div>
                            <div class="summary-value">Rp 0</div>
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
                            <th>Tingkatan</th>
                            <th>Komplek</th>
                            <th>Saldo Utama</th>
                            <th>Saldo Belanja</th>
                            <th>Saldo Tabungan</th>
                            <th>Total Saldo</th>
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
<script>
    $(document).ready(function() {
        // Initialize DataTable
        $('#dataTable').DataTable();

        // Print button functionality
        $('#printBtn').click(function() {
            const tingkatanId = $('#tingkatan_id').val();
            const komplekId = $('#komplek_id').val();
            
            let url = '{{ route("laporan-akun-saldo.index") }}?print=true';
            
            if (tingkatanId) url += `&tingkatan_id=${tingkatanId}`;
            if (komplekId) url += `&komplek_id=${komplekId}`;
            
            window.open(url, '_blank');
        });
    });
</script>
@endpush 