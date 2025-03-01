@extends('layouts.app')

@section('title', 'Form Top Up Saldo Belanja')

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h2 class="m-0 font-weight-bold text-success">Form Top Up Saldo Belanja</h2>
        </div>
        <div class="card-body">
            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Data Santri</h5>
                            <table class="table table-borderless">
                                <tr>
                                    <td>NIS</td>
                                    <td>:</td>
                                    <td>{{ $santri->nis }}</td>
                                </tr>
                                <tr>
                                    <td>Nama</td>
                                    <td>:</td>
                                    <td>{{ $santri->nama }}</td>
                                </tr>
                                <tr>
                                    <td>Kelas</td>
                                    <td>:</td>
                                    <td>{{ optional($santri->tingkatan)->nama }}</td>
                                </tr>
                                <tr>
                                    <td>Saldo Belanja Saat Ini</td>
                                    <td>:</td>
                                    <td>Rp {{ number_format($santri->saldo_belanja, 0, ',', '.') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <form action="{{ route('hidden-saldo-belanja.store') }}" method="POST">
                @csrf
                <input type="hidden" name="santri_id" value="{{ $santri->id }}">
                
                <div class="mb-3">
                    <label for="jumlah" class="form-label">Jumlah Top Up</label>
                    <div class="input-group">
                        <span class="input-group-text">Rp</span>
                        <input type="number" class="form-control @error('jumlah') is-invalid @enderror" 
                            id="jumlah" name="jumlah" value="{{ old('jumlah') }}" 
                            min="1000" step="500" required>
                    </div>
                    <small class="form-text text-muted">Minimal Rp 1.000 dan harus kelipatan 500</small>
                    @error('jumlah')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('hidden-saldo-belanja.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-check-circle"></i> Proses Top Up
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 