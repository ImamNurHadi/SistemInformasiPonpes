@extends('layouts.app')

@section('title', 'Data Ruang Kelas')

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h2 class="m-0 font-weight-bold text-success">Data Ruang Kelas</h2>
            @if(auth()->user()->isAdmin())
            <a href="{{ route('ruang-kelas.create') }}" class="btn btn-success">
                <i class="bi bi-plus-circle me-1"></i>Tambah Ruang Kelas
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
                            <th>Nama Ruang Kelas</th>
                            <th>Jumlah Santri</th>
                            <th>Keterangan</th>
                            @if(auth()->user()->isAdmin())
                            <th class="text-center" style="width: 150px">Aksi</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($ruangKelas as $item)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $item->nama_ruang_kelas }}</td>
                            <td>{{ $item->santri_count }} Santri</td>
                            <td>{{ $item->keterangan ?? '-' }}</td>
                            @if(auth()->user()->isAdmin())
                            <td class="text-center">
                                <div class="btn-group" role="group">
                                    <a href="{{ route('ruang-kelas.edit', $item->id) }}" class="btn btn-warning btn-sm me-1">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <form action="{{ route('ruang-kelas.destroy', $item->id) }}" method="POST" 
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
                            <td colspan="{{ auth()->user()->isAdmin() ? '5' : '4' }}" class="text-center">
                                Tidak ada data ruang kelas
                            </td>
                        </tr>
                        @endforelse
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

    function confirmDelete(formId) {
        if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
            document.getElementById(formId).submit();
        }
        return false;
    }
</script>
@endpush 