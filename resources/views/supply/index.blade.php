@extends('layouts.app')

@section('title', 'Daftar Supply')

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
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Daftar Supply {{ ucfirst($kategori) }}</h1>
        <a href="{{ route('supply.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Barang
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="row align-items-center">
                <div class="col">
                    <h6 class="m-0 font-weight-bold text-primary">Data Supply</h6>
                </div>
                <div class="col-auto">
                    <div class="btn-group">
                        <a href="{{ route('supply.index', ['kategori' => 'koperasi']) }}" 
                           class="btn btn-{{ $kategori == 'koperasi' ? 'primary' : 'outline-primary' }}">
                            Koperasi
                        </a>
                        <a href="{{ route('supply.index', ['kategori' => 'kantin']) }}" 
                           class="btn btn-{{ $kategori == 'kantin' ? 'primary' : 'outline-primary' }}">
                            Kantin
                        </a>
                    </div>
                </div>
            </div>
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
                            <th class="text-center" style="width: 10%">Stok</th>
                            <th class="text-center" style="width: 15%">Harga Beli</th>
                            <th class="text-center" style="width: 15%">Harga Jual</th>
                            <th>Deskripsi</th>
                            <th class="text-center" style="width: 15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($supplies as $supply)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ $supply->nama_barang }}</td>
                                <td class="text-center">{{ $supply->stok }}</td>
                                <td class="text-end">Rp {{ number_format($supply->harga_beli, 0, ',', '.') }}</td>
                                <td class="text-end">Rp {{ number_format($supply->harga_jual, 0, ',', '.') }}</td>
                                <td>{{ $supply->deskripsi ?? '-' }}</td>
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
                                <td colspan="7" class="text-center">Tidak ada data</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-end">
                {{ $supplies->appends(['kategori' => $kategori])->links() }}
            </div>
        </div>
    </div>
</div>
@endsection 