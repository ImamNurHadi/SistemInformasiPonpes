@extends('layouts.app')

@section('title', 'Tambah Santri')

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
    .date-input {
        position: relative;
        display: flex;
        align-items: center;
    }
    .date-input .form-control {
        padding-right: 40px;
    }
    .calendar-icon {
        position: absolute;
        right: 10px;
        padding: 10px;
        cursor: pointer;
        z-index: 10;
    }
    .calendar-icon i {
        color: #6c757d;
    }
    .input-group-text {
        cursor: pointer;
    }
    .datepicker {
        z-index: 1600 !important; /* Memastikan datepicker muncul di atas elemen lain */
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tambah Santri</h1>
    </div>

    <form action="{{ route('santri.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <!-- Data Pribadi -->
        <div class="form-section">
            <h5 class="section-title">Data Pribadi</h5>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="nama" class="form-label">Nama Lengkap</label>
                    <input type="text" class="form-control @error('nama') is-invalid @enderror" 
                        id="nama" name="nama" value="{{ old('nama') }}" 
                        placeholder="Masukkan Nama Lengkap" required>
                    @error('nama')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="nis" class="form-label">Nomor Induk Santri</label>
                    <input type="text" class="form-control @error('nis') is-invalid @enderror" 
                        id="nis" name="nis" value="{{ old('nis') }}" 
                        placeholder="Masukkan NISx" required>
                    @error('nis')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="no_kk" class="form-label">No. Kartu Keluarga</label>
                    <input type="text" class="form-control @error('no_kk') is-invalid @enderror" 
                        id="no_kk" name="no_kk" value="{{ old('no_kk') }}" 
                        placeholder="Masukkan Nomor Kartu Keluarga" required>
                    @error('no_kk')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                    <input type="text" class="form-control @error('tempat_lahir') is-invalid @enderror" 
                        id="tempat_lahir" name="tempat_lahir" value="{{ old('tempat_lahir') }}" 
                        placeholder="Masukkan Tempat Kelahiran" required>
                    @error('tempat_lahir')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                    <div class="input-group date">
                        <input type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror" 
                            id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" 
                            placeholder="dd-mm-yyyy" required>
                        @error('tanggal_lahir')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-12 mb-3">
                    <label for="alamat" class="form-label">Alamat Lengkap</label>
                    <textarea class="form-control @error('alamat') is-invalid @enderror" 
                        id="alamat" name="alamat" rows="3" 
                        placeholder="Masukkan Alamat Lengkap" required>{{ old('alamat') }}</textarea>
                    @error('alamat')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="kota_asal" class="form-label">Kota Asal</label>
                    <input type="text" class="form-control @error('kota_asal') is-invalid @enderror" 
                        id="kota_asal" name="kota_asal" value="{{ old('kota_asal') }}" 
                        placeholder="Masukkan Kota Asal" required>
                    @error('kota_asal')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-3 mb-3">
                    <label for="anak_ke" class="form-label">Anak Ke-</label>
                    <input type="number" class="form-control @error('anak_ke') is-invalid @enderror" 
                        id="anak_ke" name="anak_ke" value="{{ old('anak_ke') }}" 
                        placeholder="Masukkan Data Anak Ke-" required>
                    @error('anak_ke')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-3 mb-3">
                    <label for="jumlah_saudara" class="form-label">Jumlah Saudara</label>
                    <input type="number" class="form-control @error('jumlah_saudara') is-invalid @enderror" 
                        id="jumlah_saudara" name="jumlah_saudara" value="{{ old('jumlah_saudara') }}" 
                        placeholder="Masukkan Kota Asal" required>
                    @error('jumlah_saudara')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="foto" class="form-label">Upload Foto</label>
                    <input type="file" class="form-control @error('foto') is-invalid @enderror" 
                        id="foto" name="foto" accept="image/*" required>
                    @error('foto')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Data Sekolah Asal -->
        <div class="form-section">
            <h5 class="section-title">Data Sekolah Asal</h5>
            <div class="row">
                <div class="col-md-12 mb-3">
                    <label for="sekolah_asal" class="form-label">Sekolah Asal</label>
                    <input type="text" class="form-control @error('sekolah_asal') is-invalid @enderror" 
                        id="sekolah_asal" name="sekolah_asal" value="{{ old('sekolah_asal') }}" 
                        placeholder="Masukkan Nama Sekolah Asal" required>
                    @error('sekolah_asal')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-12 mb-3">
                    <label for="alamat_sekolah" class="form-label">Alamat Sekolah Asal</label>
                    <textarea class="form-control @error('alamat_sekolah') is-invalid @enderror" 
                        id="alamat_sekolah" name="alamat_sekolah" rows="3" 
                        placeholder="Masukkan Alamat Sekolah Asal" required>{{ old('alamat_sekolah') }}</textarea>
                    @error('alamat_sekolah')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="nisn" class="form-label">NISN Sekolah Asal</label>
                    <input type="text" class="form-control @error('nisn') is-invalid @enderror" 
                        id="nisn" name="nisn" value="{{ old('nisn') }}" 
                        placeholder="Masukkan NISN" required>
                    @error('nisn')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Data Penempatan Santri -->
        <div class="form-section">
            <h5 class="section-title">Data Penempatan Santri</h5>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="asrama" class="form-label">Nama Asrama</label>
                    <input type="text" class="form-control @error('asrama') is-invalid @enderror" 
                        id="asrama" name="asrama" value="{{ old('asrama') }}" 
                        placeholder="Masukkan Nama Asrama" required>
                    @error('asrama')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="kamar" class="form-label">Nomor Kamar</label>
                    <input type="text" class="form-control @error('kamar') is-invalid @enderror" 
                        id="kamar" name="kamar" value="{{ old('kamar') }}" 
                        placeholder="Masukkan Nomor Kamar" required>
                    @error('kamar')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="tingkatan_masuk" class="form-label">Tingkatan Masuk</label>
                    <input type="text" class="form-control @error('tingkatan_masuk') is-invalid @enderror" 
                        id="tingkatan_masuk" name="tingkatan_masuk" value="{{ old('tingkatan_masuk') }}" 
                        placeholder="Masukkan Tingkatan Masuk" required>
                    @error('tingkatan_masuk')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="d-grid gap-2 d-md-flex justify-content-md-end mb-4">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('santri.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/locales/bootstrap-datepicker.id.min.js"></script>
<script>
    $(function(){
        // Inisialisasi datepicker
        $('.input-group.date').datepicker({
            format: "dd-mm-yyyy",
            todayBtn: "linked",
            clearBtn: true,
            language: "id",
            autoclose: true,
            todayHighlight: true,
            endDate: new Date()
        });

        // Event handler untuk ikon kalender
        $('#calendar-addon').click(function(){
            $('#tanggal_lahir').datepicker('show');
        });
    });
</script>
@endpush 