@extends('layouts.app')

@section('title', 'Data Kompleks & Kamar')

@push('styles')
<!-- DataTables CSS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">

<style>
    .nav-pills .nav-link.active {
        background-color: #058B42;
    }
    .nav-pills .nav-link {
        color: #058B42;
    }
    .form-section {
        display: none;
    }
    .form-section.active {
        display: block;
    }
    /* DataTables Custom Styling */
    .dataTables_wrapper .sorting:after,
    .dataTables_wrapper .sorting_asc:after,
    .dataTables_wrapper .sorting_desc:after {
        color: #058B42 !important;
    }
    .dataTables_wrapper .sorting_asc:after,
    .dataTables_wrapper .sorting_desc:after {
        opacity: 1 !important;
    }
    .table thead th {
        cursor: pointer;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Data Kompleks & Kamar</h1>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="row mb-4">
        <div class="col-md-12">
            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="pills-kompleks-tab" data-bs-toggle="pill" 
                        data-bs-target="#pills-kompleks" type="button" role="tab">
                        Data Kompleks
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pills-kamar-tab" data-bs-toggle="pill" 
                        data-bs-target="#pills-kamar" type="button" role="tab">
                        Data Kamar
                    </button>
                </li>
            </ul>
        </div>
    </div>

    <div class="tab-content" id="pills-tabContent">
        <!-- Tab Kompleks -->
        <div class="tab-pane fade show active" id="pills-kompleks" role="tabpanel">
            <div class="row">
                <!-- Form Tambah Kompleks -->
                <div class="col-md-4">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Tambah Kompleks</h6>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('kompleks-kamar.store-kompleks') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="nama_kompleks" class="form-label">Nama Kompleks</label>
                                    <input type="text" class="form-control @error('nama_kompleks') is-invalid @enderror" 
                                        id="nama_kompleks" name="nama_kompleks" value="{{ old('nama_kompleks') }}" 
                                        placeholder="Masukkan Nama Kompleks" required>
                                    @error('nama_kompleks')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Tabel Kompleks -->
                <div class="col-md-8">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Daftar Kompleks</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="kompleksTable">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Kompleks</th>
                                            <th>Jumlah Kamar</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($kompleks as $k)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $k->nama_kompleks }}</td>
                                                <td>{{ $k->kamar->count() }}</td>
                                                <td>
                                                    <form action="{{ route('kompleks-kamar.destroy-kompleks', $k->id) }}" 
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm" 
                                                            onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </form>
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

        <!-- Tab Kamar -->
        <div class="tab-pane fade" id="pills-kamar" role="tabpanel">
            <div class="row">
                <!-- Form Tambah Kamar -->
                <div class="col-md-4">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Tambah Kamar</h6>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('kompleks-kamar.store-kamar') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="kompleks_id" class="form-label">Kompleks</label>
                                    <select class="form-control @error('kompleks_id') is-invalid @enderror" 
                                        id="kompleks_id" name="kompleks_id" required>
                                        <option value="">Pilih Kompleks</option>
                                        @foreach($kompleks as $k)
                                            <option value="{{ $k->id }}" {{ old('kompleks_id') == $k->id ? 'selected' : '' }}>
                                                {{ $k->nama_kompleks }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('kompleks_id')
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
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Tabel Kamar -->
                <div class="col-md-8">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Daftar Kamar</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="kamarTable">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Kompleks</th>
                                            <th>Nama Kamar</th>
                                            <th>Jumlah Santri</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($kamar as $index => $k)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $k->kompleks->nama_kompleks }}</td>
                                                <td>{{ $k->nama_kamar }}</td>
                                                <td>{{ $k->santri->count() }}</td>
                                                <td>
                                                    <form action="{{ route('kompleks-kamar.destroy-kamar', $k->id) }}" 
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm" 
                                                            onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </form>
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
    </div>
</div>
@endsection

@push('scripts')
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<!-- DataTables -->
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>

<script>
    $(document).ready(function() {
        // Inisialisasi DataTable untuk tabel kompleks
        $('#kompleksTable').DataTable({
            responsive: true,
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.13.7/i18n/id.json'
            }
        });

        // Inisialisasi DataTable untuk tabel kamar
        $('#kamarTable').DataTable({
            responsive: true,
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.13.7/i18n/id.json'
            },
            columnDefs: [
                { targets: [0], orderable: false }, // Kolom nomor tidak bisa diurutkan
                { targets: [4], orderable: false }  // Kolom aksi tidak bisa diurutkan
            ],
            order: [[1, 'asc']], // Default sort by Nama Kompleks ascending
            rowCallback: function(row, data, index) {
                // Update nomor urut
                $('td:eq(0)', row).html(index + 1);
            }
        });
    });
</script>
@endpush 