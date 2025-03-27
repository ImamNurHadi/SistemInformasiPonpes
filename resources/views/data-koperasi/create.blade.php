@extends('layouts.app')

@section('title', 'Tambah Koperasi')

@section('content')
<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-light py-3">
                    <div class="row align-items-center">
                        <div class="col">
                            <h5 class="mb-0 text-dark">Tambah Koperasi</h5>
                        </div>
                        <div class="col text-end">
                            <a href="{{ route('data-koperasi.index') }}" class="btn btn-sm btn-secondary">
                                <i class="bi bi-arrow-left me-1"></i> Kembali
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('data-koperasi.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nama_koperasi" class="form-label">Nama Koperasi</label>
                                    <input type="text" class="form-control @error('nama_koperasi') is-invalid @enderror" 
                                           id="nama_koperasi" name="nama_koperasi" value="{{ old('nama_koperasi') }}" required>
                                    @error('nama_koperasi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="lokasi" class="form-label">Lokasi</label>
                                    <input type="text" class="form-control @error('lokasi') is-invalid @enderror" 
                                           id="lokasi" name="lokasi" value="{{ old('lokasi') }}" required>
                                    @error('lokasi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="pengurus_id" class="form-label">Pengurus</label>
                                    <select class="form-select @error('pengurus_id') is-invalid @enderror" 
                                            id="pengurus_id" name="pengurus_id" required>
                                        <option value="">Pilih Pengurus</option>
                                        @foreach($pengurus as $pengurus)
                                            <option value="{{ $pengurus->id }}" {{ old('pengurus_id') == $pengurus->id ? 'selected' : '' }}>
                                                {{ $pengurus->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('pengurus_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="username" class="form-label">Username</label>
                                    <input type="text" class="form-control @error('username') is-invalid @enderror" 
                                           id="username" name="username" value="{{ old('username') }}" required>
                                    @error('username')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                           id="password" name="password" required>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="saldo_belanja" class="form-label">Saldo Belanja Awal</label>
                                    <input type="number" class="form-control @error('saldo_belanja') is-invalid @enderror" 
                                           id="saldo_belanja" name="saldo_belanja" value="{{ old('saldo_belanja', 0) }}" required>
                                    @error('saldo_belanja')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-1"></i> Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 