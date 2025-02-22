@extends('layouts.app')

@section('title', 'Tarik Tunai')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Tarik Tunai</h3>
                </div>
                <div class="card-body">
                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('tarik-tunai.store') }}" method="POST" id="formTarikTunai">
                        @csrf
                        <div class="mb-3">
                            <label for="santri_id" class="form-label">Pilih Santri</label>
                            <select name="santri_id" id="santri_id" class="form-select @error('santri_id') is-invalid @enderror" required>
                                <option value="">Pilih Santri</option>
                                @foreach($santri as $s)
                                    <option value="{{ $s->id }}" {{ old('santri_id') == $s->id ? 'selected' : '' }}>
                                        {{ $s->nis }} - {{ $s->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('santri_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="jumlah" class="form-label">Jumlah Penarikan</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="text" class="form-control @error('jumlah') is-invalid @enderror" 
                                       name="jumlah" id="jumlah" required
                                       value="{{ old('jumlah', '1000') }}"
                                       inputmode="numeric"
                                       pattern="[0-9]*">
                            </div>
                            @error('jumlah')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Tarik Tunai</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        // Initialize select2 for better dropdown experience
        $('#santri_id').select2({
            theme: 'bootstrap-5',
            placeholder: 'Pilih Santri',
            allowClear: true
        });

        // Handle jumlah input
        const jumlahInput = document.getElementById('jumlah');
        
        // Format number with thousand separator
        function formatNumber(number) {
            return new Intl.NumberFormat('id-ID').format(number);
        }

        // Remove non-numeric characters and format
        jumlahInput.addEventListener('input', function(e) {
            let value = this.value.replace(/\D/g, '');
            
            // Ensure the value is at least 1000
            if (value && value < 1000) {
                value = 1000;
            }
            
            // Format the number
            if (value) {
                this.value = formatNumber(value);
            }
        });

        // Validate before form submission
        $('#formTarikTunai').on('submit', function(e) {
            const value = parseInt(jumlahInput.value.replace(/\D/g, ''));
            
            if (value < 1000) {
                e.preventDefault();
                alert('Jumlah minimal adalah Rp 1.000');
                return false;
            }
            
            if (value % 500 !== 0) {
                e.preventDefault();
                alert('Jumlah harus kelipatan Rp 500');
                return false;
            }

            // Remove formatting before submit
            jumlahInput.value = value;
        });
    });
</script>
@endpush
@endsection 