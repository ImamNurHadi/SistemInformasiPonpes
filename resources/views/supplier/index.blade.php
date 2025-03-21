@extends('layouts.app')

@section('title', 'Data Supplier')

@section('content')
<style>
    /* Fix untuk tampilan tombol aksi */
    .btn-group form {
        display: inline-block;
    }
    .btn-group .btn {
        border-radius: 4px;
        margin: 0 2px;
    }
    .table td.text-center {
        vertical-align: middle;
    }
    .d-flex.gap-1 form {
        display: inline-block;
    }
    .d-flex.gap-1 .btn {
        border-radius: 4px;
        margin: 0 1px;
    }
    .table td .d-flex.gap-1 {
        justify-content: center;
    }
</style>

<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-light py-3">
                    <div class="row align-items-center">
                        <div class="col">
                            <h5 class="mb-0 text-dark">Data Supplier</h5>
                        </div>
                        <div class="col text-end">
                            <a href="{{ route('supplier.create') }}" class="btn btn-sm btn-success">
                                <i class="bi bi-plus-circle me-1"></i> Tambah Supplier
                            </a>
                        </div>
                    </div>
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
                    
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th width="5%">No</th>
                                    <th>Nama Supplier</th>
                                    <th>Alamat</th>
                                    <th>Telepon</th>
                                    <th>Email</th>
                                    <th>Saldo Belanja</th>
                                    <th class="text-center" width="15%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($suppliers as $supplier)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>{{ $supplier->nama_supplier }}</td>
                                        <td>{{ $supplier->alamat }}</td>
                                        <td>{{ $supplier->telepon }}</td>
                                        <td>{{ $supplier->email }}</td>
                                        <td>Rp. {{ number_format($supplier->saldo_belanja, 0, ',', '.') }}</td>
                                        <td class="text-center">
                                            <div class="d-flex gap-1">
                                                <a href="{{ route('supplier.edit', $supplier->id) }}" class="btn btn-sm btn-warning">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <form action="{{ route('supplier.destroy', $supplier->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus supplier ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">Tidak ada data supplier</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 