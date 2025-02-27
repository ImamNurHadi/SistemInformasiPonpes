@extends('layouts.app')

@section('title', 'Histori Saldo')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Histori Saldo</h3>
                    @if(auth()->user()->isOperator())
                    <a href="{{ route('topup.index') }}" class="btn btn-success">
                        <i class="bi bi-plus-circle me-1"></i>Top Up Baru
                    </a>
                    @endif
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

                    @if(auth()->user()->isAdmin() || auth()->user()->isOperator())
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <form action="{{ route('histori-saldo.index') }}" method="GET" id="searchForm">
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
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
                                            <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai" 
                                                value="{{ request('tanggal_mulai') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="tanggal_akhir" class="form-label">Tanggal Akhir</label>
                                            <input type="date" class="form-control" id="tanggal_akhir" name="tanggal_akhir" 
                                                value="{{ request('tanggal_akhir') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-3 d-flex align-items-end">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary me-2">
                                                <i class="bi bi-search"></i> Cari
                                            </button>
                                            <a href="{{ route('histori-saldo.index') }}" class="btn btn-secondary">
                                                <i class="bi bi-x-circle"></i> Reset
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="historiTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    @if(auth()->user()->isAdmin() || auth()->user()->isOperator())
                                    <th>NIS</th>
                                    <th>Nama Santri</th>
                                    <th>Kelas</th>
                                    @endif
                                    <th>Tanggal</th>
                                    <th>Jumlah</th>
                                    <th>Keterangan</th>
                                    <th>Tipe</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($historiSaldo as $index => $histori)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    @if(auth()->user()->isAdmin() || auth()->user()->isOperator())
                                    <td>{{ $histori->santri->nis }}</td>
                                    <td>{{ $histori->santri->nama }}</td>
                                    <td>{{ optional($histori->santri->tingkatan)->nama }}</td>
                                    @endif
                                    <td>{{ $histori->created_at->format('d/m/Y H:i') }}</td>
                                    <td>Rp {{ number_format($histori->jumlah, 0, ',', '.') }}</td>
                                    <td>{{ $histori->keterangan ?? '-' }}</td>
                                    <td>
                                        <span class="badge bg-{{ $histori->tipe == 'masuk' ? 'success' : 'danger' }}">
                                            {{ ucfirst($histori->tipe) }}
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="{{ auth()->user()->isAdmin() || auth()->user()->isOperator() ? '8' : '5' }}" class="text-center">
                                        @if(!auth()->user()->isAdmin() && !auth()->user()->isOperator() && !auth()->user()->santri)
                                            Anda tidak memiliki akses ke data histori saldo
                                        @else
                                            Tidak ada data histori saldo
                                        @endif
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

@push('scripts')
<script>
    $(document).ready(function() {
        $('#historiTable').DataTable({
            order: [[3, 'desc']], // Sort by tanggal column descending
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

        // Set max date for date inputs to today
        const today = new Date().toISOString().split('T')[0];
        $('#tanggal_mulai').attr('max', today);
        $('#tanggal_akhir').attr('max', today);

        // Update min date of end date when start date changes
        $('#tanggal_mulai').change(function() {
            $('#tanggal_akhir').attr('min', $(this).val());
        });

        // Update max date of start date when end date changes
        $('#tanggal_akhir').change(function() {
            $('#tanggal_mulai').attr('max', $(this).val());
        });
    });
</script>
@endpush
@endsection 