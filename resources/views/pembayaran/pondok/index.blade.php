@extends('layouts.app')

@section('title', 'Pembayaran Pondok')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Pembayaran Pondok</h3>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <form action="{{ route('pembayaran-pondok.search') }}" method="GET" id="filterForm">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="nis" class="form-label">NIS</label>
                                            <input type="text" class="form-control" id="nis" name="nis" 
                                                value="{{ request('nis') }}" placeholder="Cari NIS...">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="nama" class="form-label">Nama Santri</label>
                                            <input type="text" class="form-control" id="nama" name="nama" 
                                                value="{{ request('nama') }}" placeholder="Cari nama...">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="tingkatan_id" class="form-label">Kelas</label>
                                            <select class="form-select" id="tingkatan_id" name="tingkatan_id">
                                                <option value="">Semua Kelas</option>
                                                @foreach($tingkatan as $t)
                                                    <option value="{{ $t->id }}" {{ request('tingkatan_id') == $t->id ? 'selected' : '' }}>
                                                        {{ $t->nama }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3 d-flex align-items-end">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-success me-2">
                                                <i class="bi bi-search me-1"></i>Cari
                                            </button>
                                            <a href="{{ route('pembayaran-pondok.index') }}" class="btn btn-secondary">
                                                <i class="bi bi-arrow-clockwise me-1"></i>Reset
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

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

                    @if(isset($santri))
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped" id="dataTable">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>NIS</th>
                                        <th>Nama Santri</th>
                                        <th>Kelas</th>
                                        <th>Saldo Utama</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($santri as $index => $s)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $s->nis }}</td>
                                        <td>{{ $s->nama }}</td>
                                        <td>{{ optional($s->tingkatan)->nama }}</td>
                                        <td>Rp {{ number_format($s->saldo_utama, 0, ',', '.') }}</td>
                                        <td>
                                            <button type="button" class="btn btn-primary btn-sm" 
                                                data-bs-toggle="modal" data-bs-target="#bayarModal{{ $s->id }}">
                                                <i class="bi bi-cash-coin me-1"></i>Bayar
                                            </button>

                                            <!-- Modal Pembayaran -->
                                            <div class="modal fade" id="bayarModal{{ $s->id }}" tabindex="-1" aria-labelledby="bayarModalLabel{{ $s->id }}" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="bayarModalLabel{{ $s->id }}">Pembayaran Pondok - {{ $s->nama }}</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <form action="{{ route('pembayaran-pondok.store') }}" method="POST">
                                                            @csrf
                                                            <div class="modal-body">
                                                                <input type="hidden" name="santri_id" value="{{ $s->id }}">
                                                                
                                                                <div class="mb-3">
                                                                    <label for="jumlah" class="form-label">Jumlah Pembayaran</label>
                                                                    <div class="input-group">
                                                                        <span class="input-group-text">Rp</span>
                                                                        <input type="number" class="form-control" id="jumlah" name="jumlah" min="1000" required>
                                                                    </div>
                                                                    <small class="text-muted">Saldo Utama: Rp {{ number_format($s->saldo_utama, 0, ',', '.') }}</small>
                                                                </div>
                                                                
                                                                <div class="mb-3">
                                                                    <label for="keterangan" class="form-label">Keterangan</label>
                                                                    <textarea class="form-control" id="keterangan" name="keterangan" rows="3" placeholder="Masukkan keterangan pembayaran (opsional)"></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                                <button type="submit" class="btn btn-primary">Bayar</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Tidak ada data santri</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info">
                            Silakan cari santri untuk melakukan pembayaran pondok.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json'
            }
        });

        // Initialize select2 for tingkatan dropdown
        $('#tingkatan_id').select2({
            theme: 'bootstrap-5',
            placeholder: 'Pilih Kelas',
            allowClear: true
        });
    });
</script>
@endpush
@endsection 