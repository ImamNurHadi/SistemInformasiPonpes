@extends('layouts.app')

@section('title', 'Data Pengajar')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Data Pengajar</h1>
        <a href="{{ route('pengajar.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Tambah Pengajar
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NUPTK</th>
                            <th>Nama</th>
                            <th>Telepon</th>
                            <th>Alamat</th>
                            <th width="150">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pengajars as $pengajar)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $pengajar->nuptk }}</td>
                                <td>{{ $pengajar->nama }}</td>
                                <td>{{ $pengajar->telepon }}</td>
                                <td>{{ $pengajar->alamat }}</td>
                                <td>
                                    <a href="{{ route('pengajar.edit', $pengajar->id) }}" class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('pengajar.destroy', $pengajar->id) }}" method="POST" class="d-inline" id="delete-form-{{ $pengajar->id }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete('delete-form-{{ $pengajar->id }}')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Tidak ada data</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection 