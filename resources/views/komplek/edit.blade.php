@extends('layouts.app')

@section('title', 'Edit Data Komplek')

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h2 class="m-0 font-weight-bold text-primary">Edit Data Komplek</h2>
        </div>
        <div class="card-body">
            <form action="{{ route('komplek.update', $komplek->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-3">
                    <label for="nama_gedung" class="form-label">Nama Komplek</label>
                    <input type="text" class="form-control @error('nama_gedung') is-invalid @enderror" 
                        id="nama_gedung" name="nama_gedung" value="{{ old('nama_gedung', $komplek->nama_gedung) }}" 
                        required>
                    @error('nama_gedung')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('komplek.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-save"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Auto-capitalize input komplek
        $('#nama_gedung').on('input', function() {
            $(this).val(function(_, val) {
                return val.toUpperCase();
            });
        });
    });
</script>
@endpush 