@extends('layouts.app')

@section('title', 'Tambah Pengajar')

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
<style>
    .form-section {
        background: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
        margin-bottom: 20px;
    }
    .section-title {
        color: #4e73df;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 2px solid #4e73df;
    }
    .input-group-text {
        cursor: pointer;
    }
    .datepicker {
        z-index: 1600 !important;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Tambah Pengajar</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('pengajar.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <!-- Data Pribadi -->
                            <div class="col-md-6">
                                <h4>Data Pribadi</h4>
                                <div class="mb-3">
                                    <label for="nama" class="form-label">Nama Lengkap</label>
                                    <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ old('nama') }}" required>
                                    @error('nama')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="nik" class="form-label">NIK</label>
                                    <input type="text" class="form-control @error('nik') is-invalid @enderror" id="nik" name="nik" value="{{ old('nik') }}" required>
                                    @error('nik')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                                    <input type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror" id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" required>
                                    @error('tanggal_lahir')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="telepon" class="form-label">Nomor Telepon</label>
                                    <input type="text" class="form-control @error('telepon') is-invalid @enderror" id="telepon" name="telepon" value="{{ old('telepon') }}" required>
                                    @error('telepon')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Alamat Domisili -->
                            <div class="col-md-6">
                                <h4>Alamat Domisili</h4>
                                <div class="mb-3">
                                    <label for="kelurahan_domisili" class="form-label">Kelurahan</label>
                                    <input type="text" class="form-control @error('kelurahan_domisili') is-invalid @enderror" id="kelurahan_domisili" name="kelurahan_domisili" value="{{ old('kelurahan_domisili') }}" required>
                                    @error('kelurahan_domisili')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="kecamatan_domisili" class="form-label">Kecamatan</label>
                                    <input type="text" class="form-control @error('kecamatan_domisili') is-invalid @enderror" id="kecamatan_domisili" name="kecamatan_domisili" value="{{ old('kecamatan_domisili') }}" required>
                                    @error('kecamatan_domisili')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="kota_domisili" class="form-label">Kota/Kabupaten</label>
                                    <input type="text" class="form-control @error('kota_domisili') is-invalid @enderror" id="kota_domisili" name="kota_domisili" value="{{ old('kota_domisili') }}" required>
                                    @error('kota_domisili')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Alamat KK -->
                            <div class="col-md-6">
                                <h4>Alamat Kartu Keluarga</h4>
                                <div class="mb-3">
                                    <label for="kelurahan_kk" class="form-label">Kelurahan</label>
                                    <input type="text" class="form-control @error('kelurahan_kk') is-invalid @enderror" id="kelurahan_kk" name="kelurahan_kk" value="{{ old('kelurahan_kk') }}" required>
                                    @error('kelurahan_kk')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="kecamatan_kk" class="form-label">Kecamatan</label>
                                    <input type="text" class="form-control @error('kecamatan_kk') is-invalid @enderror" id="kecamatan_kk" name="kecamatan_kk" value="{{ old('kecamatan_kk') }}" required>
                                    @error('kecamatan_kk')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="kota_kk" class="form-label">Kota/Kabupaten</label>
                                    <input type="text" class="form-control @error('kota_kk') is-invalid @enderror" id="kota_kk" name="kota_kk" value="{{ old('kota_kk') }}" required>
                                    @error('kota_kk')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Data Pendidikan -->
                            <div class="col-md-6">
                                <h4>Data Pendidikan</h4>
                                <div class="mb-3">
                                    <label for="pendidikan_terakhir" class="form-label">Pendidikan Terakhir</label>
                                    <select class="form-select @error('pendidikan_terakhir') is-invalid @enderror" id="pendidikan_terakhir" name="pendidikan_terakhir" required>
                                        <option value="">Pilih Pendidikan Terakhir</option>
                                        @foreach($pendidikan as $p)
                                            <option value="{{ $p }}" {{ old('pendidikan_terakhir') == $p ? 'selected' : '' }}>{{ $p }}</option>
                                        @endforeach
                                    </select>
                                    @error('pendidikan_terakhir')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3" id="asal_kampus_div">
                                    <label for="asal_kampus" class="form-label">Asal Kampus</label>
                                    <input type="text" class="form-control @error('asal_kampus') is-invalid @enderror" id="asal_kampus" name="asal_kampus" value="{{ old('asal_kampus') }}">
                                    @error('asal_kampus')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                                <a href="{{ route('pengajar.index') }}" class="btn btn-secondary">Kembali</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const pendidikanSelect = document.getElementById('pendidikan_terakhir');
        const asalKampusDiv = document.getElementById('asal_kampus_div');
        const asalKampusInput = document.getElementById('asal_kampus');

        function toggleAsalKampus() {
            if (pendidikanSelect.value === 'SMA/Sederajat') {
                asalKampusDiv.style.display = 'none';
                asalKampusInput.removeAttribute('required');
            } else {
                asalKampusDiv.style.display = 'block';
                asalKampusInput.setAttribute('required', 'required');
            }
        }

        pendidikanSelect.addEventListener('change', toggleAsalKampus);
        toggleAsalKampus(); // Run on page load
    });
</script>
@endpush
@endsection 