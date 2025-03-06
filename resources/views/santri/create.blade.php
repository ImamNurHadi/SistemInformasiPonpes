@extends('layouts.app')

@section('title', 'Tambah Santri')

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css">
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
    .select2-container--bootstrap-5 .select2-selection {
        min-height: 38px;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@endpush

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tambah Santri</h1>
    </div>

    <form action="{{ route('santri.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
        @endif

        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        
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
                    <label for="nis" class="form-label">Nomor Induk Santri (NIS)</label>
                    <input type="text" class="form-control @error('nis') is-invalid @enderror" 
                        id="nis" name="nis" 
                        value="{{ old('nis') }}" 
                        placeholder="Masukkan Nomor Induk Santri" required>
                    @error('nis')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                    <input type="text" class="form-control @error('tempat_lahir') is-invalid @enderror" 
                        id="tempat_lahir" name="tempat_lahir" value="{{ old('tempat_lahir') }}" 
                        placeholder="Masukkan Tempat Lahir" required>
                    @error('tempat_lahir')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                    <input type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror" 
                        id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" required>
                    @error('tanggal_lahir')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                    <select class="form-control @error('jenis_kelamin') is-invalid @enderror" 
                        id="jenis_kelamin" name="jenis_kelamin" required>
                        <option value="">Pilih Jenis Kelamin</option>
                        <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                    @error('jenis_kelamin')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-3 mb-3">
                    <label for="anak_ke" class="form-label">Anak Ke-</label>
                    <input type="number" class="form-control @error('anak_ke') is-invalid @enderror" 
                        id="anak_ke" name="anak_ke" value="{{ old('anak_ke') }}" 
                        placeholder="Masukkan Anak Ke-" required min="1">
                    @error('anak_ke')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-3 mb-3">
                    <label for="jumlah_saudara_kandung" class="form-label">Jumlah Saudara Kandung</label>
                    <input type="number" class="form-control @error('jumlah_saudara_kandung') is-invalid @enderror" 
                        id="jumlah_saudara_kandung" name="jumlah_saudara_kandung" value="{{ old('jumlah_saudara_kandung') }}" 
                        placeholder="Masukkan Jumlah Saudara" required min="0">
                    @error('jumlah_saudara_kandung')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
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

                <div class="col-md-4 mb-3">
                    <label for="kelurahan" class="form-label">Kelurahan</label>
                    <input type="text" class="form-control @error('kelurahan') is-invalid @enderror" 
                        id="kelurahan" name="kelurahan" value="{{ old('kelurahan') }}" 
                        placeholder="Masukkan Kelurahan" required>
                    @error('kelurahan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4 mb-3">
                    <label for="kecamatan" class="form-label">Kecamatan</label>
                    <input type="text" class="form-control @error('kecamatan') is-invalid @enderror" 
                        id="kecamatan" name="kecamatan" value="{{ old('kecamatan') }}" 
                        placeholder="Masukkan Kecamatan" required>
                    @error('kecamatan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4 mb-3">
                    <label for="kabupaten_kota" class="form-label">Kabupaten/Kota</label>
                    <input type="text" class="form-control @error('kabupaten_kota') is-invalid @enderror" 
                        id="kabupaten_kota" name="kabupaten_kota" value="{{ old('kabupaten_kota') }}" 
                        placeholder="Masukkan Kabupaten/Kota" required>
                    @error('kabupaten_kota')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4 mb-3">
                    <label for="tingkatan_id" class="form-label">Tingkatan</label>
                    <select class="form-control @error('tingkatan_id') is-invalid @enderror" 
                        id="tingkatan_id" name="tingkatan_id" required>
                        <option value="">Pilih Tingkatan</option>
                        @foreach($tingkatan as $t)
                            <option value="{{ $t->id }}" {{ old('tingkatan_id') == $t->id ? 'selected' : '' }}>
                                {{ $t->nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('tingkatan_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="no_hp" class="form-label">Nomor HP</label>
                    <input type="text" class="form-control @error('no_hp') is-invalid @enderror" 
                        id="no_hp" name="no_hp" value="{{ old('no_hp') }}" 
                        placeholder="Masukkan Nomor HP" required>
                    @error('no_hp')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="nama_ayah" class="form-label">Nama Ayah</label>
                    <input type="text" class="form-control @error('nama_ayah') is-invalid @enderror" 
                        id="nama_ayah" name="nama_ayah" value="{{ old('nama_ayah') }}" 
                        placeholder="Masukkan Nama Ayah">
                    @error('nama_ayah')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="nama_ibu" class="form-label">Nama Ibu</label>
                    <input type="text" class="form-control @error('nama_ibu') is-invalid @enderror" 
                        id="nama_ibu" name="nama_ibu" value="{{ old('nama_ibu') }}" 
                        placeholder="Masukkan Nama Ibu">
                    @error('nama_ibu')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Data Penempatan Santri -->
        <div class="form-section">
            <h5 class="section-title">Data Penempatan Santri</h5>
            
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="komplek_id" class="form-label">Komplek</label>
                    <select class="form-control @error('komplek_id') is-invalid @enderror" 
                        id="komplek_id" name="komplek_id" required>
                        <option value="">Pilih Komplek</option>
                        @foreach($komplek as $g)
                            <option value="{{ $g->id }}" {{ old('komplek_id') == $g->id ? 'selected' : '' }}>
                                {{ $g->nama_komplek }}
                            </option>
                        @endforeach
                    </select>
                    @error('komplek_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4 mb-3">
                    <label for="kamar_id" class="form-label">Kamar</label>
                    <select class="form-control @error('kamar_id') is-invalid @enderror" 
                        id="kamar_id" name="kamar_id" required>
                        <option value="">Pilih Kamar</option>
                        @foreach($kamar as $k)
                            <option value="{{ $k->id }}" {{ old('kamar_id') == $k->id ? 'selected' : '' }}>
                                {{ $k->nama_kamar }} ({{ $k->komplek->nama_komplek }})
                            </option>
                        @endforeach
                    </select>
                    @error('kamar_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Data Wali Santri -->
        <div class="form-section">
            <h5 class="section-title">Data Wali Santri</h5>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="nama_wali" class="form-label">Nama Wali</label>
                    <input type="text" class="form-control @error('nama_wali') is-invalid @enderror" 
                        id="nama_wali" name="nama_wali" value="{{ old('nama_wali') }}" 
                        placeholder="Masukkan Nama Wali" required>
                    @error('nama_wali')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="asal_kota" class="form-label">Asal Kota</label>
                    <input type="text" class="form-control @error('asal_kota') is-invalid @enderror" 
                        id="asal_kota" name="asal_kota" value="{{ old('asal_kota') }}" 
                        placeholder="Masukkan Asal Kota" required>
                    @error('asal_kota')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Data Ayah -->
                <div class="col-12">
                    <h6 class="mt-3 mb-3">Data Ayah</h6>
                </div>

                <div class="col-md-12 mb-3">
                    <label for="alamat_kk_ayah" class="form-label">Alamat KK Ayah</label>
                    <textarea class="form-control @error('alamat_kk_ayah') is-invalid @enderror" 
                        id="alamat_kk_ayah" name="alamat_kk_ayah" rows="2" 
                        placeholder="Masukkan Alamat KK Ayah">{{ old('alamat_kk_ayah') }}</textarea>
                    @error('alamat_kk_ayah')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-12 mb-3">
                    <label for="alamat_domisili_ayah" class="form-label">Alamat Domisili Ayah</label>
                    <textarea class="form-control @error('alamat_domisili_ayah') is-invalid @enderror" 
                        id="alamat_domisili_ayah" name="alamat_domisili_ayah" rows="2" 
                        placeholder="Masukkan Alamat Domisili Ayah">{{ old('alamat_domisili_ayah') }}</textarea>
                    @error('alamat_domisili_ayah')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="no_identitas_ayah" class="form-label">Nomor Identitas Ayah</label>
                    <input type="text" class="form-control @error('no_identitas_ayah') is-invalid @enderror" 
                        id="no_identitas_ayah" name="no_identitas_ayah" value="{{ old('no_identitas_ayah') }}" 
                        placeholder="Masukkan Nomor Identitas Ayah">
                    @error('no_identitas_ayah')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="no_hp_ayah" class="form-label">Nomor HP Ayah</label>
                    <input type="text" class="form-control @error('no_hp_ayah') is-invalid @enderror" 
                        id="no_hp_ayah" name="no_hp_ayah" value="{{ old('no_hp_ayah') }}" 
                        placeholder="Masukkan Nomor HP Ayah">
                    @error('no_hp_ayah')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="pendidikan_ayah" class="form-label">Pendidikan Ayah</label>
                    <input type="text" class="form-control @error('pendidikan_ayah') is-invalid @enderror" 
                        id="pendidikan_ayah" name="pendidikan_ayah" value="{{ old('pendidikan_ayah') }}" 
                        placeholder="Masukkan Pendidikan Ayah">
                    @error('pendidikan_ayah')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="pekerjaan_ayah" class="form-label">Pekerjaan Ayah</label>
                    <input type="text" class="form-control @error('pekerjaan_ayah') is-invalid @enderror" 
                        id="pekerjaan_ayah" name="pekerjaan_ayah" value="{{ old('pekerjaan_ayah') }}" 
                        placeholder="Masukkan Pekerjaan Ayah">
                    @error('pekerjaan_ayah')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Data Ibu -->
                <div class="col-12">
                    <h6 class="mt-3 mb-3">Data Ibu</h6>
                </div>

                <div class="col-md-12 mb-3">
                    <label for="alamat_kk_ibu" class="form-label">Alamat KK Ibu</label>
                    <textarea class="form-control @error('alamat_kk_ibu') is-invalid @enderror" 
                        id="alamat_kk_ibu" name="alamat_kk_ibu" rows="2" 
                        placeholder="Masukkan Alamat KK Ibu">{{ old('alamat_kk_ibu') }}</textarea>
                    @error('alamat_kk_ibu')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-12 mb-3">
                    <label for="alamat_domisili_ibu" class="form-label">Alamat Domisili Ibu</label>
                    <textarea class="form-control @error('alamat_domisili_ibu') is-invalid @enderror" 
                        id="alamat_domisili_ibu" name="alamat_domisili_ibu" rows="2" 
                        placeholder="Masukkan Alamat Domisili Ibu">{{ old('alamat_domisili_ibu') }}</textarea>
                    @error('alamat_domisili_ibu')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="no_identitas_ibu" class="form-label">Nomor Identitas Ibu</label>
                    <input type="text" class="form-control @error('no_identitas_ibu') is-invalid @enderror" 
                        id="no_identitas_ibu" name="no_identitas_ibu" value="{{ old('no_identitas_ibu') }}" 
                        placeholder="Masukkan Nomor Identitas Ibu">
                    @error('no_identitas_ibu')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="no_hp_ibu" class="form-label">Nomor HP Ibu</label>
                    <input type="text" class="form-control @error('no_hp_ibu') is-invalid @enderror" 
                        id="no_hp_ibu" name="no_hp_ibu" value="{{ old('no_hp_ibu') }}" 
                        placeholder="Masukkan Nomor HP Ibu">
                    @error('no_hp_ibu')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="pendidikan_ibu" class="form-label">Pendidikan Ibu</label>
                    <input type="text" class="form-control @error('pendidikan_ibu') is-invalid @enderror" 
                        id="pendidikan_ibu" name="pendidikan_ibu" value="{{ old('pendidikan_ibu') }}" 
                        placeholder="Masukkan Pendidikan Ibu">
                    @error('pendidikan_ibu')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="pekerjaan_ibu" class="form-label">Pekerjaan Ibu</label>
                    <input type="text" class="form-control @error('pekerjaan_ibu') is-invalid @enderror" 
                        id="pekerjaan_ibu" name="pekerjaan_ibu" value="{{ old('pekerjaan_ibu') }}" 
                        placeholder="Masukkan Pekerjaan Ibu">
                    @error('pekerjaan_ibu')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-12 d-flex justify-content-end">
                <button type="submit" class="btn btn-success me-3">Simpan</button>
                <a href="{{ route('santri.index') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Inisialisasi Select2 untuk dropdown
    $('#tingkatan_id').select2({
        theme: 'bootstrap-5'
    });
    $('#komplek_id').select2({
        theme: 'bootstrap-5'
    });
    $('#kamar_id').select2({
        theme: 'bootstrap-5'
    });
});
</script> 