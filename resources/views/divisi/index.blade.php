@extends('layouts.app')

@section('title', 'Data Divisi')

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h2 class="m-0 font-weight-bold text-success">Data Divisi</h2>
            @if(auth()->user()->isAdmin())
            <a href="{{ route('divisi.create') }}" class="btn btn-success">
                <i class="bi bi-plus-circle me-1"></i>Tambah Divisi
            </a>
            @endif
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
                            <th class="text-center" style="width: 80px">No</th>
                            <th>Nama Divisi</th>
                            <th>Sub Divisi</th>
                            @if(auth()->user()->isAdmin())
                            <th class="text-center" style="width: 150px">Aksi</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($divisis as $divisi)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ $divisi->nama }}</td>
                                <td>
                                    @if($divisi->sub_divisi)
                                        @foreach(explode(',', $divisi->sub_divisi) as $subDivisi)
                                            <span class="badge bg-info me-1">{{ trim($subDivisi) }}</span>
                                        @endforeach
                                    @else
                                        -
                                    @endif
                                </td>
                                @if(auth()->user()->isAdmin())
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('divisi.edit', $divisi->id) }}" 
                                           class="btn btn-warning btn-sm me-1">
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
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ auth()->user()->isAdmin() ? '4' : '3' }}" class="text-center">Tidak ada data divisi</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection 