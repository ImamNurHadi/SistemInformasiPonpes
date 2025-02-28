@extends('layouts.app')

@section('title', 'Top Up Saldo')

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
        <div class="card-header py-3">
            <h2 class="m-0 font-weight-bold text-success">Top Up Saldo</h2>
        </div>
        <div class="card-body">
            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Form Pencarian Santri -->
            <div class="row mb-4">
                <div class="col-md-12">
                    <form action="{{ route('topup.index') }}" method="GET" id="searchForm">
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
                                    <select class="form-control" id="tingkatan_id" name="tingkatan_id">
                                        <option value="">Semua Kelas</option>
                                        @foreach($tingkatan as $k)
                                            <option value="{{ $k->id }}" {{ request('tingkatan_id') == $k->id ? 'selected' : '' }}>
                                                {{ $k->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group" style="margin-top: 2rem;">
                                    <button type="submit" class="btn btn-search-green me-2">
                                        <i class="bi bi-search me-1"></i>Cari
                                    </button>
                                    <a href="{{ route('topup.index') }}" class="btn btn-secondary">
                                        <i class="bi bi-arrow-clockwise me-1"></i>Reset
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            @if($santri !== null)
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
                        @forelse($santri as $s)
                        <tr>
                            <td>{{ $s->nis }}</td>
                            <td>{{ $s->nama }}</td>
                            <td>{{ optional($s->tingkatan)->nama }}</td>
                            <td>Rp {{ number_format($s->saldo_utama, 0, ',', '.') }}</td>
                            <td>
                                <a href="{{ route('topup.form', $s->id) }}" class="btn btn-success btn-sm">
                                    <i class="bi bi-cash-coin me-1"></i>Top Up
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">Tidak ada data santri</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @else
            <div class="alert alert-info">
                Silakan cari santri menggunakan form di atas
            </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Pastikan jQuery sudah dimuat sebelum kode ini dijalankan
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize select2
        if ($.fn.select2) {
            $('#tingkatan_id').select2({
                theme: 'bootstrap-5',
                placeholder: 'Pilih Kelas',
                allowClear: true
            });
        }
    });

    // Fungsi untuk memilih santri
    function pilihSantri(id, nama) {
        console.log('pilihSantri dipanggil:', { id, nama });
        
        // Isi nilai input
        document.getElementById('santri_id').value = id;
        document.getElementById('santri_nama').value = nama;
        
        // Tampilkan form
        var formTopUp = document.getElementById('formTopUp');
        formTopUp.style.display = 'block';
        
        // Scroll ke form
        formTopUp.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }

    // Fungsi untuk membatalkan pilihan
    function batalPilih() {
        // Sembunyikan form
        document.getElementById('formTopUp').style.display = 'none';
        
        // Reset nilai input
        document.getElementById('santri_id').value = '';
        document.getElementById('santri_nama').value = '';
        document.getElementById('jumlah').value = '';
    }
</script>
@endpush
@endsection 