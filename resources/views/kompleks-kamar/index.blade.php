@extends('layouts.app')

@section('title', 'Data Kamar')

@push('styles')
<!-- DataTables CSS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">

<style>
    .form-section {
        background: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
        margin-bottom: 20px;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h2 class="m-0 font-weight-bold text-success">Data Kamar</h2>
            @if(auth()->user()->isAdmin())
            <a href="#" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#tambahKamarModal">
                <i class="bi bi-plus-circle me-1"></i>Tambah Kamar
            </a>
            @endif
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="row mb-4">
                <!-- Tabel Kamar -->
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="kamarTable">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width: 80px">No</th>
                                    <th>Nama Gedung</th>
                                    <th>Nama Kamar</th>
                                    <th class="text-center">Jumlah Santri</th>
                                    @if(auth()->user()->isAdmin())
                                    <th class="text-center" style="width: 150px">Aksi</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($kamar as $item)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $item->gedung->nama_gedung }}</td>
                                    <td>{{ $item->nama_kamar }}</td>
                                    <td class="text-center">{{ $item->santri_count }} Santri</td>
                                    @if(auth()->user()->isAdmin())
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('kompleks-kamar.edit', $item->id) }}" class="btn btn-warning btn-sm me-1">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                            <form action="{{ route('kompleks-kamar.destroy-kamar', $item->id) }}" method="POST" 
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
                                        Tidak ada data kamar
                                    </td>
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

@if(auth()->user()->isAdmin())
<!-- Modal Tambah Kamar -->
<div class="modal fade" id="tambahKamarModal" tabindex="-1" aria-labelledby="tambahKamarModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahKamarModalLabel">Tambah Kamar</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('kompleks-kamar.store-kamar') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nama_gedung" class="form-label">Nama Gedung</label>
                        <input type="text" class="form-control @error('nama_gedung') is-invalid @enderror" 
                            id="nama_gedung" name="nama_gedung" value="{{ old('nama_gedung') }}" required>
                        @error('nama_gedung')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="nama_kamar" class="form-label">Nama Kamar</label>
                        <input type="text" class="form-control @error('nama_kamar') is-invalid @enderror" 
                            id="nama_kamar" name="nama_kamar" value="{{ old('nama_kamar') }}" required>
                        @error('nama_kamar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

@endsection

@push('scripts')
<!-- DataTables -->
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>

<script>
    $(document).ready(function() {
        // Inisialisasi DataTable untuk tabel kamar
        $('#kamarTable').DataTable({
            responsive: true,
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.13.7/i18n/id.json'
            }
        });

        // Auto-capitalize input gedung dan kamar
        $('#nama_gedung, #nama_kamar').on('input', function() {
            $(this).val(function(_, val) {
                return val.toUpperCase();
            });
        });
    });

    // Fungsi konfirmasi hapus
    function confirmDelete(formId) {
        if (confirm('Apakah Anda yakin ingin menghapus kamar ini?')) {
            document.getElementById(formId).submit();
        }
        return false;
    }
</script>
@endpush 