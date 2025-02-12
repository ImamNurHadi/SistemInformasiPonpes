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
            <h2 class="m-0 font-weight-bold text-primary">Data Kamar</h2>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="row mb-4">
                <!-- Form Tambah Kamar -->
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Tambah Kamar Baru</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('kompleks-kamar.store-kamar') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="nama_gedung" class="form-label">Nama Gedung</label>
                                    <input type="text" class="form-control @error('nama_gedung') is-invalid @enderror" 
                                        id="nama_gedung" name="nama_gedung" value="{{ old('nama_gedung') }}" 
                                        placeholder="Masukkan Nama Gedung" required>
                                    @error('nama_gedung')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="nama_kamar" class="form-label">Nama Kamar</label>
                                    <input type="text" class="form-control @error('nama_kamar') is-invalid @enderror" 
                                        id="nama_kamar" name="nama_kamar" value="{{ old('nama_kamar') }}" 
                                        placeholder="Masukkan Nama Kamar" required>
                                    @error('nama_kamar')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-plus-circle"></i> Tambah Kamar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Tabel Kamar -->
                <div class="col-md-8">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="kamarTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Gedung</th>
                                    <th>Nama Kamar</th>
                                    <th>Jumlah Santri</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($kompleks as $index => $k)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $k->nama_gedung }}</td>
                                        <td>{{ $k->nama_kamar }}</td>
                                        <td>{{ $k->santri->count() }}</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('kompleks-kamar.edit', $k->id) }}" class="btn btn-warning btn-sm me-1">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <form action="{{ route('kompleks-kamar.destroy-kamar', $k->id) }}" 
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" 
                                                        onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
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
    </div>
</div>
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
</script>
@endpush 