@extends('layouts.app')

@section('title', 'Tarik Tunai')

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
<style>
    .card {
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    .card-header {
        background-color: #fff;
        border-bottom: 1px solid #e3e6f0;
        padding: 15px 20px;
    }
    .card-body {
        padding: 20px;
    }
    .btn-success {
        background-color: #198754;
        border-color: #198754;
    }
    .btn-success:hover {
        background-color: #157347;
        border-color: #146c43;
    }
    .santri-info {
        background-color: #f8f9fa;
        border-radius: 5px;
        padding: 15px;
        margin-bottom: 20px;
    }
    .table-borderless td {
        padding: 5px 10px;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h2 class="m-0 font-weight-bold text-success">Tarik Tunai</h2>
        </div>
        <div class="card-body">
            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Single Search Form -->
            <div class="row mb-4">
                <div class="col-md-12">
                    <form action="{{ route('tarik-tunai.index') }}" method="GET" id="searchForm">
                        <div class="row align-items-end">
                            <div class="col-md-8">
                                <div class="form-group mb-0">
                                    <label for="search" class="form-label">Cari Santri</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="search" name="search" 
                                            value="{{ request('search') }}" placeholder="Masukkan NIS atau nama santri">
                                        <select class="form-control" id="tingkatan_id" name="tingkatan_id" style="max-width: 200px;">
                                            <option value="">Semua Kelas</option>
                                            @foreach($tingkatan as $k)
                                                <option value="{{ $k->id }}" {{ request('tingkatan_id') == $k->id ? 'selected' : '' }}>
                                                    {{ $k->nama }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <button type="submit" class="btn btn-success">
                                            <i class="bi bi-search me-1"></i>Cari
                                        </button>
                                    </div>
                                    <small class="form-text text-muted">
                                        Anda dapat mencari berdasarkan NIS/nama, memilih kelas, atau keduanya
                                    </small>
                                </div>
                            </div>
                            <div class="col-md-4 text-end">
                                <a href="{{ route('tarik-tunai.index') }}" class="btn btn-secondary">
                                    <i class="bi bi-arrow-clockwise me-1"></i>Reset
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Display list of santri if search is performed -->
            @if($santri !== null && $santri->count() > 0 && !$selectedSantri)
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>NIS</th>
                                <th>Nama</th>
                                <th>Kelas</th>
                                <th>Saldo Utama</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($santri as $s)
                            <tr>
                                <td>{{ $s->nis }}</td>
                                <td>{{ $s->nama }}</td>
                                <td>{{ optional($s->tingkatan)->nama }}</td>
                                <td>Rp {{ number_format($s->saldo_utama, 0, ',', '.') }}</td>
                                <td>
                                    <a href="{{ route('tarik-tunai.index', ['santri_id' => $s->id]) }}" class="btn btn-success btn-sm">
                                        <i class="bi bi-cash-stack me-1"></i>Tarik Tunai
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @elseif($santri !== null && $santri->isEmpty())
                <div class="alert alert-warning">
                    Tidak ada santri yang ditemukan dengan kriteria pencarian tersebut.
                </div>
            @elseif(!$selectedSantri)
                <div class="alert alert-info">
                    Silakan cari santri dengan memasukkan NIS/nama santri dan/atau memilih kelas tertentu, kemudian klik tombol Cari.
                </div>
            @endif

            <!-- Selected Santri Form -->
            @if($selectedSantri)
                <div class="row">
                    <div class="col-md-12">
                        <div class="santri-info">
                            <h4 class="mb-3">Data Santri</h4>
                            <div class="row">
                                <div class="col-md-6">
                                    <table class="table table-borderless">
                                        <tr>
                                            <td width="140">NIS</td>
                                            <td width="20">:</td>
                                            <td>{{ $selectedSantri->nis }}</td>
                                        </tr>
                                        <tr>
                                            <td>Nama</td>
                                            <td>:</td>
                                            <td>{{ $selectedSantri->nama }}</td>
                                        </tr>
                                        <tr>
                                            <td>Kelas</td>
                                            <td>:</td>
                                            <td>{{ optional($selectedSantri->tingkatan)->nama }}</td>
                                        </tr>
                                        <tr>
                                            <td>Saldo Saat Ini</td>
                                            <td>:</td>
                                            <td><strong>Rp {{ number_format($selectedSantri->saldo_utama, 0, ',', '.') }}</strong></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <form action="{{ route('tarik-tunai.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="santri_id" value="{{ $selectedSantri->id }}">
                            
                            <div class="mb-3">
                                <label for="jumlah" class="form-label">Jumlah Penarikan</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" class="form-control @error('jumlah') is-invalid @enderror" 
                                        id="jumlah" name="jumlah" value="{{ old('jumlah') }}" 
                                        min="1000" step="500" required>
                                </div>
                                <small class="form-text text-muted">Minimal Rp 1.000 dan harus kelipatan 500</small>
                                @error('jumlah')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('tarik-tunai.index') }}" class="btn btn-secondary">
                                    <i class="bi bi-arrow-left"></i> Kembali
                                </a>
                                <button type="submit" class="btn btn-success">
                                    <i class="bi bi-check-circle"></i> Proses Penarikan
                                </button>
                            </div>
                        </form>
                    </div>
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
        // Initialize DataTable
        $('#dataTable').DataTable({
            "language": {
                "search": "Filter:",
                "lengthMenu": "Tampilkan _MENU_ data",
                "zeroRecords": "Tidak ada data yang ditemukan",
                "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                "infoEmpty": "Tidak ada data",
                "infoFiltered": "(disaring dari _MAX_ total data)",
                "paginate": {
                    "first": "Pertama",
                    "last": "Terakhir",
                    "next": "Selanjutnya",
                    "previous": "Sebelumnya"
                }
            },
            "pageLength": 5,
            "lengthMenu": [5, 10, 25, 50]
        });

        // Initialize select2
        $('#tingkatan_id').select2({
            theme: 'bootstrap-5',
            placeholder: 'Pilih Kelas',
            allowClear: true
        });
    });
</script>
@endpush 