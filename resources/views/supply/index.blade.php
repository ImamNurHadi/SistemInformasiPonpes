@extends('layouts.app')

@section('title', 'History Supply')

@push('styles')
<style>
    .action-buttons {
        display: flex;
        gap: 5px;
        justify-content: center;
    }
    .action-buttons form {
        margin: 0;
    }
    .supplier-card {
        margin-bottom: 20px;
    }
    .saldo-info {
        font-size: 1.1rem;
        padding: 10px 15px;
        background-color: #f8f9fc;
        border-radius: 5px;
        border-left: 4px solid #4e73df;
        margin-bottom: 15px;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">History Supply</h1>
        <a href="{{ route('supply.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Barang
        </a>
    </div>

    <div class="card shadow mb-4 supplier-card">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Pilih Supplier</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('supply.index') }}" method="GET" class="mb-4">
                <div class="row">
                    <div class="col-md-8">
                        <select name="supplier_id" class="form-control">
                            <option value="">-- Pilih Supplier --</option>
                            @foreach($suppliers as $supplier)
                                <option value="{{ $supplier->id }}" {{ request('supplier_id') == $supplier->id ? 'selected' : '' }}>
                                    {{ $supplier->nama_supplier }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-primary">Tampilkan</button>
                    </div>
                </div>
            </form>

            @if($selectedSupplier)
                <div class="saldo-info">
                    <div><strong>Supplier:</strong> {{ $selectedSupplier->nama_supplier }}</div>
                    <div><strong>Saldo Belanja:</strong> Rp {{ number_format($selectedSupplier->saldo_belanja, 0, ',', '.') }}</div>
                </div>
            @endif
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">History Supply</h6>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 5%">No</th>
                            <th>Nama Barang</th>
                            <th>Kategori</th>
                            <th class="text-center" style="width: 8%">Stok</th>
                            <th class="text-center" style="width: 12%">Harga Satuan</th>
                            <th class="text-center" style="width: 12%">Total Harga</th>
                            <th>Supplier</th>
                            <th>Koperasi Tujuan</th>
                            <th>Tanggal Masuk</th>
                            <th class="text-center" style="width: 10%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($supplies as $supply)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ $supply->nama_barang }}</td>
                                <td>{{ $supply->kategori }}</td>
                                <td class="text-center">{{ $supply->stok }}</td>
                                <td class="text-end">Rp {{ number_format($supply->harga_satuan, 0, ',', '.') }}</td>
                                <td class="text-end">Rp {{ number_format($supply->total_harga, 0, ',', '.') }}</td>
                                <td>{{ $supply->supplier->nama_supplier ?? 'Tidak ada' }}</td>
                                <td>{{ $supply->dataKoperasi->nama_koperasi ?? 'Tidak ada' }}</td>
                                <td>{{ $supply->tanggal_masuk ? $supply->tanggal_masuk->format('d-m-Y H:i') : '-' }}</td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="{{ route('supply.edit', $supply->id) }}" 
                                           class="btn btn-warning btn-sm">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <form action="{{ route('supply.destroy', $supply->id) }}" 
                                              method="POST" 
                                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center">Tidak ada data</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-end">
                {{ $supplies->appends(['supplier_id' => request('supplier_id')])->links() }}
            </div>
        </div>
    </div>
</div>
@endsection 