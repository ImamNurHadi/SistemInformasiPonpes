@extends('layouts.app')

@section('title', 'Tambah Kompleks')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tambah Kompleks</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('master-kompleks.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="nama_kompleks" class="form-label">Nama Kompleks</label>
                    <input type="text" class="form-control @error('nama_kompleks') is-invalid @enderror" 
                        id="nama_kompleks" name="nama_kompleks" value="{{ old('nama_kompleks') }}" 
                        placeholder="Masukkan Nama Kompleks" required>
                    @error('nama_kompleks')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('master-kompleks.index') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 