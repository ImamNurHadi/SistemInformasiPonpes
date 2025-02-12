@extends('layouts.app')

@section('title', 'Data Pengurus & Divisi')

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h2 class="m-0 font-weight-bold text-primary">Data Pengurus & Divisi</h2>
            <a href="{{ route('pengurus.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Data
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
                            <th>Nama</th>
                            <th>NIK</th>
                            <th>Tempat, Tanggal Lahir</th>
                            <th>No. Telepon</th>
                            <th>Alamat</th>
                            <th>Divisi</th>
                            <th>Sub Divisi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pengurus as $key => $p)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $p->nama }}</td>
                                <td>{{ $p->nik }}</td>
                                <td>{{ $p->tempat_lahir }}, {{ $p->tanggal_lahir ? $p->tanggal_lahir->format('d/m/Y') : '-' }}</td>
                                <td>{{ $p->telepon }}</td>
                                <td>
                                    {{ $p->kelurahan_domisili }}, 
                                    {{ $p->kecamatan_domisili }}, 
                                    {{ $p->kota_domisili }}
                                </td>
                                <td>{{ $p->divisi ? $p->divisi->nama : '-' }}</td>
                                <td>{{ $p->sub_divisi ?: '-' }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('pengurus.edit', $p->id) }}" class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('pengurus.destroy', $p->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                                <i class="fas fa-trash"></i>
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

@push('scripts')
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable();
    });
</script>
@endpush
@endsection 