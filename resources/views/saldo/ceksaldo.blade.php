@extends('layouts.app')

@section('title', 'Cek Saldo')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Daftar Saldo Santri</h3>
                </div>
                <div class="card-body">
                    @if(!auth()->user()->isSantri())
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <form action="{{ route('cek-saldo.index') }}" method="GET" id="filterForm">
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
                                            <button type="submit" class="btn btn-success me-2">
                                                <i class="bi bi-search me-1"></i>Cari
                                            </button>
                                            <a href="{{ route('cek-saldo.index') }}" class="btn btn-secondary">
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
                                @foreach($santri as $index => $s)
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
                                @endforeach
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