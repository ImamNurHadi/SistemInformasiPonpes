@extends('layouts.app')

@section('title', 'Edit Divisi')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit Divisi</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('divisi.update', $divisi->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama Divisi</label>
                            <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ old('nama', $divisi->nama) }}" required>
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="sub_divisi" class="form-label">Sub Divisi</label>
                            <input type="text" class="form-control @error('sub_divisi') is-invalid @enderror" id="sub_divisi" name="sub_divisi" value="{{ old('sub_divisi', $divisi->sub_divisi) }}">
                            <small class="text-muted">Opsional. Pisahkan dengan koma jika lebih dari satu sub divisi.</small>
                            @error('sub_divisi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                            <a href="{{ route('divisi.index') }}" class="btn btn-secondary">Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 