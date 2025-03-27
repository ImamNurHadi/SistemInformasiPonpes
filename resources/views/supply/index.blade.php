@extends('layouts.app')

@section('title', 'Data Supply')

@section('content')
<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-light py-3">
                    <div class="row align-items-center">
                        <div class="col">
                            <h5 class="mb-0 text-dark">Data Supply</h5>
                        </div>
                        <div class="col text-end">
                            <a href="{{ route('supply.create') }}" class="btn btn-sm btn-success">
                                <i class="bi bi-plus-circle me-1"></i> Tambah Supply
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

                    <!-- Form Pencarian -->
                    <form action="{{ route('supply.index') }}" method="GET" class="mb-4">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="supplier_id" class="form-label">Supplier</label>
                                    <select name="supplier_id" id="supplier_id" class="form-select">
                                        <option value="">Semua Supplier</option>
                                        @foreach($suppliers as $supplier)
                                            <option value="{{ $supplier->id }}" {{ request('supplier_id') == $supplier->id ? 'selected' : '' }}>
                                                {{ $supplier->nama_supplier }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="koperasi_id" class="form-label">Koperasi</label>
                                    <select name="koperasi_id" id="koperasi_id" class="form-select">
                                        <option value="">Semua Koperasi</option>
                                        @foreach($koperasis as $koperasi)
                                            <option value="{{ $koperasi->id }}" {{ request('koperasi_id') == $koperasi->id ? 'selected' : '' }}>
                                                {{ $koperasi->nama_koperasi }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="tanggal_awal" class="form-label">Tanggal Awal</label>
                                    <input type="date" name="tanggal_awal" id="tanggal_awal" class="form-control" value="{{ request('tanggal_awal') }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="tanggal_akhir" class="form-label">Tanggal Akhir</label>
                                    <input type="date" name="tanggal_akhir" id="tanggal_akhir" class="form-control" value="{{ request('tanggal_akhir') }}">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="search" class="form-label">Cari Barang/Kategori</label>
                                    <input type="text" name="search" id="search" class="form-control" value="{{ request('search') }}" placeholder="Cari nama barang atau kategori...">
                                </div>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-search me-1"></i> Cari
                                </button>
                                <a href="{{ route('supply.index') }}" class="btn btn-secondary">
                                    <i class="bi bi-x-circle me-1"></i> Reset
                                </a>
                            </div>
                        </div>
                    </form>
                    
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th width="5%">No</th>
                                    <th>Tanggal</th>
                                    <th>Nama Barang</th>
                                    <th>Kategori</th>
                                    <th>Supplier</th>
                                    <th>Koperasi</th>
                                    <th>Stok</th>
                                    <th>Harga Satuan</th>
                                    <th>Total Harga</th>
                                    <th class="text-center" width="15%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($supplies as $supply)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>{{ $supply->tanggal_masuk->format('d/m/Y H:i') }}</td>
                                        <td>{{ $supply->nama_barang }}</td>
                                        <td>{{ $supply->kategori }}</td>
                                        <td>{{ $supply->supplier->nama_supplier }}</td>
                                        <td>{{ $supply->dataKoperasi->nama_koperasi }}</td>
                                        <td class="text-end">{{ $supply->stok }}</td>
                                        <td class="text-end">Rp. {{ number_format($supply->harga_satuan, 0, ',', '.') }}</td>
                                        <td class="text-end">Rp. {{ number_format($supply->total_harga, 0, ',', '.') }}</td>
                                        <td class="text-center">
                                            <div class="d-flex gap-1">
                                                <a href="{{ route('supply.edit', $supply->id) }}" class="btn btn-sm btn-warning">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <form action="{{ route('supply.destroy', $supply->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
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
                                        <td colspan="10" class="text-center">Tidak ada data supply</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        {{ $supplies->withQueryString()->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 