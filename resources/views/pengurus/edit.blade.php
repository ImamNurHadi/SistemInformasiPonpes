@extends('layouts.app')

@section('title', 'Edit Pengurus')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Pengurus</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('pengurus.update', $pengurus->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama</label>
                    <input type="text" class="form-control @error('nama') is-invalid @enderror" 
                        id="nama" name="nama" value="{{ old('nama', $pengurus->nama) }}" required>
                    @error('nama')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="divisi" class="form-label">Divisi</label>
                    <input type="text" class="form-control @error('divisi') is-invalid @enderror" 
                        id="divisi" name="divisi" value="{{ old('divisi', $pengurus->divisi) }}" required>
                    @error('divisi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="sub_divisi" class="form-label">Sub Divisi</label>
                    <input type="text" class="form-control @error('sub_divisi') is-invalid @enderror" 
                        id="sub_divisi" name="sub_divisi" value="{{ old('sub_divisi', $pengurus->sub_divisi) }}" required>
                    @error('sub_divisi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('pengurus.index') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 