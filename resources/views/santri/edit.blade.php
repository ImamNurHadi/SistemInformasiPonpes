@extends('layouts.app')

@section('title', 'Edit Santri')

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
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Santri</h1>
    </div>

    <form action="{{ route('santri.update', $santri->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <!-- Data Pribadi -->
        <div class="form-section">
            <h5 class="section-title">Data Pribadi</h5>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="nama" class="form-label">Nama Lengkap</label>
                    <input type="text" class="form-control @error('nama') is-invalid @enderror" 
                        id="nama" name="nama" value="{{ old('nama', $santri->nama) }}" 
                        placeholder="Masukkan Nama Lengkap" required>
                    @error('nama')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="nomor_induk_santri" class="form-label">Nomor Induk Santri (NIS)</label>
                    <input type="text" class="form-control @error('nomor_induk_santri') is-invalid @enderror" 
                        id="nomor_induk_santri" name="nomor_induk_santri" 
                        value="{{ old('nomor_induk_santri', $santri->nis) }}" 
                        placeholder="Masukkan Nomor Induk Santri" required>
                    @error('nomor_induk_santri')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                    <input type="text" class="form-control @error('tempat_lahir') is-invalid @enderror" 
                        id="tempat_lahir" name="tempat_lahir" value="{{ old('tempat_lahir', $santri->tempat_lahir) }}" 
                        placeholder="Masukkan Tempat Lahir" required>
                    @error('tempat_lahir')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                    <input type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror" 
                        id="tanggal_lahir" name="tanggal_lahir" 
                        value="{{ old('tanggal_lahir', $santri->tanggal_lahir->format('Y-m-d')) }}" required>
                    @error('tanggal_lahir')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-3 mb-3">
                    <label for="anak_ke" class="form-label">Anak Ke-</label>
                    <input type="number" class="form-control @error('anak_ke') is-invalid @enderror" 
                        id="anak_ke" name="anak_ke" value="{{ old('anak_ke', $santri->anak_ke) }}" 
                        placeholder="Masukkan Anak Ke-" required min="1">
                    @error('anak_ke')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-3 mb-3">
                    <label for="jumlah_saudara_kandung" class="form-label">Jumlah Saudara Kandung</label>
                    <input type="number" class="form-control @error('jumlah_saudara_kandung') is-invalid @enderror" 
                        id="jumlah_saudara_kandung" name="jumlah_saudara_kandung" 
                        value="{{ old('jumlah_saudara_kandung', $santri->jumlah_saudara_kandung) }}" 
                        placeholder="Masukkan Jumlah Saudara" required min="0">
                    @error('jumlah_saudara_kandung')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4 mb-3">
                    <label for="kelurahan" class="form-label">Kelurahan</label>
                    <input type="text" class="form-control @error('kelurahan') is-invalid @enderror" 
                        id="kelurahan" name="kelurahan" value="{{ old('kelurahan', $santri->kelurahan) }}" 
                        placeholder="Masukkan Kelurahan" required>
                    @error('kelurahan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4 mb-3">
                    <label for="kecamatan" class="form-label">Kecamatan</label>
                    <input type="text" class="form-control @error('kecamatan') is-invalid @enderror" 
                        id="kecamatan" name="kecamatan" value="{{ old('kecamatan', $santri->kecamatan) }}" 
                        placeholder="Masukkan Kecamatan" required>
                    @error('kecamatan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4 mb-3">
                    <label for="kabupaten_kota" class="form-label">Kabupaten/Kota</label>
                    <input type="text" class="form-control @error('kabupaten_kota') is-invalid @enderror" 
                        id="kabupaten_kota" name="kabupaten_kota" 
                        value="{{ old('kabupaten_kota', $santri->kabupaten_kota) }}" 
                        placeholder="Masukkan Kabupaten/Kota" required>
                    @error('kabupaten_kota')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="tingkatan_id" class="form-label">Tingkatan Saat Ini</label>
                    <select class="form-control @error('tingkatan_id') is-invalid @enderror" 
                        id="tingkatan_id" name="tingkatan_id" required>
                        <option value="">Pilih Tingkatan</option>
                        @foreach($tingkatan as $t)
                            <option value="{{ $t->id }}" 
                                {{ old('tingkatan_id', $santri->tingkatan_id) == $t->id ? 'selected' : '' }}>
                                {{ $t->nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('tingkatan_id')
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
                    <label for="gedung_id" class="form-label">Gedung</label>
                    <select class="form-control @error('gedung_id') is-invalid @enderror" 
                        id="gedung_id" name="gedung_id" required>
                        <option value="">Pilih Gedung</option>
                        @foreach($gedung as $g)
                            <option value="{{ $g->id }}" 
                                {{ old('gedung_id', $santri->gedung_id) == $g->id ? 'selected' : '' }}>
                                {{ $g->nama_gedung }}
                            </option>
                        @endforeach
                    </select>
                    @error('gedung_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4 mb-3">
                    <label for="kamar_id" class="form-label">Kamar</label>
                    <select class="form-control @error('kamar_id') is-invalid @enderror" 
                        id="kamar_id" name="kamar_id" required>
                        <option value="">Pilih Kamar</option>
                        @foreach($kamar as $k)
                            <option value="{{ $k->id }}" 
                                {{ old('kamar_id', $santri->kamar_id) == $k->id ? 'selected' : '' }}>
                                {{ $k->nama_kamar }}
                            </option>
                        @endforeach
                    </select>
                    @error('kamar_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Data Mahram/Wali Santri -->
        <div class="form-section">
            <h5 class="section-title">Data Mahram/Wali Santri</h5>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="nama_wali" class="form-label">Nama Wali</label>
                    <input type="text" class="form-control @error('nama_wali') is-invalid @enderror" 
                        id="nama_wali" name="nama_wali" 
                        value="{{ old('nama_wali', $santri->waliSantri->nama_wali) }}" 
                        placeholder="Masukkan Nama Wali" required>
                    @error('nama_wali')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="asal_kota" class="form-label">Asal Kota</label>
                    <input type="text" class="form-control @error('asal_kota') is-invalid @enderror" 
                        id="asal_kota" name="asal_kota" 
                        value="{{ old('asal_kota', $santri->waliSantri->asal_kota) }}" 
                        placeholder="Masukkan Asal Kota" required>
                    @error('asal_kota')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Data Ayah -->
                <div class="col-12">
                    <h6 class="mt-3 mb-3">Data Ayah</h6>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="nama_ayah" class="form-label">Nama Ayah</label>
                    <input type="text" class="form-control @error('nama_ayah') is-invalid @enderror" 
                        id="nama_ayah" name="nama_ayah" 
                        value="{{ old('nama_ayah', $santri->waliSantri->nama_ayah) }}" 
                        placeholder="Masukkan Nama Ayah" required>
                    @error('nama_ayah')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-12 mb-3">
                    <label for="alamat_kk_ayah" class="form-label">Alamat KK Ayah</label>
                    <textarea class="form-control @error('alamat_kk_ayah') is-invalid @enderror" 
                        id="alamat_kk_ayah" name="alamat_kk_ayah" rows="3" 
                        placeholder="Masukkan Alamat Sesuai KK" required>{{ old('alamat_kk_ayah', $santri->waliSantri->alamat_kk_ayah) }}</textarea>
                    @error('alamat_kk_ayah')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-12 mb-3">
                    <label for="alamat_domisili_ayah" class="form-label">Alamat Domisili Ayah</label>
                    <textarea class="form-control @error('alamat_domisili_ayah') is-invalid @enderror" 
                        id="alamat_domisili_ayah" name="alamat_domisili_ayah" rows="3" 
                        placeholder="Masukkan Alamat Domisili" required>{{ old('alamat_domisili_ayah', $santri->waliSantri->alamat_domisili_ayah) }}</textarea>
                    @error('alamat_domisili_ayah')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="no_identitas_ayah" class="form-label">No. Identitas Ayah</label>
                    <input type="text" class="form-control @error('no_identitas_ayah') is-invalid @enderror" 
                        id="no_identitas_ayah" name="no_identitas_ayah" 
                        value="{{ old('no_identitas_ayah', $santri->waliSantri->no_identitas_ayah) }}" 
                        placeholder="Masukkan No. Identitas Ayah">
                    @error('no_identitas_ayah')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="no_hp_ayah" class="form-label">No. HP Ayah</label>
                    <input type="text" class="form-control @error('no_hp_ayah') is-invalid @enderror" 
                        id="no_hp_ayah" name="no_hp_ayah" 
                        value="{{ old('no_hp_ayah', $santri->waliSantri->no_hp_ayah) }}" 
                        placeholder="Masukkan No. HP Ayah">
                    @error('no_hp_ayah')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="pendidikan_ayah" class="form-label">Pendidikan Ayah</label>
                    <input type="text" class="form-control @error('pendidikan_ayah') is-invalid @enderror" 
                        id="pendidikan_ayah" name="pendidikan_ayah" 
                        value="{{ old('pendidikan_ayah', $santri->waliSantri->pendidikan_ayah) }}" 
                        placeholder="Masukkan Pendidikan Ayah" required>
                    @error('pendidikan_ayah')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="pekerjaan_ayah" class="form-label">Pekerjaan Ayah</label>
                    <input type="text" class="form-control @error('pekerjaan_ayah') is-invalid @enderror" 
                        id="pekerjaan_ayah" name="pekerjaan_ayah" 
                        value="{{ old('pekerjaan_ayah', $santri->waliSantri->pekerjaan_ayah) }}" 
                        placeholder="Masukkan Pekerjaan Ayah" required>
                    @error('pekerjaan_ayah')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Data Ibu -->
                <div class="col-12">
                    <h6 class="mt-3 mb-3">Data Ibu</h6>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="nama_ibu" class="form-label">Nama Ibu</label>
                    <input type="text" class="form-control @error('nama_ibu') is-invalid @enderror" 
                        id="nama_ibu" name="nama_ibu" 
                        value="{{ old('nama_ibu', $santri->waliSantri->nama_ibu) }}" 
                        placeholder="Masukkan Nama Ibu" required>
                    @error('nama_ibu')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-12 mb-3">
                    <label for="alamat_kk_ibu" class="form-label">Alamat KK Ibu</label>
                    <textarea class="form-control @error('alamat_kk_ibu') is-invalid @enderror" 
                        id="alamat_kk_ibu" name="alamat_kk_ibu" rows="3" 
                        placeholder="Masukkan Alamat Sesuai KK" required>{{ old('alamat_kk_ibu', $santri->waliSantri->alamat_kk_ibu) }}</textarea>
                    @error('alamat_kk_ibu')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-12 mb-3">
                    <label for="alamat_domisili_ibu" class="form-label">Alamat Domisili Ibu</label>
                    <textarea class="form-control @error('alamat_domisili_ibu') is-invalid @enderror" 
                        id="alamat_domisili_ibu" name="alamat_domisili_ibu" rows="3" 
                        placeholder="Masukkan Alamat Domisili" required>{{ old('alamat_domisili_ibu', $santri->waliSantri->alamat_domisili_ibu) }}</textarea>
                    @error('alamat_domisili_ibu')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="no_identitas_ibu" class="form-label">No. Identitas Ibu</label>
                    <input type="text" class="form-control @error('no_identitas_ibu') is-invalid @enderror" 
                        id="no_identitas_ibu" name="no_identitas_ibu" 
                        value="{{ old('no_identitas_ibu', $santri->waliSantri->no_identitas_ibu) }}" 
                        placeholder="Masukkan No. Identitas Ibu">
                    @error('no_identitas_ibu')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="no_hp_ibu" class="form-label">No. HP Ibu</label>
                    <input type="text" class="form-control @error('no_hp_ibu') is-invalid @enderror" 
                        id="no_hp_ibu" name="no_hp_ibu" 
                        value="{{ old('no_hp_ibu', $santri->waliSantri->no_hp_ibu) }}" 
                        placeholder="Masukkan No. HP Ibu">
                    @error('no_hp_ibu')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="pendidikan_ibu" class="form-label">Pendidikan Ibu</label>
                    <input type="text" class="form-control @error('pendidikan_ibu') is-invalid @enderror" 
                        id="pendidikan_ibu" name="pendidikan_ibu" 
                        value="{{ old('pendidikan_ibu', $santri->waliSantri->pendidikan_ibu) }}" 
                        placeholder="Masukkan Pendidikan Ibu" required>
                    @error('pendidikan_ibu')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="pekerjaan_ibu" class="form-label">Pekerjaan Ibu</label>
                    <input type="text" class="form-control @error('pekerjaan_ibu') is-invalid @enderror" 
                        id="pekerjaan_ibu" name="pekerjaan_ibu" 
                        value="{{ old('pekerjaan_ibu', $santri->waliSantri->pekerjaan_ibu) }}" 
                        placeholder="Masukkan Pekerjaan Ibu" required>
                    @error('pekerjaan_ibu')
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
<script>
    $(document).ready(function() {
        // Initialize select2
        $('#gedung_id').select2({
            theme: 'bootstrap-5',
            placeholder: 'Pilih Gedung',
            allowClear: true
        });

        $('#kamar_id').select2({
            theme: 'bootstrap-5',
            placeholder: 'Pilih Kamar',
            allowClear: true
        });

        // Handle gedung change
        $('#gedung_id').on('change', function() {
            var gedungId = $(this).val();
            var kamarSelect = $('#kamar_id');
            
            // Reset kamar dropdown
            kamarSelect.empty().append('<option value="">Pilih Kamar</option>');
            
            if (gedungId) {
                // Fetch kamar based on gedung
                $.ajax({
                    url: '/api/kamar/' + gedungId,
                    type: 'GET',
                    success: function(data) {
                        data.forEach(function(kamar) {
                            kamarSelect.append(new Option(kamar.nama_kamar, kamar.id));
                        });
                        // If editing, set the previously selected kamar
                        @if(old('kamar_id', $santri->kamar_id))
                            kamarSelect.val('{{ old('kamar_id', $santri->kamar_id) }}').trigger('change');
                        @endif
                    }
                });
            }
        });

        // Trigger gedung change on page load if gedung is selected
        if ($('#gedung_id').val()) {
            $('#gedung_id').trigger('change');
        }
    });
</script>
@endpush 