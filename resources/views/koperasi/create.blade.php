@extends('layouts.app')

@section('title', 'Tambah Koperasi')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tambah Koperasi</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('koperasi.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama Koperasi</label>
                    <input type="text" class="form-control @error('nama') is-invalid @enderror" 
                        id="nama" name="nama" value="{{ old('nama') }}" required>
                    @error('nama')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="lokasi" class="form-label">Lokasi</label>
                    <input type="text" class="form-control @error('lokasi') is-invalid @enderror" 
                        id="lokasi" name="lokasi" value="{{ old('lokasi') }}" required>
                    @error('lokasi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="saldo_awal" class="form-label">Saldo Awal</label>
                    <input type="number" class="form-control @error('saldo_awal') is-invalid @enderror" 
                        id="saldo_awal" name="saldo_awal" value="{{ old('saldo_awal', 0) }}" required>
                    @error('saldo_awal')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('koperasi.index') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 