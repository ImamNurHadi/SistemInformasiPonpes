@extends('layouts.app')

@section('title', 'Data Santri')

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h2 class="m-0 font-weight-bold text-primary">Data Santri</h2>
            <a href="{{ route('santri.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Tambah Santri
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
                            <th>NIS</th>
                            <th>Nama</th>
                            <th>Gedung/Kamar</th>
                            <th>Tingkatan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($santri as $index => $s)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $s->nis }}</td>
                                <td>{{ $s->nama }}</td>
                                <td>{{ $s->kompleks ? $s->kompleks->nama_gedung . ' / ' . $s->kompleks->nama_kamar : '-' }}</td>
                                <td>{{ $s->tingkatanSaatIni ? $s->tingkatanSaatIni->nama : '-' }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('santri.edit', $s->id) }}" class="btn btn-warning btn-sm me-1">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('santri.destroy', $s->id) }}" method="POST" class="d-inline" 
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
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

@push('scripts')
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable();
    });
</script>
@endpush 