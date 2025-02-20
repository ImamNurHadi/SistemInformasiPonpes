@extends('layouts.app')

@section('title', 'Tambah Kamar')

@push('styles')
<style>
    .form-section {
        background: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
        margin-bottom: 20px;
    }
    .section-title {
        color: #4e73df;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 2px solid #4e73df;
    }
    .card {
        margin: 0;
        border: none;
        box-shadow: 0 0 15px rgba(0,0,0,0.1);
        border-radius: 10px;
    }
    .card-header {
        background: #fff;
        padding: 15px 20px;
        border-bottom: 1px solid #e3e6f0;
        border-top-left-radius: 10px !important;
        border-top-right-radius: 10px !important;
    }
    .card-body {
        padding: 20px;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h2 class="m-0 font-weight-bold text-success">Tambah Kamar</h2>
        </div>
        <div class="card-body">
            <form action="{{ route('kamar.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-section">
                            <h4 class="section-title">Data Kamar</h4>
                            
                            <div class="mb-3">
                                <label for="gedung_id" class="form-label">Gedung</label>
                                <select class="form-select @error('gedung_id') is-invalid @enderror" id="gedung_id" name="gedung_id" required>
                                    <option value="">Pilih Gedung</option>
                                    @foreach($gedung as $g)
                                        <option value="{{ $g->id }}" {{ old('gedung_id') == $g->id ? 'selected' : '' }}>
                                            {{ $g->nama_gedung }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('gedung_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="nama_kamar" class="form-label">Nama Kamar</label>
                                <input type="text" class="form-control @error('nama_kamar') is-invalid @enderror" 
                                    id="nama_kamar" name="nama_kamar" value="{{ old('nama_kamar') }}" 
                                    placeholder="Masukkan nama kamar" required>
                                @error('nama_kamar')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-save me-1"></i>Simpan
                        </button>
                        <a href="{{ route('kamar.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left me-1"></i>Kembali
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Auto-capitalize input kamar
        $('#nama_kamar').on('input', function() {
            $(this).val($(this).val().toUpperCase());
        });
    });
</script>
@endpush 