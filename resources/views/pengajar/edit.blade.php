@extends('layouts.app')

@section('title', 'Edit Pengajar')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit Pengajar</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('pengajar.update', $pengajar->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <!-- Data Pribadi -->
                            <div class="col-md-6">
                                <h4>Data Pribadi</h4>
                                <div class="mb-3">
                                    <label for="nama" class="form-label">Nama Lengkap</label>
                                    <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ old('nama', $pengajar->nama) }}" required>
                                    @error('nama')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="nik" class="form-label">NIK</label>
                                    <input type="text" class="form-control @error('nik') is-invalid @enderror" id="nik" name="nik" value="{{ old('nik', $pengajar->nik) }}" required>
                                    @error('nik')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                                    <input type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror" id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir', $pengajar->tanggal_lahir->format('Y-m-d')) }}" required>
                                    @error('tanggal_lahir')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="telepon" class="form-label">Nomor Telepon</label>
                                    <input type="text" class="form-control @error('telepon') is-invalid @enderror" id="telepon" name="telepon" value="{{ old('telepon', $pengajar->telepon) }}" required>
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
                                    <input type="text" class="form-control @error('kelurahan_domisili') is-invalid @enderror" id="kelurahan_domisili" name="kelurahan_domisili" value="{{ old('kelurahan_domisili', $pengajar->kelurahan_domisili) }}" required>
                                    @error('kelurahan_domisili')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="kecamatan_domisili" class="form-label">Kecamatan</label>
                                    <input type="text" class="form-control @error('kecamatan_domisili') is-invalid @enderror" id="kecamatan_domisili" name="kecamatan_domisili" value="{{ old('kecamatan_domisili', $pengajar->kecamatan_domisili) }}" required>
                                    @error('kecamatan_domisili')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="kota_domisili" class="form-label">Kota/Kabupaten</label>
                                    <input type="text" class="form-control @error('kota_domisili') is-invalid @enderror" id="kota_domisili" name="kota_domisili" value="{{ old('kota_domisili', $pengajar->kota_domisili) }}" required>
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
                                    <input type="text" class="form-control @error('kelurahan_kk') is-invalid @enderror" id="kelurahan_kk" name="kelurahan_kk" value="{{ old('kelurahan_kk', $pengajar->kelurahan_kk) }}" required>
                                    @error('kelurahan_kk')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="kecamatan_kk" class="form-label">Kecamatan</label>
                                    <input type="text" class="form-control @error('kecamatan_kk') is-invalid @enderror" id="kecamatan_kk" name="kecamatan_kk" value="{{ old('kecamatan_kk', $pengajar->kecamatan_kk) }}" required>
                                    @error('kecamatan_kk')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="kota_kk" class="form-label">Kota/Kabupaten</label>
                                    <input type="text" class="form-control @error('kota_kk') is-invalid @enderror" id="kota_kk" name="kota_kk" value="{{ old('kota_kk', $pengajar->kota_kk) }}" required>
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
                                            <option value="{{ $p }}" {{ old('pendidikan_terakhir', $pengajar->pendidikan_terakhir) == $p ? 'selected' : '' }}>{{ $p }}</option>
                                        @endforeach
                                    </select>
                                    @error('pendidikan_terakhir')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3" id="asal_kampus_div">
                                    <label for="asal_kampus" class="form-label">Asal Kampus</label>
                                    <input type="text" class="form-control @error('asal_kampus') is-invalid @enderror" id="asal_kampus" name="asal_kampus" value="{{ old('asal_kampus', $pengajar->asal_kampus) }}">
                                    @error('asal_kampus')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
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