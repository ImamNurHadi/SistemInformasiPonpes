@extends('layouts.app')

@section('title', 'Top Up Saldo')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Top Up Saldo Santri</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('topup.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="santri_id" class="form-label">Pilih Santri</label>
                            <select name="santri_id" id="santri_id" class="form-select @error('santri_id') is-invalid @enderror" required>
                                <option value="">Pilih Santri</option>
                                @foreach($santri as $s)
                                    <option value="{{ $s->id }}">{{ $s->nis }} - {{ $s->nama }}</option>
                                @endforeach
                            </select>
                            @error('santri_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="jumlah" class="form-label">Jumlah Top Up</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" class="form-control @error('jumlah') is-invalid @enderror" 
                                       name="jumlah" id="jumlah" required min="0" step="1000">
                            </div>
                            @error('jumlah')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Top Up Saldo</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 