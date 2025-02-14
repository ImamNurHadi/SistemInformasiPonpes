@extends('layouts.app')

@section('title', 'Edit Tingkatan')

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h2 class="m-0 font-weight-bold text-success">Edit Tingkatan</h2>
        </div>
        <div class="card-body">
            <form action="{{ route('tingkatan.update', $tingkatan->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="nama_tingkatan" class="form-label">Nama Tingkatan</label>
                    <input type="text" class="form-control @error('nama_tingkatan') is-invalid @enderror" 
                        id="nama_tingkatan" name="nama_tingkatan" 
                        value="{{ old('nama_tingkatan', $tingkatan->nama_tingkatan) }}" required>
                    @error('nama_tingkatan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="keterangan" class="form-label">Keterangan</label>
                    <textarea class="form-control @error('keterangan') is-invalid @enderror" 
                        id="keterangan" name="keterangan" rows="3">{{ old('keterangan', $tingkatan->keterangan) }}</textarea>
                    @error('keterangan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                    <a href="{{ route('tingkatan.index') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 