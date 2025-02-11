@extends('layouts.app')

@section('title', 'Data Koperasi')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Data Koperasi</h1>
        <a href="{{ route('koperasi.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Tambah Koperasi
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Lokasi</th>
                            <th>Saldo Awal</th>
                            <th width="150">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($koperasi as $k)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $k->nama }}</td>
                                <td>{{ $k->lokasi }}</td>
                                <td>Rp {{ number_format($k->saldo_awal, 0, ',', '.') }}</td>
                                <td>
                                    <a href="{{ route('koperasi.edit', $k->id) }}" class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('koperasi.destroy', $k->id) }}" method="POST" class="d-inline" id="delete-form-{{ $k->id }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete('delete-form-{{ $k->id }}')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">Tidak ada data</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection 