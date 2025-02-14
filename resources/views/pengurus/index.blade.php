@extends('layouts.app')

@section('title', 'Data Pengurus')

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h2 class="m-0 font-weight-bold text-success">Data Pengurus</h2>
            @if(auth()->user()->isAdmin())
            <a href="{{ route('pengurus.create') }}" class="btn btn-success">
                <i class="bi bi-plus-circle me-1"></i>Tambah Pengurus
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
                            <th>Nama</th>
                            <th>Jabatan</th>
                            <th>Divisi</th>
                            <th>Sub Divisi</th>
                            @if(auth()->user()->isAdmin())
                            <th class="text-center" style="width: 150px">Aksi</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pengurus as $item)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $item->nama }}</td>
                            <td>{{ $item->jabatan }}</td>
                            <td>{{ optional($item->divisi)->nama }}</td>
                            <td>{{ $item->sub_divisi }}</td>
                            @if(auth()->user()->isAdmin())
                            <td class="text-center">
                                <div class="btn-group" role="group">
                                    <a href="{{ route('pengurus.edit', $item->id) }}" class="btn btn-warning btn-sm me-1">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <form action="{{ route('pengurus.destroy', $item->id) }}" method="POST" 
                                        id="delete-form-{{ $item->id }}" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger btn-sm" 
                                            onclick="return confirmDelete('delete-form-{{ $item->id }}')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                            @endif
                        </tr>
                        @empty
                        <tr>
                            <td colspan="{{ auth()->user()->isAdmin() ? '6' : '5' }}" class="text-center">
                                Tidak ada data pengurus
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable();
    });
</script>
@endpush
@endsection 