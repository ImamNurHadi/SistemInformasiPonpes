@extends('layouts.app')

@section('title', 'Tambah Kamar')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tambah Kamar</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('kamar.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="kompleks_id" class="form-label">Kompleks</label>
                    <select class="form-control @error('kompleks_id') is-invalid @enderror" 
                        id="kompleks_id" name="kompleks_id" required>
                        <option value="">Pilih Kompleks</option>
                        @foreach($kompleks as $k)
                            <option value="{{ $k->id }}" {{ old('kompleks_id') == $k->id ? 'selected' : '' }}>
                                {{ $k->nama_kompleks }}
                            </option>
                        @endforeach
                    </select>
                    @error('kompleks_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="nama_kamar" class="form-label">Nama Kamar</label>
                    <input type="text" class="form-control @error('nama_kamar') is-invalid @enderror" 
                        id="nama_kamar" name="nama_kamar" value="{{ old('nama_kamar') }}" 
                        placeholder="Masukkan Nama Kamar" required>
                    @error('nama_kamar')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('kamar.index') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 