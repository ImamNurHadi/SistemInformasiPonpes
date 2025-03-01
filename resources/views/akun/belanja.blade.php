@extends('layouts.app')

@section('title', 'Akun Belanja')

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
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Akun Belanja</h3>
                </div>
                <div class="card-body">
                    @if(auth()->user()->isAdmin() || auth()->user()->isOperator())
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <form action="{{ route('akun-belanja.index') }}" method="GET" id="filterForm">
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
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-search-green me-2">
                                                    <i class="bi bi-search me-1"></i>Cari
                                                </button>
                                                <a href="{{ route('akun-belanja.index') }}" class="btn btn-secondary">
                                                    <i class="bi bi-x-circle"></i> Reset
                                                </a>
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
                                        <th>NIS</th>
                                        <th>Nama Santri</th>
                                        <th>Kelas</th>
                                        <th>Saldo Belanja</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($santriList as $index => $santri)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $santri->nis }}</td>
                                        <td>{{ $santri->nama }}</td>
                                        <td>{{ optional($santri->tingkatan)->nama }}</td>
                                        <td>Rp {{ number_format($santri->saldo_belanja, 0, ',', '.') }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @elseif(auth()->user()->isSantri())
                        @if($saldo !== null)
                            <div class="alert alert-info">
                                <h4 class="alert-heading">Saldo Belanja Anda:</h4>
                                <h2 class="mb-0">Rp {{ number_format($saldo, 0, ',', '.') }}</h2>
                            </div>
                            <p class="text-muted">
                                Saldo belanja dapat digunakan untuk berbelanja di kantin pesantren.
                            </p>
                        @else
                            <div class="alert alert-warning">
                                Data saldo tidak ditemukan.
                            </div>
                        @endif
                    @else
                        <div class="alert alert-info">
                            Anda tidak memiliki akses ke fitur ini.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json'
            }
        });

        // Initialize select2 for tingkatan dropdown
        $('#tingkatan_id').select2({
            theme: 'bootstrap-5',
            placeholder: 'Pilih Kelas',
            allowClear: true
        });
    });
</script>
@endpush
@endsection 