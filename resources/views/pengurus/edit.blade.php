@extends('layouts.app')

@section('title', 'Edit Data Pengurus')

@push('styles')
<style>
    .loading {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        z-index: 9999;
        justify-content: center;
        align-items: center;
    }
    .loading-content {
        background: white;
        padding: 20px;
        border-radius: 5px;
        text-align: center;
    }
</style>
@endpush

@section('content')
<div class="loading">
    <div class="loading-content">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
        <div class="mt-2">Menyimpan Data...</div>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Edit Data Pengurus</h2>
                </div>
                <div class="card-body">
                    <!-- Alert untuk error -->
                    <div id="errorAlert" class="alert alert-danger" style="display: none;">
    </div>

                    <form action="{{ route('pengurus.update', $penguru->id) }}" method="POST">
                @csrf
                @method('PUT')
                        
                        <!-- Data Pribadi Section -->
                        <h4 class="mb-3">Data Pribadi</h4>
                        <div class="row">
                            <!-- Kolom Kiri -->
                            <div class="col-md-6">
                <div class="mb-3">
                                    <label for="nama" class="form-label">Nama Lengkap</label>
                                    <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ old('nama', $penguru->nama) }}" required>
                    @error('nama')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                                    <label for="nik" class="form-label">NIK</label>
                                    <input type="text" class="form-control @error('nik') is-invalid @enderror" id="nik" name="nik" value="{{ old('nik', $penguru->nik) }}" required>
                                    @error('nik')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="telepon" class="form-label">Nomor Telepon</label>
                                    <input type="text" class="form-control @error('telepon') is-invalid @enderror" id="telepon" name="telepon" value="{{ old('telepon', $penguru->telepon) }}" required>
                                    @error('telepon')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                                            <input type="text" class="form-control @error('tempat_lahir') is-invalid @enderror" id="tempat_lahir" name="tempat_lahir" value="{{ old('tempat_lahir', $penguru->tempat_lahir) }}" required>
                                            @error('tempat_lahir')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                                            <input type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror" id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir', $penguru->tanggal_lahir ? $penguru->tanggal_lahir->format('Y-m-d') : '') }}" required>
                                            @error('tanggal_lahir')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Kolom Kanan -->
                            <div class="col-md-6">
                                <h5>Alamat Domisili</h5>
                                <div class="mb-3">
                                    <label for="kelurahan_domisili" class="form-label">Kelurahan</label>
                                    <input type="text" class="form-control @error('kelurahan_domisili') is-invalid @enderror" id="kelurahan_domisili" name="kelurahan_domisili" value="{{ old('kelurahan_domisili', $penguru->kelurahan_domisili) }}" required>
                                    @error('kelurahan_domisili')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="kecamatan_domisili" class="form-label">Kecamatan</label>
                                    <input type="text" class="form-control @error('kecamatan_domisili') is-invalid @enderror" id="kecamatan_domisili" name="kecamatan_domisili" value="{{ old('kecamatan_domisili', $penguru->kecamatan_domisili) }}" required>
                                    @error('kecamatan_domisili')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="kota_domisili" class="form-label">Kota/Kabupaten</label>
                                    <input type="text" class="form-control @error('kota_domisili') is-invalid @enderror" id="kota_domisili" name="kota_domisili" value="{{ old('kota_domisili', $penguru->kota_domisili) }}" required>
                                    @error('kota_domisili')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <h5 class="mt-4">Alamat KK</h5>
                                <div class="mb-3">
                                    <label for="kelurahan_kk" class="form-label">Kelurahan</label>
                                    <input type="text" class="form-control @error('kelurahan_kk') is-invalid @enderror" id="kelurahan_kk" name="kelurahan_kk" value="{{ old('kelurahan_kk', $penguru->kelurahan_kk) }}" required>
                                    @error('kelurahan_kk')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="kecamatan_kk" class="form-label">Kecamatan</label>
                                    <input type="text" class="form-control @error('kecamatan_kk') is-invalid @enderror" id="kecamatan_kk" name="kecamatan_kk" value="{{ old('kecamatan_kk', $penguru->kecamatan_kk) }}" required>
                                    @error('kecamatan_kk')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="kota_kk" class="form-label">Kota/Kabupaten</label>
                                    <input type="text" class="form-control @error('kota_kk') is-invalid @enderror" id="kota_kk" name="kota_kk" value="{{ old('kota_kk', $penguru->kota_kk) }}" required>
                                    @error('kota_kk')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Divisi Section -->
                        <h4 class="mb-3 mt-4">Divisi</h4>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="divisi_id" class="form-label">Divisi</label>
                                    <select class="form-select @error('divisi_id') is-invalid @enderror" id="divisi_id" name="divisi_id">
                                        <option value="">Pilih Divisi</option>
                                        @foreach($divisis as $divisi)
                                            <option value="{{ $divisi->id }}" {{ old('divisi_id', $penguru->divisi_id) == $divisi->id ? 'selected' : '' }}>
                                                {{ $divisi->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('divisi_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="sub_divisi" class="form-label">Sub Divisi</label>
                                    <input type="text" class="form-control @error('sub_divisi') is-invalid @enderror" id="sub_divisi" name="sub_divisi" value="{{ old('sub_divisi', $penguru->sub_divisi) }}">
                    @error('sub_divisi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                                <div class="mb-3">
                                    <label for="jabatan" class="form-label">Jabatan</label>
                                    <select class="form-select @error('jabatan') is-invalid @enderror" id="jabatan" name="jabatan" required>
                                        <option value="">Pilih Jabatan</option>
                                        <option value="Ketua" {{ old('jabatan', $penguru->jabatan) == 'Ketua' ? 'selected' : '' }}>Ketua</option>
                                        <option value="Wakil Ketua" {{ old('jabatan', $penguru->jabatan) == 'Wakil Ketua' ? 'selected' : '' }}>Wakil Ketua</option>
                                        <option value="Sekretaris" {{ old('jabatan', $penguru->jabatan) == 'Sekretaris' ? 'selected' : '' }}>Sekretaris</option>
                                        <option value="Bendahara" {{ old('jabatan', $penguru->jabatan) == 'Bendahara' ? 'selected' : '' }}>Bendahara</option>
                                        <option value="Anggota" {{ old('jabatan', $penguru->jabatan) == 'Anggota' ? 'selected' : '' }}>Anggota</option>
                                    </select>
                                    @error('jabatan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mt-3">
                    <a href="{{ route('pengurus.index') }}" class="btn btn-secondary">Kembali</a>
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
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
    const divisiSelect = document.getElementById('divisi_id');
    const subDivisiInput = document.getElementById('sub_divisi');
    const currentSubDivisi = "{{ old('sub_divisi', $penguru->sub_divisi) }}";
    
    function updateSubDivisi() {
        const selectedOption = divisiSelect.options[divisiSelect.selectedIndex];
        if (selectedOption.value) {
            subDivisiInput.value = currentSubDivisi;
        } else {
            subDivisiInput.value = '';
        }
    }

    divisiSelect.addEventListener('change', updateSubDivisi);
    updateSubDivisi();
});
</script>
@endpush
@endsection 