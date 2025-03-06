@extends('layouts.app')

@section('title', 'Edit Data Kamar')

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h2 class="m-0 font-weight-bold text-primary">Edit Data Kamar</h2>
        </div>
        <div class="card-body">
            <form action="{{ route('kompleks-kamar.update', $kamar->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-3">
                    <label for="nama_komplek" class="form-label">Nama Komplek</label>
                    <input type="text" class="form-control @error('nama_komplek') is-invalid @enderror" 
                        id="nama_komplek" name="nama_komplek" value="{{ old('nama_komplek', $kamar->komplek->nama_komplek) }}" 
                        required>
                    @error('nama_komplek')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="nama_kamar" class="form-label">Nama Kamar</label>
                    <input type="text" class="form-control @error('nama_kamar') is-invalid @enderror" 
                        id="nama_kamar" name="nama_kamar" value="{{ old('nama_kamar', $kamar->nama_kamar) }}" 
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