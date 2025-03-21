@extends('layouts.app')

@section('title', 'Detail Supplier')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card shadow-sm">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 text-dark">Detail Supplier</h5>
                    <div>
                        <a href="{{ route('supplier.edit', $supplier->id) }}" class="btn btn-sm btn-warning">
                            <i class="fas fa-edit me-1"></i> Edit
                        </a>
                        <a href="{{ route('supplier.index') }}" class="btn btn-sm btn-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Kembali
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h3 class="text-primary">{{ $supplier->nama_supplier }}</h3>
                            <p class="text-muted mb-0"><i class="fas fa-map-marker-alt me-2"></i>{{ $supplier->alamat }}</p>
                            <p class="text-muted mb-0"><i class="fas fa-phone me-2"></i>{{ $supplier->telepon }}</p>
                            <p class="text-muted mb-0"><i class="fas fa-envelope me-2"></i>{{ $supplier->email }}</p>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <div class="bg-light p-3 rounded">
                                <h5 class="mb-1">Saldo Belanja</h5>
                                <h3 class="text-success mb-0">Rp. {{ number_format($supplier->saldo_belanja, 0, ',', '.') }}</h3>
                            </div>
                        </div>
                    </div>
                    
                    <hr>
                    
                    <div class="row mt-4">
                        <div class="col-12">
                            <h5 class="mb-3">Informasi Login</h5>
                            <table class="table table-sm table-borderless">
                                <tr>
                                    <td width="150">Username</td>
                                    <td width="20">:</td>
                                    <td>{{ $supplier->username }}</td>
                                </tr>
                                <tr>
                                    <td>Password</td>
                                    <td>:</td>
                                    <td>****** <span class="text-muted">(disembunyikan)</span></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 