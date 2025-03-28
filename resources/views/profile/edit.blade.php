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
        margin-bottom: 30px;
        padding: 20px;
        background: #f8f9fa;
        border-radius: 8px;
    }
    .qr-code-container svg {
        margin: 0 auto;
        display: block;
        max-width: 100%;
        height: auto;
        border: 3px solid #058B42;
        border-radius: 8px;
        padding: 5px;
        background-color: white;
    }
    .qr-code-container p {
        margin-top: 15px;
        color: #666;
        font-size: 0.95em;
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
                        $pengurus = Auth::user()->pengurus;
                        $koperasi = Auth::user()->dataKoperasi;
                        $supplier = Auth::user()->supplier;
                    @endphp

                    <!-- QR Code Section -->
                    <div class="qr-code-container">
                        @if($santri)
                            {!! $santri->generateQrCode() !!}
                            <p class="text-muted">Gunakan QR Code ini untuk transaksi di kantin dan koperasi</p>
                        @elseif($pengurus)
                            {!! $pengurus->generateQrCode() !!}
                            <p class="text-muted">QR Code Pengurus</p>
                        @elseif($koperasi)
                            {!! $koperasi->generateQrCode() !!}
                            <p class="text-muted">QR Code Koperasi</p>
                        @elseif($supplier)
                            {!! $supplier->generateQrCode() !!}
                            <p class="text-muted">QR Code Supplier</p>
                        @else
                            <div class="alert alert-info">Tidak ada QR Code yang tersedia</div>
                        @endif
                    </div>

                    <!-- Saldo Info Section for Santri -->
                    @if($santri)
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

                    <!-- Saldo Info Section for Supplier & Koperasi -->
                    @if($supplier || $koperasi)
                    <div class="saldo-info">
                        <div class="row text-center">
                            <div class="col-md-12">
                                <div class="label">Saldo Belanja</div>
                                <div class="value">Rp {{ number_format($supplier ? $supplier->saldo_belanja : ($koperasi ? $koperasi->saldo_belanja : 0), 0, ',', '.') }}</div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Basic Info Section -->
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

                    <!-- Role Info Section -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="profile-info">
                                <label>Role</label>
                                <p>{{ Auth::user()->role ? Auth::user()->role->name : '-' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Santri Details Section -->
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

                    <!-- Pengurus Details Section -->
                    @if($pengurus)
                    <div class="row">
                        <div class="col-md-6">
                            <div class="profile-info">
                                <label>NIK</label>
                                <p>{{ $pengurus->nik }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="profile-info">
                                <label>Jabatan</label>
                                <p>{{ $pengurus->jabatan }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="profile-info">
                                <label>Divisi</label>
                                <p>{{ $pengurus->divisi ? $pengurus->divisi->nama : '-' }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="profile-info">
                                <label>Sub Divisi</label>
                                <p>{{ $pengurus->sub_divisi }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="profile-info">
                                <label>Tempat, Tanggal Lahir</label>
                                <p>{{ $pengurus->tempat_lahir }}, {{ $pengurus->tanggal_lahir->format('d F Y') }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="profile-info">
                                <label>Telepon</label>
                                <p>{{ $pengurus->telepon }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="profile-info">
                        <label>Alamat Domisili</label>
                        <p>{{ $pengurus->kelurahan_domisili }}, {{ $pengurus->kecamatan_domisili }}, {{ $pengurus->kota_domisili }}</p>
                    </div>
                    @endif

                    <!-- Koperasi Details Section -->
                    @if($koperasi)
                    <div class="row">
                        <div class="col-md-6">
                            <div class="profile-info">
                                <label>Nama Koperasi</label>
                                <p>{{ $koperasi->nama_koperasi }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="profile-info">
                                <label>Lokasi</label>
                                <p>{{ $koperasi->lokasi }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="profile-info">
                                <label>Username</label>
                                <p>{{ $koperasi->username }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="profile-info">
                                <label>Keuntungan</label>
                                <p>Rp {{ number_format($koperasi->keuntungan, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Supplier Details Section -->
                    @if($supplier)
                    <div class="row">
                        <div class="col-md-6">
                            <div class="profile-info">
                                <label>Nama Supplier</label>
                                <p>{{ $supplier->nama_supplier }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="profile-info">
                                <label>Telepon</label>
                                <p>{{ $supplier->telepon }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="profile-info">
                                <label>Email</label>
                                <p>{{ $supplier->email }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="profile-info">
                                <label>Username</label>
                                <p>{{ $supplier->username }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="profile-info">
                        <label>Alamat</label>
                        <p>{{ $supplier->alamat }}</p>
                    </div>
                    @endif

                    <div class="profile-actions">
                        <a href="{{ route('profile.edit-info') }}" class="btn btn-primary w-100 btn-action">
                            <i class="bi bi-person-gear"></i> Update Profile
                        </a>
                        <a href="{{ route('profile.edit-security') }}" class="btn btn-warning w-100 btn-action">
                            <i class="bi bi-shield-lock"></i> Update Email & Password
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
    <div class="max-w-xl">
        @include('profile.partials.delete-user-form')
    </div>
</div>

<div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
    <div class="max-w-xl">
        @include('profile.partials.qr-code-information')
    </div>
</div>
@endsection

