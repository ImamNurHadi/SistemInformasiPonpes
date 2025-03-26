@extends('layouts.app')

@section('title', 'Pengaturan Pembayaran Otomatis')

@push('styles')
<style>
    .card {
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    .card-header {
        background-color: #fff;
        border-bottom: 1px solid #e3e6f0;
        padding: 15px 20px;
    }
    .card-body {
        padding: 20px;
    }
    .btn-toggle {
        width: 80px;
    }
    /* Dropdown styles */
    .dropdown-menu {
        min-width: 180px;
    }
    .dropdown-item {
        padding: 0.5rem 1rem;
    }
    .dropdown-item:hover {
        background-color: #f8f9fa;
    }
    .dropdown-item form {
        display: block;
        width: 100%;
    }
    .dropdown-item button {
        text-align: left;
        width: 100%;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Tambah Pengaturan Pembayaran Otomatis</h3>
                </div>
                <div class="card-body">
                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('pembayaran-auto.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <label for="jenis_pembayaran" class="form-label">Jenis Pembayaran</label>
                                    <select class="form-select @error('jenis_pembayaran') is-invalid @enderror" 
                                        id="jenis_pembayaran" name="jenis_pembayaran" required>
                                        <option value="">Pilih Jenis Pembayaran</option>
                                        <option value="pondok">Pondok</option>
                                        <option value="kamar">Kamar</option>
                                        <option value="ruang_kelas">Ruang Kelas</option>
                                        <option value="tingkatan">Tingkatan</option>
                                        <option value="komplek">Komplek</option>
                                    </select>
                                    @error('jenis_pembayaran')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <label for="jumlah" class="form-label">Nominal Pembayaran</label>
                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>
                                        <input type="number" class="form-control @error('jumlah') is-invalid @enderror" 
                                            id="jumlah" name="jumlah" value="{{ old('jumlah') }}" 
                                            min="500" step="500" required>
                                    </div>
                                    <small class="text-muted">Masukkan nilai dalam kelipatan 500 (mis: 500, 1000, 1500, dst)</small>
                                    @error('jumlah')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group mb-3">
                                    <label for="tanggal_eksekusi" class="form-label">Tanggal Eksekusi</label>
                                    <input type="number" class="form-control @error('tanggal_eksekusi') is-invalid @enderror" 
                                        id="tanggal_eksekusi" name="tanggal_eksekusi" value="{{ old('tanggal_eksekusi', 1) }}" 
                                        min="1" max="28" required>
                                    @error('tanggal_eksekusi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <label for="keterangan" class="form-label">Keterangan</label>
                                    <input type="text" class="form-control @error('keterangan') is-invalid @enderror" 
                                        id="keterangan" name="keterangan" value="{{ old('keterangan') }}">
                                    @error('keterangan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-1 d-flex align-items-end">
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" value="1" id="aktif" name="aktif" checked>
                                    <label class="form-check-label" for="aktif">
                                        Aktif
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-save me-1"></i>Simpan Pengaturan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Daftar Pengaturan Pembayaran Otomatis</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="dataTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Jenis Pembayaran</th>
                                    <th>Nominal</th>
                                    <th>Tanggal Eksekusi</th>
                                    <th>Keterangan</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($settings as $index => $setting)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ ucfirst(str_replace('_', ' ', $setting->jenis_pembayaran)) }}</td>
                                    <td>Rp {{ number_format($setting->jumlah, 0, ',', '.') }}</td>
                                    <td>Tanggal {{ $setting->tanggal_eksekusi }} setiap bulan</td>
                                    <td>{{ $setting->keterangan ?? '-' }}</td>
                                    <td>
                                        <span class="badge bg-{{ $setting->aktif ? 'success' : 'danger' }}">
                                            {{ $setting->aktif ? 'Aktif' : 'Nonaktif' }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton{{ $setting->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="bi bi-gear"></i> Aksi
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $setting->id }}">
                                                <li>
                                                    <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#editModal{{ $setting->id }}">
                                                        <i class="bi bi-pencil me-2"></i> Edit
                                                    </a>
                                                </li>
                                                <li>
                                                    <form action="{{ route('pembayaran-auto.toggle-status', $setting->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="dropdown-item">
                                                            <i class="bi bi-{{ $setting->aktif ? 'toggle-off' : 'toggle-on' }} me-2"></i> 
                                                            {{ $setting->aktif ? 'Nonaktifkan' : 'Aktifkan' }}
                                                        </button>
                                                    </form>
                                                </li>
                                                <li>
                                                    <form action="{{ route('pembayaran-auto.process') }}" method="POST" class="d-inline">
                                                        @csrf
                                                        <input type="hidden" name="setting_id" value="{{ $setting->id }}">
                                                        <button type="submit" class="dropdown-item" 
                                                            onclick="return confirm('Anda yakin ingin memproses pembayaran otomatis untuk semua santri sekarang?')">
                                                            <i class="bi bi-lightning me-2"></i> Proses Sekarang
                                                        </button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                        
                                        <!-- Edit Modal -->
                                        <div class="modal fade" id="editModal{{ $setting->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $setting->id }}" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <form action="{{ route('pembayaran-auto.update', $setting->id) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="editModalLabel{{ $setting->id }}">Edit Pengaturan Pembayaran Otomatis</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group mb-3">
                                                                        <label for="edit_jenis_pembayaran{{ $setting->id }}" class="form-label">Jenis Pembayaran</label>
                                                                        <select class="form-select" id="edit_jenis_pembayaran{{ $setting->id }}" name="jenis_pembayaran" required>
                                                                            <option value="pondok" {{ $setting->jenis_pembayaran == 'pondok' ? 'selected' : '' }}>Pondok</option>
                                                                            <option value="kamar" {{ $setting->jenis_pembayaran == 'kamar' ? 'selected' : '' }}>Kamar</option>
                                                                            <option value="ruang_kelas" {{ $setting->jenis_pembayaran == 'ruang_kelas' ? 'selected' : '' }}>Ruang Kelas</option>
                                                                            <option value="tingkatan" {{ $setting->jenis_pembayaran == 'tingkatan' ? 'selected' : '' }}>Tingkatan</option>
                                                                            <option value="komplek" {{ $setting->jenis_pembayaran == 'komplek' ? 'selected' : '' }}>Komplek</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group mb-3">
                                                                        <label for="edit_jumlah{{ $setting->id }}" class="form-label">Nominal Pembayaran</label>
                                                                        <div class="input-group">
                                                                            <span class="input-group-text">Rp</span>
                                                                            <input type="number" class="form-control" id="edit_jumlah{{ $setting->id }}" 
                                                                                name="jumlah" value="{{ $setting->jumlah }}" min="500" step="500" required>
                                                                        </div>
                                                                        <small class="text-muted">Masukkan nilai dalam kelipatan 500 (mis: 500, 1000, 1500, dst)</small>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group mb-3">
                                                                        <label for="edit_tanggal_eksekusi{{ $setting->id }}" class="form-label">Tanggal Eksekusi</label>
                                                                        <input type="number" class="form-control" id="edit_tanggal_eksekusi{{ $setting->id }}" 
                                                                            name="tanggal_eksekusi" value="{{ $setting->tanggal_eksekusi }}" min="1" max="28" required>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group mb-3">
                                                                        <label for="edit_keterangan{{ $setting->id }}" class="form-label">Keterangan</label>
                                                                        <input type="text" class="form-control" id="edit_keterangan{{ $setting->id }}" 
                                                                            name="keterangan" value="{{ $setting->keterangan }}">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-check mb-3">
                                                                        <input class="form-check-input" type="checkbox" value="1" 
                                                                            id="edit_aktif{{ $setting->id }}" name="aktif" {{ $setting->aktif ? 'checked' : '' }}>
                                                                        <label class="form-check-label" for="edit_aktif{{ $setting->id }}">
                                                                            Aktif
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center">Belum ada pengaturan pembayaran otomatis</td>
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
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable();

        // Function to round to nearest 500
        function roundTo500(value) {
            return Math.round(value / 500) * 500;
        }

        // For add form
        $('#jumlah').on('blur', function() {
            var value = $(this).val();
            if (value) {
                $(this).val(roundTo500(parseInt(value)));
            }
        });

        // For edit forms
        $('input[id^="edit_jumlah"]').on('blur', function() {
            var value = $(this).val();
            if (value) {
                $(this).val(roundTo500(parseInt(value)));
            }
        });
    });
</script>
@endpush 