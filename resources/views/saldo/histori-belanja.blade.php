@extends('layouts.app')

@section('title', 'Histori Belanja')

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
            <h2 class="m-0 font-weight-bold text-success">Histori Belanja</h2>
            <form action="{{ route('histori-belanja.print') }}" method="GET" class="d-inline">
                <input type="hidden" name="nis" value="{{ request('nis') }}">
                <input type="hidden" name="nama" value="{{ request('nama') }}">
                <input type="hidden" name="tingkatan_id" value="{{ request('tingkatan_id') }}">
                <input type="hidden" name="tanggal_mulai" value="{{ request('tanggal_mulai') }}">
                <input type="hidden" name="tanggal_selesai" value="{{ request('tanggal_selesai') }}">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-printer"></i> Print PDF
                </button>
            </form>
        </div>
        <div class="card-body">
            @if(auth()->user()->isAdmin() || auth()->user()->isOperator())
                <div class="row mb-4">
                    <div class="col-md-12">
                        <form action="{{ route('histori-belanja.index') }}" method="GET" id="filterForm">
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
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-search-green me-2">
                                            <i class="bi bi-search me-1"></i>Cari
                                        </button>
                                        <a href="{{ route('histori-belanja.index') }}" class="btn btn-secondary">
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
                <table class="table table-bordered table-striped" id="dataTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            @if(auth()->user()->isAdmin() || auth()->user()->isOperator())
                            <th>NIS</th>
                            <th>Nama Santri</th>
                            <th>Kelas</th>
                            @endif
                            <th>Tanggal</th>
                            <th>Jenis Transaksi</th>
                            <th>Harga Satuan</th>
                            <th>Kuantitas</th>
                            <th>Sub Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transaksi as $index => $t)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            @if(auth()->user()->isAdmin() || auth()->user()->isOperator())
                            <td>{{ $t->santri->nis }}</td>
                            <td>{{ $t->santri->nama }}</td>
                            <td>{{ optional($t->santri->tingkatan)->nama }}</td>
                            @endif
                            <td>{{ $t->created_at->format('d/m/Y H:i') }}</td>
                            <td>{{ ucfirst($t->jenis) }}</td>
                            <td>Rp {{ number_format($t->harga_satuan, 0, ',', '.') }}</td>
                            <td>{{ $t->kuantitas }}</td>
                            <td>Rp {{ number_format($t->total, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
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
    });
</script>
@endpush 