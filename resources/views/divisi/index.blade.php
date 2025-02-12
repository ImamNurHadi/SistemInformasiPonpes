@extends('layouts.app')

@section('title', 'Data Divisi')

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h2 class="m-0 font-weight-bold text-primary">Data Divisi</h2>
            <a href="{{ route('divisi.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Tambah Divisi
            </a>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Divisi</th>
                            <th>Sub Divisi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($divisis as $divisi)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $divisi->nama }}</td>
                                <td>{{ $divisi->sub_divisi ?: '-' }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('divisi.edit', $divisi->id) }}" 
                                           class="btn btn-warning btn-sm me-1">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('divisi.destroy', $divisi->id) }}" 
                                              method="POST" 
                                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus divisi ini?');"
                                              class="d-inline">
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
                                <td colspan="4" class="text-center">Tidak ada data divisi</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection 