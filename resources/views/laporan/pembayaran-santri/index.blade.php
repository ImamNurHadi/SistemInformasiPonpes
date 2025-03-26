@extends('layouts.app')

@section('title', 'Laporan Pembayaran Santri')

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
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Laporan Pembayaran Santri</h3>
                    @if($isSearching && count($pembayaran) > 0)
                    <a href="{{ route('laporan-pembayaran-santri.print', request()->all()) }}" class="btn btn-primary" target="_blank">
                        <i class="bi bi-printer me-1"></i>Cetak PDF
                    </a>
                    @endif
                </div>
                <div class="card-body">
                    <form action="{{ route('laporan-pembayaran-santri.index') }}" method="GET" id="searchForm">
                        <input type="hidden" name="search" value="1">
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="nis" class="form-label">NIS</label>
                                    <input type="text" class="form-control" id="nis" name="nis" value="{{ request('nis') }}" placeholder="Cari NIS...">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="nama" class="form-label">Nama Santri</label>
                                    <input type="text" class="form-control" id="nama" name="nama" value="{{ request('nama') }}" placeholder="Cari nama...">
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
                                    <label for="jenis_pembayaran" class="form-label">Jenis Pembayaran</label>
                                    <select class="form-select" id="jenis_pembayaran" name="jenis_pembayaran">
                                        <option value="">Semua Jenis</option>
                                        <option value="pondok" {{ request('jenis_pembayaran') == 'pondok' ? 'selected' : '' }}>Pondok</option>
                                        <option value="kamar" {{ request('jenis_pembayaran') == 'kamar' ? 'selected' : '' }}>Kamar</option>
                                        <option value="ruang_kelas" {{ request('jenis_pembayaran') == 'ruang_kelas' ? 'selected' : '' }}>Ruang Kelas</option>
                                        <option value="tingkatan" {{ request('jenis_pembayaran') == 'tingkatan' ? 'selected' : '' }}>Tingkatan</option>
                                        <option value="komplek" {{ request('jenis_pembayaran') == 'komplek' ? 'selected' : '' }}>Komplek</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
                                    <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai" value="{{ request('tanggal_mulai') }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="tanggal_akhir" class="form-label">Tanggal Akhir</label>
                                    <input type="date" class="form-control" id="tanggal_akhir" name="tanggal_akhir" value="{{ request('tanggal_akhir') }}">
                                </div>
                            </div>
                            <div class="col-md-6 d-flex align-items-end">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-search-green me-2">
                                        <i class="bi bi-search me-1"></i>Cari
                                    </button>
                                    <a href="{{ route('laporan-pembayaran-santri.index') }}" class="btn btn-secondary">
                                        <i class="bi bi-arrow-clockwise me-1"></i>Reset
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>

                    @if($isSearching)
                        <div class="table-responsive mt-4">
                            <table class="table table-bordered table-striped" id="dataTable">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>NIS</th>
                                        <th>Nama Santri</th>
                                        <th>Kelas</th>
                                        <th>Tanggal</th>
                                        <th>Jenis Pembayaran</th>
                                        <th>Keterangan</th>
                                        <th>Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($pembayaran as $index => $p)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $p->santri->nis }}</td>
                                        <td>{{ $p->santri->nama }}</td>
                                        <td>{{ optional($p->santri->tingkatan)->nama }}</td>
                                        <td>{{ $p->created_at->format('d/m/Y H:i') }}</td>
                                        <td>{{ ucfirst(str_replace('_', ' ', $p->jenis_pembayaran)) }}</td>
                                        <td>{{ $p->keterangan ?? '-' }}</td>
                                        <td>Rp {{ number_format($p->jumlah, 0, ',', '.') }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="8" class="text-center">Tidak ada data pembayaran</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                                @if(count($pembayaran) > 0)
                                <tfoot>
                                    <tr>
                                        <th colspan="7" class="text-end">Total:</th>
                                        <th>Rp {{ number_format($pembayaran->sum('jumlah'), 0, ',', '.') }}</th>
                                    </tr>
                                </tfoot>
                                @endif
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info mt-4">
                            Silakan gunakan filter di atas untuk menampilkan laporan pembayaran santri.
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

        // Initialize select2 for dropdowns
        $('#tingkatan_id, #jenis_pembayaran').select2({
            theme: 'bootstrap-5',
            placeholder: 'Pilih...',
            allowClear: true
        });
    });
</script>
@endpush
@endsection 