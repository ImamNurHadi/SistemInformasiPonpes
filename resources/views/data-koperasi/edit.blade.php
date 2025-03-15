@extends('layouts.app')

@section('title', 'Edit Data Koperasi')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card shadow-sm">
                <div class="card-header bg-light py-3">
                    <h5 class="mb-0 text-dark">Edit Data Koperasi</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('data-koperasi.update', $dataKoperasi->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="nama_koperasi" class="form-label">Nama Koperasi <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nama_koperasi') is-invalid @enderror" id="nama_koperasi" name="nama_koperasi" value="{{ old('nama_koperasi', $dataKoperasi->nama_koperasi) }}" required>
                            @error('nama_koperasi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="lokasi" class="form-label">Lokasi <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('lokasi') is-invalid @enderror" id="lokasi" name="lokasi" value="{{ old('lokasi', $dataKoperasi->lokasi) }}" required>
                            @error('lokasi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="pengurus_id" class="form-label">Pengurus <span class="text-danger">*</span></label>
                            <select class="form-select @error('pengurus_id') is-invalid @enderror" id="pengurus_id" name="pengurus_id" required>
                                <option value="">Pilih Pengurus</option>
                                @foreach($pengurus as $p)
                                    <option value="{{ $p->id }}" {{ old('pengurus_id', $dataKoperasi->pengurus_id) == $p->id ? 'selected' : '' }}>{{ $p->nama }}</option>
                                @endforeach
                            </select>
                            @error('pengurus_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('data-koperasi.index') }}" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 