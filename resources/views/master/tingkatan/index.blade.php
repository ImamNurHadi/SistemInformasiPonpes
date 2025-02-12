@extends('layouts.app')

@section('title', 'Data Tingkatan')

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h2 class="m-0 font-weight-bold text-primary">Data Tingkatan</h2>
            <a href="{{ route('tingkatan.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Tambah Tingkatan
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
                            <th>Nama Tingkatan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tingkatan as $index => $t)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $t->nama }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('tingkatan.edit', $t->id) }}" class="btn btn-warning btn-sm me-1">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('tingkatan.destroy', $t->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection 