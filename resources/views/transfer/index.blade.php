@extends('layouts.app')

@section('title', 'Transfer Saldo')

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
    .form-section {
        background: white;
        padding: 20px;
        border-radius: 8px;
        margin-bottom: 20px;
    }
    .section-title {
        color: #4e73df;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 2px solid #4e73df;
    }
    .saldo-info {
        background-color: #f8f9fc;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 20px;
    }
    .saldo-item {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
        padding-bottom: 10px;
        border-bottom: 1px solid #e3e6f0;
    }
    .saldo-item:last-child {
        border-bottom: none;
        margin-bottom: 0;
        padding-bottom: 0;
    }
    .saldo-label {
        font-weight: 600;
    }
    .saldo-value {
        font-weight: 700;
        color: #1cc88a;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h2 class="m-0 font-weight-bold text-success">Transfer Saldo</h2>
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

            <div class="row">
                <div class="col-md-4">
                    <div class="saldo-info">
                        <h5 class="mb-3">Informasi Saldo</h5>
                        <div class="saldo-item">
                            <span class="saldo-label">Saldo Utama</span>
                            <span class="saldo-value">Rp {{ number_format($santri->saldo_utama, 0, ',', '.') }}</span>
                        </div>
                        <div class="saldo-item">
                            <span class="saldo-label">Saldo Belanja</span>
                            <span class="saldo-value">Rp {{ number_format($santri->saldo_belanja, 0, ',', '.') }}</span>
                        </div>
                        <div class="saldo-item">
                            <span class="saldo-label">Saldo Tabungan</span>
                            <span class="saldo-value">Rp {{ number_format($santri->saldo_tabungan, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="form-section">
                        <h5 class="section-title">Form Transfer</h5>
                        <p class="text-muted mb-4">Transfer saldo dari Saldo Utama ke Saldo Belanja atau Saldo Tabungan Anda.</p>
                        <form action="{{ route('transfer.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="jenis_saldo" class="form-label">Jenis Saldo Tujuan</label>
                                <select class="form-select @error('jenis_saldo') is-invalid @enderror" 
                                    id="jenis_saldo" name="jenis_saldo" required>
                                    <option value="">Pilih Jenis Saldo Tujuan</option>
                                    <option value="belanja" {{ old('jenis_saldo') == 'belanja' ? 'selected' : '' }}>Saldo Belanja</option>
                                    <option value="tabungan" {{ old('jenis_saldo') == 'tabungan' ? 'selected' : '' }}>Saldo Tabungan</option>
                                </select>
                                @error('jenis_saldo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="jumlah" class="form-label">Jumlah Transfer</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" class="form-control @error('jumlah') is-invalid @enderror" 
                                        id="jumlah" name="jumlah" value="{{ old('jumlah') }}" 
                                        placeholder="Masukkan jumlah transfer" min="1000" required>
                                </div>
                                <small class="text-muted">Minimal transfer Rp 1.000</small>
                                @error('jumlah')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mt-4">
                                <button type="submit" class="btn btn-success" id="btnTransfer">
                                    <i class="bi bi-arrow-left-right me-1"></i>Transfer
                                </button>
                            </div>
                        </form>
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
        // Initialize select2 for jenis saldo dropdown
        $('#jenis_saldo').select2({
            theme: 'bootstrap-5',
            placeholder: 'Pilih Jenis Saldo Tujuan',
            allowClear: true
        });

        // Confirmation before submit
        $('form').on('submit', function(e) {
            e.preventDefault();
            
            const jenisSaldo = $('#jenis_saldo option:selected').text();
            const jumlah = $('#jumlah').val();
            
            if (confirm(`Apakah Anda yakin akan melakukan transfer dari Saldo Utama ke ${jenisSaldo} sebesar Rp ${Number(jumlah).toLocaleString('id-ID')}?`)) {
                this.submit();
            }
        });
    });
</script>
@endpush 