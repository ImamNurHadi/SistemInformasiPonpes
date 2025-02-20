@extends('layouts.app')

@section('title', 'Data Kamar')

@push('styles')
<!-- DataTables CSS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />

<style>
    .form-section {
        background: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
        margin-bottom: 20px;
    }
    .select2-container--bootstrap-5 .select2-selection {
        min-height: 38px;
        padding: 0.375rem 0.75rem;
    }
    .modal-content {
        border-radius: 8px;
        box-shadow: 0 0 20px rgba(0,0,0,0.1);
    }
    .modal-header {
        background-color: #f8f9fa;
        border-radius: 8px 8px 0 0;
    }
    .modal-footer {
        background-color: #f8f9fa;
        border-radius: 0 0 8px 8px;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h2 class="m-0 font-weight-bold text-success">Data Kamar</h2>
            @if(auth()->user()->isAdmin())
            <a href="{{ route('kamar.create') }}" class="btn btn-success">
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

            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered" id="kamarTable">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 80px">No</th>
                            <th>Nama Kamar</th>
                            <th>Gedung</th>
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
                            <td>{{ $item->nama_kamar }}</td>
                            <td>{{ $item->gedung->nama_gedung }}</td>
                            <td class="text-center">{{ $item->santri_count }} Santri</td>
                            @if(auth()->user()->isAdmin())
                            <td class="text-center">
                                <div class="btn-group" role="group">
                                    <a href="{{ route('kamar.edit', $item->id) }}" class="btn btn-warning btn-sm me-1">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <form action="{{ route('kamar.destroy', $item->id) }}" method="POST" 
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

@if(auth()->user()->isAdmin())
<!-- Modal Tambah Kamar -->
<div class="modal fade" id="tambahKamarModal" tabindex="-1" aria-labelledby="tambahKamarModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahKamarModalLabel">Tambah Kamar</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('kamar.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-section">
                        <div class="mb-3">
                            <label for="gedung_id" class="form-label">Gedung</label>
                            <select class="form-select @error('gedung_id') is-invalid @enderror" id="gedung_id" name="gedung_id" required>
                                <option value="">Pilih Gedung</option>
                                @foreach($gedung as $g)
                                    <option value="{{ $g->id }}" {{ old('gedung_id') == $g->id ? 'selected' : '' }}>
                                        {{ $g->nama_gedung }}
                                    </option>
                                @endforeach
                            </select>
                            @error('gedung_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="nama_kamar" class="form-label">Nama Kamar</label>
                            <input type="text" class="form-control @error('nama_kamar') is-invalid @enderror" 
                                id="nama_kamar" name="nama_kamar" value="{{ old('nama_kamar') }}" 
                                placeholder="Masukkan nama kamar" required>
                            @error('nama_kamar')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-1"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-save me-1"></i>Simpan
                    </button>
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
<!-- Select2 -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
        // Inisialisasi DataTable
        $('#kamarTable').DataTable({
            responsive: true,
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.13.7/i18n/id.json'
            }
        });

        // Initialize select2 for gedung dropdown
        $('#gedung_id').select2({
            theme: 'bootstrap-5',
            width: '100%',
            placeholder: 'Pilih Gedung',
            dropdownParent: $('#tambahKamarModal')
        });

        // Auto-capitalize input kamar
        $('#nama_kamar').on('input', function() {
            $(this).val($(this).val().toUpperCase());
        });
    });

    // Fungsi konfirmasi hapus
    function confirmDelete(formId) {
        if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
            document.getElementById(formId).submit();
        }
        return false;
    }
</script>
@endpush 