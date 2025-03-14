@extends('layouts.app')

@section('title', 'Profile')

@push('styles')
<style>
    .profile-card {
        background: white;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
        margin-bottom: 20px;
    }
    .profile-header {
        background: #058B42;
        color: white;
        padding: 20px;
        border-radius: 10px 10px 0 0;
        position: relative;
    }
    .profile-header h4 {
        margin: 0;
        font-weight: 600;
    }
    .profile-body {
        padding: 20px;
    }
    .profile-info {
        margin-bottom: 10px;
    }
    .profile-info label {
        font-weight: 600;
        color: #666;
        margin-bottom: 5px;
        display: block;
    }
    .profile-info p {
        color: #333;
        margin-bottom: 15px;
    }
    .profile-actions {
        padding: 20px;
        border-top: 1px solid #eee;
    }
    .btn-action {
        margin-bottom: 10px;
    }
    .qr-code-container {
        text-align: center;
        margin-bottom: 20px;
        padding: 20px;
        background: #f8f9fa;
        border-radius: 8px;
    }
    .qr-code-container p {
        margin-top: 10px;
        color: #666;
        font-size: 0.9em;
    }
    .saldo-info {
        background: #e9ecef;
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 20px;
    }
    .saldo-info .label {
        font-size: 0.9em;
        color: #666;
    }
    .saldo-info .value {
        font-size: 1.2em;
        font-weight: bold;
        color: #058B42;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <!-- Kartu Identitas -->
        <div class="col-md-6">
            <div class="profile-card">
                <div class="profile-header">
                    <h4>Identitas {{ Auth::user()->role->name }}</h4>
                </div>
                <div class="profile-body">
                    @php
                        $santri = Auth::user()->santri;
                    @endphp

                    @if($santri)
                    <div class="qr-code-container">
                        {!! $santri->generateQrCode() !!}
                        <p class="text-muted">Gunakan QR Code ini untuk transaksi di kantin dan koperasi</p>
                    </div>

                    <div class="saldo-info">
                        <div class="row text-center">
                            <div class="col-md-4">
                                <div class="label">Saldo Utama</div>
                                <div class="value">Rp {{ number_format($santri->saldo_utama, 0, ',', '.') }}</div>
                            </div>
                            <div class="col-md-4">
                                <div class="label">Saldo Belanja</div>
                                <div class="value">Rp {{ number_format($santri->saldo_belanja, 0, ',', '.') }}</div>
                            </div>
                            <div class="col-md-4">
                                <div class="label">Saldo Tabungan</div>
                                <div class="value">Rp {{ number_format($santri->saldo_tabungan, 0, ',', '.') }}</div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <div class="row">
                        <div class="col-md-6">
                            <div class="profile-info">
                                <label>Nama</label>
                                <p>{{ Auth::user()->name }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="profile-info">
                                <label>Email</label>
                                <p>{{ Auth::user()->email }}</p>
                            </div>
                        </div>
                    </div>

                    @if($santri)
                    <div class="row">
                        <div class="col-md-6">
                            <div class="profile-info">
                                <label>NIS</label>
                                <p>{{ $santri->nis }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="profile-info">
                                <label>Tingkatan</label>
                                <p>{{ $santri->tingkatan ? $santri->tingkatan->nama : '-' }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="profile-info">
                                <label>Komplek</label>
                                <p>{{ $santri->komplek ? $santri->komplek->nama_komplek : '-' }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="profile-info">
                                <label>Kamar</label>
                                <p>{{ $santri->kamar ? $santri->kamar->nama_kamar : '-' }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="profile-info">
                                <label>Tempat, Tanggal Lahir</label>
                                <p>{{ $santri->tempat_lahir }}, {{ $santri->tanggal_lahir->format('d F Y') }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="profile-info">
                                <label>No. HP</label>
                                <p>{{ $santri->no_hp }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="profile-info">
                        <label>Alamat</label>
                        <p>{{ $santri->alamat }}, {{ $santri->kelurahan }}, {{ $santri->kecamatan }}, {{ $santri->kabupaten_kota }}</p>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="profile-info">
                                <label>Nama Ayah</label>
                                <p>{{ $santri->nama_ayah }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="profile-info">
                                <label>Nama Ibu</label>
                                <p>{{ $santri->nama_ibu }}</p>
                            </div>
                        </div>
                    </div>
                    @endif

                    <div class="profile-actions">
                        @if(!auth()->user()->isSantri())
                        <a href="{{ route('profile.edit-info') }}" class="btn btn-primary w-100 btn-action">
                            <i class="bi bi-person-gear"></i> Update Profile
                        </a>
                        <a href="{{ route('profile.edit-security') }}" class="btn btn-warning w-100 btn-action">
                            <i class="bi bi-shield-lock"></i> Update Email & Password
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

