@extends('layouts.app')

@section('title', 'Transfer ke Pengguna')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="bi bi-send me-2"></i> Transfer ke Pengguna</h5>
                </div>
                <div class="card-body">
                    @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                    @endif
                    
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="me-3">
                                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                                <i class="bi bi-person-fill" style="font-size: 1.5rem;"></i>
                                            </div>
                                        </div>
                                        <div>
                                            <h5 class="mb-1">{{ $targetSantri->nama_lengkap }}</h5>
                                            <small class="text-muted">{{ $targetSantri->nis ?? 'NIS: -' }}</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <form action="{{ route('transfer.qrcode.process') }}" method="POST">
                        @csrf
                        <input type="hidden" name="target_id" value="{{ $targetSantri->id }}">
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="source_type" class="form-label">Dari Saldo</label>
                                <select name="source_type" id="source_type" class="form-select" required>
                                    <option value="">-- Pilih Saldo Sumber --</option>
                                    @if(isset($saldo['utama']))
                                    <option value="utama">Saldo Utama - Rp {{ number_format($saldo['utama']) }}</option>
                                    @endif
                                    @if(isset($saldo['belanja']))
                                    <option value="belanja">Saldo Belanja - Rp {{ number_format($saldo['belanja']) }}</option>
                                    @endif
                                    @if(isset($saldo['tabungan']))
                                    <option value="tabungan">Saldo Tabungan - Rp {{ number_format($saldo['tabungan']) }}</option>
                                    @endif
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="target_type" class="form-label">Ke Saldo</label>
                                <select name="target_type" id="target_type" class="form-select" required>
                                    <option value="">-- Pilih Saldo Tujuan --</option>
                                    <option value="utama">Saldo Utama</option>
                                    <option value="belanja">Saldo Belanja</option>
                                    <option value="tabungan">Saldo Tabungan</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="amount" class="form-label">Jumlah Transfer (Rp)</label>
                                <input type="number" name="amount" id="amount" class="form-control" min="1000" placeholder="Minimal Rp 1.000" required>
                            </div>
                            <div class="col-md-6">
                                <label for="keterangan" class="form-label">Keterangan (Opsional)</label>
                                <input type="text" name="keterangan" id="keterangan" class="form-control" placeholder="Keterangan transfer">
                            </div>
                        </div>
                        
                        <div class="alert alert-warning">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            Pastikan data tujuan transfer sudah benar sebelum melanjutkan.
                        </div>
                        
                        <div class="d-flex gap-2">
                            <a href="{{ route('transfer.qrcode') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left me-2"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-primary ms-auto">
                                <i class="bi bi-send me-2"></i> Kirim Transfer
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 