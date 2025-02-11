@extends('layouts.app')

@section('title', 'Edit Santri')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Santri</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('santri.update', $santri->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="id_emoney" class="form-label">ID E-Money</label>
                    <input type="text" class="form-control @error('id_emoney') is-invalid @enderror" 
                        id="id_emoney" name="id_emoney" value="{{ old('id_emoney', $santri->id_emoney) }}" required>
                    @error('id_emoney')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="nis" class="form-label">NIS</label>
                    <input type="text" class="form-control @error('nis') is-invalid @enderror" 
                        id="nis" name="nis" value="{{ old('nis', $santri->nis) }}" required>
                    @error('nis')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="nama" class="form-label">Nama</label>
                    <input type="text" class="form-control @error('nama') is-invalid @enderror" 
                        id="nama" name="nama" value="{{ old('nama', $santri->nama) }}" required>
                    @error('nama')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="asrama" class="form-label">Asrama</label>
                    <input type="text" class="form-control @error('asrama') is-invalid @enderror" 
                        id="asrama" name="asrama" value="{{ old('asrama', $santri->asrama) }}" required>
                    @error('asrama')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="kamar" class="form-label">Kamar</label>
                    <input type="text" class="form-control @error('kamar') is-invalid @enderror" 
                        id="kamar" name="kamar" value="{{ old('kamar', $santri->kamar) }}" required>
                    @error('kamar')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="tingkatan_masuk" class="form-label">Tingkatan</label>
                    <select class="form-select @error('tingkatan_masuk') is-invalid @enderror" 
                        id="tingkatan_masuk" name="tingkatan_masuk" required>
                        <option value="">Pilih Tingkatan</option>
                        <option value="SD" {{ old('tingkatan_masuk', $santri->tingkatan_masuk) == 'SD' ? 'selected' : '' }}>SD</option>
                        <option value="SMP" {{ old('tingkatan_masuk', $santri->tingkatan_masuk) == 'SMP' ? 'selected' : '' }}>SMP</option>
                        <option value="SMA" {{ old('tingkatan_masuk', $santri->tingkatan_masuk) == 'SMA' ? 'selected' : '' }}>SMA</option>
                    </select>
                    @error('tingkatan_masuk')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('santri.index') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 