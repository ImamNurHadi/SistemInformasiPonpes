@extends('layouts.app')

@section('title', 'Tambah Divisi')

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h2 class="m-0 font-weight-bold text-success">Tambah Divisi</h2>
        </div>
        <div class="card-body">
            <form action="{{ route('divisi.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama Divisi</label>
                    <input type="text" class="form-control @error('nama') is-invalid @enderror" 
                           id="nama" name="nama" value="{{ old('nama') }}" required>
                    @error('nama')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="sub_divisi" class="form-label">Sub Divisi</label>
                    <input type="text" class="form-control @error('sub_divisi') is-invalid @enderror" 
                           id="sub_divisi" name="sub_divisi" value="{{ old('sub_divisi') }}"
                           placeholder="Contoh: Keamanan, Kebersihan, Kesehatan">
                    <small class="form-text text-muted">Pisahkan sub divisi dengan tanda koma (,)</small>
                    @error('sub_divisi')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <a href="{{ route('divisi.index') }}" class="btn btn-secondary me-md-2">Kembali</a>
                    <button type="submit" class="btn btn-success">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 