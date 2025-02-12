@extends('layouts.app')

@section('title', 'Pilih Divisi Pengurus')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Pilih Divisi Pengurus</h2>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle me-2"></i>
                        Silakan pilih divisi untuk pengurus <strong>{{ $pengurus->nama }}</strong>
                    </div>

                    <form action="{{ route('pengurus.update-divisi', $pengurus->id) }}" method="POST" id="formPilihDivisi">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label for="divisi_id" class="form-label">Divisi</label>
                            <select class="form-select @error('divisi_id') is-invalid @enderror" id="divisi_id" name="divisi_id" required>
                                <option value="">Pilih Divisi</option>
                                @foreach($divisis as $divisi)
                                    <option value="{{ $divisi->id }}" data-sub-divisi="{{ $divisi->sub_divisi }}">{{ $divisi->nama }}</option>
                                @endforeach
                            </select>
                            @error('divisi_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="sub_divisi" class="form-label">Sub Divisi</label>
                            <select class="form-select @error('sub_divisi') is-invalid @enderror" id="sub_divisi" name="sub_divisi" disabled>
                                <option value="">Pilih Sub Divisi</option>
                            </select>
                            @error('sub_divisi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('pengurus.index') }}" class="btn btn-secondary">Kembali</a>
                            <button type="submit" class="btn btn-primary">Simpan Divisi</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const divisiSelect = document.getElementById('divisi_id');
    const subDivisiSelect = document.getElementById('sub_divisi');

    divisiSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const subDivisiData = selectedOption.getAttribute('data-sub-divisi');
        
        // Reset dan disable sub divisi select
        subDivisiSelect.innerHTML = '<option value="">Pilih Sub Divisi</option>';
        subDivisiSelect.disabled = true;
        
        if (subDivisiData) {
            // Populate sub divisi options
            const subDivisis = subDivisiData.split(',');
            subDivisis.forEach(subDivisi => {
                const option = document.createElement('option');
                option.value = subDivisi.trim();
                option.textContent = subDivisi.trim();
                subDivisiSelect.appendChild(option);
            });
            subDivisiSelect.disabled = false;
        }
    });
});
</script>
@endpush
@endsection 