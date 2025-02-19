@extends('layouts.app')

@section('title', 'Tambah Gedung')

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
            <h2 class="m-0 font-weight-bold text-success">Tambah Gedung</h2>
        </div>
        <div class="card-body">
            <form action="{{ route('gedung.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-section">
                            <h4 class="section-title">Data Gedung</h4>
                            
                            <div class="mb-3">
                                <label for="nama_gedung" class="form-label">Nama Gedung</label>
                                <input type="text" class="form-control @error('nama_gedung') is-invalid @enderror" 
                                    id="nama_gedung" name="nama_gedung" value="{{ old('nama_gedung') }}" 
                                    placeholder="Masukkan nama gedung" required>
                                @error('nama_gedung')
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
                        <a href="{{ route('gedung.index') }}" class="btn btn-secondary">
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
        // Auto-capitalize input gedung
        $('#nama_gedung').on('input', function() {
            $(this).val($(this).val().toUpperCase());
        });
    });
</script>
@endpush 