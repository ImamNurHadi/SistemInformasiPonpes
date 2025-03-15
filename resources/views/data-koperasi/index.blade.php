@extends('layouts.app')

@section('title', 'Data Koperasi')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-light py-3">
                    <div class="row align-items-center">
                        <div class="col">
                            <h5 class="mb-0 text-dark">Data Koperasi</h5>
                        </div>
                        <div class="col text-end">
                            <a href="{{ route('data-koperasi.create') }}" class="btn btn-sm btn-success">
                                <i class="bi bi-plus-circle me-1"></i> Tambah Data
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th width="5%">No</th>
                                    <th>Nama Koperasi</th>
                                    <th>Lokasi</th>
                                    <th>Pengurus</th>
                                    <th width="15%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($dataKoperasi as $koperasi)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $koperasi->nama_koperasi }}</td>
                                    <td>{{ $koperasi->lokasi }}</td>
                                    <td>{{ $koperasi->pengurus->nama ?? 'Tidak ada' }}</td>
                                    <td>
                                        <div class="d-flex gap-1">
                                            <a href="{{ route('data-koperasi.show', $koperasi->id) }}" class="btn btn-sm btn-info">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('data-koperasi.edit', $koperasi->id) }}" class="btn btn-sm btn-warning">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('data-koperasi.destroy', $koperasi->id) }}" method="POST" id="delete-form-{{ $koperasi->id }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-sm btn-danger" onclick="return confirmDelete('delete-form-{{ $koperasi->id }}')">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center">Tidak ada data koperasi</td>
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