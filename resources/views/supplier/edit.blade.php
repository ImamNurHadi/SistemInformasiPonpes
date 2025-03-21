@extends('layouts.app')

@section('title', 'Edit Supplier')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <!-- Card untuk informasi saldo supplier -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-light py-3">
                    <h5 class="mb-0 text-dark">Informasi Saldo Supplier</h5>
                </div>
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <div class="mb-0">
                                <h3 class="text-primary mb-1">Rp. {{ number_format($supplier->saldo_belanja, 0, ',', '.') }}</h3>
                                <p class="text-muted mb-0">Saldo saat ini</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <form action="{{ route('supplier.top-up', $supplier->id) }}" method="POST">
                                @csrf
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" name="jumlah_topup" class="form-control @error('jumlah_topup') is-invalid @enderror" placeholder="Jumlah Top Up" min="1000" step="1000" required>
                                    <button class="btn btn-success" type="submit">Top Up Saldo</button>
                                </div>
                                @error('jumlah_topup')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Minimal top up Rp. 1.000</div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Card untuk edit data supplier -->
            <div class="card shadow-sm">
                <div class="card-header bg-light py-3">
                    <h5 class="mb-0 text-dark">Edit Supplier</h5>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                    
                    <form action="{{ route('supplier.update', $supplier->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="nama_supplier" class="form-label">Nama Supplier <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nama_supplier') is-invalid @enderror" id="nama_supplier" name="nama_supplier" value="{{ old('nama_supplier', $supplier->nama_supplier) }}" required>
                            @error('nama_supplier')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" rows="3" required>{{ old('alamat', $supplier->alamat) }}</textarea>
                            @error('alamat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="telepon" class="form-label">Telepon <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('telepon') is-invalid @enderror" id="telepon" name="telepon" value="{{ old('telepon', $supplier->telepon) }}" required>
                            @error('telepon')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $supplier->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="username" class="form-label">Username <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('username') is-invalid @enderror" id="username" name="username" value="{{ old('username', $supplier->username) }}" required>
                            @error('username')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="password" class="form-label">Password (Opsional)</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Biarkan kosong jika tidak ingin mengubah password</div>
                        </div>
                        
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('supplier.index') }}" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 