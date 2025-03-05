@extends('layouts.app')

@section('title', 'Edit Data Kamar')

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h2 class="m-0 font-weight-bold text-primary">Edit Data Kamar</h2>
        </div>
        <div class="card-body">
            <form action="{{ route('kamar.update', $kamar->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-3">
                    <label for="komplek_id" class="form-label">Komplek</label>
                    <select class="form-control @error('komplek_id') is-invalid @enderror"
                        id="komplek_id" name="komplek_id" required>
                        <option value="">Pilih Komplek</option>
                        @foreach($komplek as $g)
                            <option value="{{ $g->id }}" 
                                {{ old('komplek_id', $kamar->komplek_id) == $g->id ? 'selected' : '' }}>
                                {{ $g->nama_komplek }}
                            </option>
                        @endforeach
                    </select>
                    @error('komplek_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="nama_kamar" class="form-label">Nama Kamar</label>
                    <input type="text" class="form-control @error('nama_kamar') is-invalid @enderror" 
                        id="nama_kamar" name="nama_kamar" value="{{ old('nama_kamar', $kamar->nama_kamar) }}" 
                        required>
                    @error('nama_kamar')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('kamar.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                    <button type="submit" class="btn btn-primary">
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
        // Auto-capitalize input kamar
        $('#nama_kamar').on('input', function() {
            $(this).val(function(_, val) {
                return val.toUpperCase();
            });
        });
    });
</script>
@endpush 