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
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tambah Pengajar</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('pengajar.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="nama" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control @error('nama') is-invalid @enderror" 
                            id="nama" name="nama" value="{{ old('nama') }}" 
                            placeholder="Masukkan Nama Ustadz" required>
                        @error('nama')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="nik" class="form-label">Identitas (NIK)</label>
                        <input type="text" class="form-control @error('nik') is-invalid @enderror" 
                            id="nik" name="nik" value="{{ old('nik') }}" 
                            placeholder="Masukkan Nomor Identitas" required>
                        @error('nik')
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
                        <label for="telepon" class="form-label">Telepon / WA</label>
                        <input type="text" class="form-control @error('telepon') is-invalid @enderror" 
                            id="telepon" name="telepon" value="{{ old('telepon') }}" 
                            placeholder="08xxxxxxxxxx" required>
                        @error('telepon')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-12 mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <textarea class="form-control @error('alamat') is-invalid @enderror" 
                            id="alamat" name="alamat" rows="3" required>{{ old('alamat') }}</textarea>
                        @error('alamat')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="bidang_mata_pelajaran" class="form-label">Bidang Mata Pelajaran</label>
                        <select class="form-select @error('bidang_mata_pelajaran') is-invalid @enderror" 
                            id="bidang_mata_pelajaran" name="bidang_mata_pelajaran" required>
                            <option value="">Pilih Mata Pelajaran</option>
                            <option value="Matematika">Matematika</option>
                            <option value="Bahasa Arab">Bahasa Arab</option>
                            <option value="Bahasa Inggris">Bahasa Inggris</option>
                            <option value="Fiqih">Fiqih</option>
                            <option value="Akidah Akhlak">Akidah Akhlak</option>
                            <option value="Al-Quran Hadits">Al-Quran Hadits</option>
                        </select>
                        @error('bidang_mata_pelajaran')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="nuptk" class="form-label">NUPTK</label>
                        <input type="text" class="form-control @error('nuptk') is-invalid @enderror" 
                            id="nuptk" name="nuptk" value="{{ old('nuptk') }}" 
                            placeholder="Masukkan Nomor Induk Pengajar" required>
                        @error('nuptk')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label d-block">Status</label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="status" 
                                id="statusAktif" value="Aktif" checked>
                            <label class="form-check-label" for="statusAktif">Aktif</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="status" 
                                id="statusTidakAktif" value="Tidak Aktif">
                            <label class="form-check-label" for="statusTidakAktif">Tidak Aktif</label>
                        </div>
                    </div>
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('pengajar.index') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/locales/bootstrap-datepicker.id.min.js"></script>
<script>
    $(function(){
        $('.input-group.date').datepicker({
            format: "dd-mm-yyyy",
            todayBtn: "linked",
            clearBtn: true,
            language: "id",
            autoclose: true,
            todayHighlight: true,
            endDate: new Date()
        });

        $('#calendar-addon').click(function(){
            $('#tanggal_lahir').datepicker('show');
        });
    });
</script>
@endpush 