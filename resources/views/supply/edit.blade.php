@extends('layouts.app')

@section('title', 'Edit Supply')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Supply</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Form Edit Supply</h6>
        </div>
        <div class="card-body">
            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('supply.update', $supply->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="nama_barang" class="form-label">Nama Barang</label>
                        <input type="text" class="form-control @error('nama_barang') is-invalid @enderror" 
                            id="nama_barang" name="nama_barang" 
                            value="{{ old('nama_barang', $supply->nama_barang) }}" 
                            placeholder="Masukkan Nama Barang" required>
                        @error('nama_barang')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="kategori" class="form-label">Kategori</label>
                        <select class="form-control @error('kategori') is-invalid @enderror" 
                            id="kategori" name="kategori" required>
                            <option value="">Pilih Kategori</option>
                            <option value="koperasi" {{ old('kategori', $supply->kategori) == 'koperasi' ? 'selected' : '' }}>
                                Koperasi
                            </option>
                            <option value="kantin" {{ old('kategori', $supply->kategori) == 'kantin' ? 'selected' : '' }}>
                                Kantin
                            </option>
                        </select>
                        @error('kategori')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="stok" class="form-label">Stok</label>
                        <input type="number" class="form-control @error('stok') is-invalid @enderror" 
                            id="stok" name="stok" value="{{ old('stok', $supply->stok) }}" 
                            placeholder="Masukkan Jumlah Stok" required min="0">
                        @error('stok')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="harga_beli" class="form-label">Harga Beli</label>
                        <input type="number" class="form-control @error('harga_beli') is-invalid @enderror" 
                            id="harga_beli" name="harga_beli" 
                            value="{{ old('harga_beli', $supply->harga_beli) }}" 
                            placeholder="Masukkan Harga Beli" required min="0">
                        @error('harga_beli')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="harga_jual" class="form-label">Harga Jual</label>
                        <input type="number" class="form-control @error('harga_jual') is-invalid @enderror" 
                            id="harga_jual" name="harga_jual" 
                            value="{{ old('harga_jual', $supply->harga_jual) }}" 
                            placeholder="Masukkan Harga Jual" required min="0">
                        @error('harga_jual')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12 mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                            id="deskripsi" name="deskripsi" rows="3" 
                            placeholder="Masukkan Deskripsi Barang">{{ old('deskripsi', $supply->deskripsi) }}</textarea>
                        @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button type="submit" class="btn btn-primary me-md-2">Simpan</button>
                    <a href="{{ route('supply.index') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 