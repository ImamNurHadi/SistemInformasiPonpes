@extends('layouts.app')

@section('title', 'Edit Ruang Kelas')

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h2 class="m-0 font-weight-bold text-primary">Edit Ruang Kelas</h2>
        </div>
        <div class="card-body">
            <form action="{{ route('ruang-kelas.update', $ruangKelas->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-3">
                    <label for="nama_ruang_kelas" class="form-label">Nama Ruang Kelas</label>
                    <input type="text" class="form-control @error('nama_ruang_kelas') is-invalid @enderror" 
                        id="nama_ruang_kelas" name="nama_ruang_kelas" value="{{ old('nama_ruang_kelas', $ruangKelas->nama_ruang_kelas) }}" 
                        required>
                    @error('nama_ruang_kelas')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="keterangan" class="form-label">Keterangan</label>
                    <textarea class="form-control @error('keterangan') is-invalid @enderror" 
                        id="keterangan" name="keterangan" rows="3">{{ old('keterangan', $ruangKelas->keterangan) }}</textarea>
                    @error('keterangan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('ruang-kelas.index') }}" class="btn btn-secondary">
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
        // Auto-capitalize input ruang kelas
        $('#nama_ruang_kelas').on('input', function() {
            $(this).val(function(_, val) {
                return val.toUpperCase();
            });
        });
    });
</script>
@endpush 