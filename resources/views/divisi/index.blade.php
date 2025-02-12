@extends('layouts.app')

@section('title', 'Daftar Divisi')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="card-title">Daftar Divisi</h3>
                        <a href="{{ route('divisi.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus-circle"></i> Tambah Divisi
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
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
                                                   class="btn btn-warning btn-sm">
                                                    <i class="bi bi-pencil-square"></i>
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
    </div>
</div>
@endsection 