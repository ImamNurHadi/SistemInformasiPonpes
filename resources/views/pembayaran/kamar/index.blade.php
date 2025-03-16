@extends('layouts.app')

@section('title', 'Pembayaran Kamar')

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h2 class="m-0 font-weight-bold text-success">Pembayaran Kamar</h2>
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

            <!-- Form Pencarian -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="m-0 font-weight-bold text-success">Cari Santri</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('pembayaran-kamar.search') }}" method="GET">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="nis" class="form-label">NIS</label>
                                <input type="text" class="form-control" id="nis" name="nis" value="{{ request('nis') }}">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="nama" class="form-label">Nama Santri</label>
                                <input type="text" class="form-control" id="nama" name="nama" value="{{ request('nama') }}">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="tingkatan_id" class="form-label">Kelas</label>
                                <select class="form-control" id="tingkatan_id" name="tingkatan_id">
                                    <option value="">Semua Kelas</option>
                                    @foreach($tingkatan as $t)
                                        <option value="{{ $t->id }}" {{ request('tingkatan_id') == $t->id ? 'selected' : '' }}>
                                            {{ $t->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="text-end">
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-search me-1"></i>Cari
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Hasil Pencarian -->
            @if(isset($santri))
                <div class="card">
                    <div class="card-header">
                        <h5 class="m-0 font-weight-bold text-success">Hasil Pencarian</h5>
                    </div>
                    <div class="card-body">
                        @if(count($santri) > 0)
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>NIS</th>
                                            <th>Nama</th>
                                            <th>Kelas</th>
                                            <th>Saldo Utama</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($santri as $s)
                                            <tr>
                                                <td>{{ $s->nis }}</td>
                                                <td>{{ $s->nama }}</td>
                                                <td>{{ optional($s->tingkatan)->nama }}</td>
                                                <td>Rp {{ number_format($s->saldo_utama, 0, ',', '.') }}</td>
                                                <td>
                                                    <button type="button" class="btn btn-primary btn-sm" 
                                                        data-bs-toggle="modal" data-bs-target="#bayarModal{{ $s->id }}">
                                                        <i class="bi bi-cash me-1"></i>Bayar
                                                    </button>
                                                </td>
                                            </tr>
                                            
                                            <!-- Modal Pembayaran -->
                                            <div class="modal fade" id="bayarModal{{ $s->id }}" tabindex="-1" aria-labelledby="bayarModalLabel{{ $s->id }}" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="bayarModalLabel{{ $s->id }}">Pembayaran Kamar - {{ $s->nama }}</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <form action="{{ route('pembayaran-kamar.store') }}" method="POST">
                                                            @csrf
                                                            <div class="modal-body">
                                                                <input type="hidden" name="santri_id" value="{{ $s->id }}">
                                                                
                                                                <div class="mb-3">
                                                                    <label for="jumlah" class="form-label">Jumlah Pembayaran (Rp)</label>
                                                                    <input type="number" class="form-control" id="jumlah" name="jumlah" min="1000" required>
                                                                </div>
                                                                
                                                                <div class="mb-3">
                                                                    <label for="keterangan" class="form-label">Keterangan (Opsional)</label>
                                                                    <textarea class="form-control" id="keterangan" name="keterangan" rows="3"></textarea>
                                                                </div>
                                                                
                                                                <div class="alert alert-info">
                                                                    <small>Saldo Utama Saat Ini: <strong>Rp {{ number_format($s->saldo_utama, 0, ',', '.') }}</strong></small>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                                <button type="submit" class="btn btn-success">Proses Pembayaran</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="alert alert-info">
                                Tidak ada data santri yang ditemukan.
                            </div>
                        @endif
                    </div>
                </div>
            @endif
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