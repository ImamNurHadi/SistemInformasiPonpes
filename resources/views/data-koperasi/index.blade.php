@extends('layouts.app')

@section('title', 'Data Koperasi')

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
                            <h5 class="mb-0 text-dark">Data Koperasi</h5>
                        </div>
                        <div class="col text-end">
                            <a href="{{ route('data-koperasi.create') }}" class="btn btn-sm btn-success">
                                <i class="bi bi-plus-circle me-1"></i> Tambah Koperasi
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
                                    <th>Nama Koperasi</th>
                                    <th>Lokasi</th>
                                    <th>Pengurus</th>
                                    <th>Saldo Belanja</th>
                                    <th>Keuntungan</th>
                                    <th class="text-center" width="20%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($koperasis as $koperasi)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>{{ $koperasi->nama_koperasi }}</td>
                                        <td>{{ $koperasi->lokasi }}</td>
                                        <td>{{ $koperasi->pengurus->nama }}</td>
                                        <td>Rp. {{ number_format($koperasi->saldo_belanja, 0, ',', '.') }}</td>
                                        <td>Rp. {{ number_format($koperasi->keuntungan, 0, ',', '.') }}</td>
                                        <td class="text-center">
                                            <div class="d-flex gap-1">
                                                <a href="{{ route('data-koperasi.show', $koperasi->id) }}" class="btn btn-sm btn-info">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="{{ route('data-koperasi.edit', $koperasi->id) }}" class="btn btn-sm btn-warning">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <form action="{{ route('data-koperasi.destroy', $koperasi->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus koperasi ini?')">
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
                                        <td colspan="7" class="text-center">Tidak ada data koperasi</td>
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