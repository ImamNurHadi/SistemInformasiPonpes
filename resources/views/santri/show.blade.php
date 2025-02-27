@extends('layouts.app')

@section('title', 'Detail Santri')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <h5 class="card-title mb-3">QR Code Santri</h5>
                    <div class="qr-code-container mb-3">
                        {!! $santri->generateQrCode() !!}
                    </div>
                    <p class="text-muted small">Gunakan QR Code ini untuk transaksi di kantin dan koperasi</p>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-3">Informasi Santri</h5>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <strong>NIS</strong>
                        </div>
                        <div class="col-md-8">
                            {{ $santri->nis }}
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <strong>Nama</strong>
                        </div>
                        <div class="col-md-8">
                            {{ $santri->nama }}
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <strong>Kelas</strong>
                        </div>
                        <div class="col-md-8">
                            {{ $santri->kelas }}
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <strong>Saldo Belanja</strong>
                        </div>
                        <div class="col-md-8">
                            Rp {{ number_format($santri->saldo_belanja, 0, ',', '.') }}
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <strong>Saldo Utama</strong>
                        </div>
                        <div class="col-md-8">
                            Rp {{ number_format($santri->saldo_utama, 0, ',', '.') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 