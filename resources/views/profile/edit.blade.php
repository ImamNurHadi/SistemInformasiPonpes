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
    }
    .profile-info p {
        color: #333;
        margin-bottom: 15px;
    }
    .profile-actions {
        padding: 20px;
        border-top: 1px solid #eee;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Kartu Identitas -->
        <div class="col-md-4">
            <div class="profile-card">
                <div class="profile-header">
                    <h4>Identitas</h4>
                </div>
                <div class="profile-body">
                    <div class="profile-info">
                        <label>Nama</label>
                        <p>{{ Auth::user()->name }}</p>
                    </div>
                    <div class="profile-info">
                        <label>Email</label>
                        <p>{{ Auth::user()->email }}</p>
                    </div>
                    <div class="profile-info">
                        <label>Role</label>
                        <p>{{ Auth::user()->role ? Auth::user()->role->name : 'Tidak ada role' }}</p>
                    </div>
                    @if(Auth::user()->santri)
                    <div class="profile-info">
                        <label>NIS</label>
                        <p>{{ Auth::user()->santri->nis }}</p>
                    </div>
                    <div class="profile-info">
                        <label>Tingkatan</label>
                        <p>{{ Auth::user()->santri->tingkatanSaatIni ? Auth::user()->santri->tingkatanSaatIni->nama : '-' }}</p>
                    </div>
                    <div class="profile-info">
                        <label>Kamar</label>
                        <p>{{ Auth::user()->santri->kompleks ? Auth::user()->santri->kompleks->nama_gedung . ' / ' . Auth::user()->santri->kompleks->nama_kamar : '-' }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Form Update -->
        <div class="col-md-8">
            <!-- Update Profile -->
            <div class="profile-card">
                <div class="profile-header">
                    <h4>Update Profile</h4>
                </div>
                <div class="profile-body">
                    <form action="{{ route('profile.update') }}" method="POST">
                        @csrf
                        @method('patch')
                        
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                id="name" name="name" value="{{ old('name', Auth::user()->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="profile-actions">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Update Email & Password -->
            <div class="profile-card">
                <div class="profile-header">
                    <h4>Update Email & Password</h4>
                </div>
                <div class="profile-body">
                    <form action="{{ route('profile.update-email') }}" method="POST">
                        @csrf
                        @method('patch')
                        
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Baru</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                id="email" name="email" value="{{ old('email', Auth::user()->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="current_password" class="form-label">Password Saat Ini</label>
                            <input type="password" class="form-control @error('current_password') is-invalid @enderror" 
                                id="current_password" name="current_password" required>
                            @error('current_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password Baru</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                id="password" name="password">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                            <input type="password" class="form-control" 
                                id="password_confirmation" name="password_confirmation">
                        </div>

                        <div class="profile-actions">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save"></i> Update Email & Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
