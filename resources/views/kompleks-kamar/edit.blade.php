@extends('layouts.app')

@section('title', 'Edit Data Kamar')

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h2 class="m-0 font-weight-bold text-primary">Edit Data Kamar</h2>
        </div>
        <div class="card-body">
            <form action="{{ route('kompleks-kamar.update', $kompleks->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-3">
                    <label for="nama_gedung" class="form-label">Nama Gedung</label>
                    <input type="text" class="form-control @error('nama_gedung') is-invalid @enderror" 
                        id="nama_gedung" name="nama_gedung" value="{{ old('nama_gedung', $kompleks->nama_gedung) }}" 
                        required>
                    @error('nama_gedung')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="nama_kamar" class="form-label">Nama Kamar</label>
                    <input type="text" class="form-control @error('nama_kamar') is-invalid @enderror" 
                        id="nama_kamar" name="nama_kamar" value="{{ old('nama_kamar', $kompleks->nama_kamar) }}" 
                        required>
                    @error('nama_kamar')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('kompleks-kamar.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 