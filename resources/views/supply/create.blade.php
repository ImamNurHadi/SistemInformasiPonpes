@extends('layouts.app')

@section('title', 'Tambah Supply')

@push('styles')
<style>
    .price-info {
        font-size: 1.1rem;
        padding: 10px 15px;
        background-color: #f8f9fc;
        border-radius: 5px;
        border-left: 4px solid #4e73df;
        margin-top: 20px;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tambah Supply</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Form Tambah Supply</h6>
        </div>
        <div class="card-body">
            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('supply.store') }}" method="POST" id="supplyForm">
                @csrf
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="nama_barang" class="form-label">Nama Barang</label>
                        <input type="text" class="form-control @error('nama_barang') is-invalid @enderror" 
                            id="nama_barang" name="nama_barang" value="{{ old('nama_barang') }}" 
                            placeholder="Masukkan Nama Barang" required>
                        @error('nama_barang')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-3 mb-3">
                        <label for="stok" class="form-label">Stok</label>
                        <input type="number" class="form-control @error('stok') is-invalid @enderror" 
                            id="stok" name="stok" value="{{ old('stok') }}" 
                            placeholder="Jumlah Stok" required min="1" onchange="hitungTotal()">
                        @error('stok')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-3 mb-3">
                        <label for="harga_satuan" class="form-label">Harga Satuan (Rp)</label>
                        <input type="number" class="form-control @error('harga_satuan') is-invalid @enderror" 
                            id="harga_satuan" name="harga_satuan" value="{{ old('harga_satuan') }}" 
                            placeholder="Harga Satuan" required min="0" onchange="hitungTotal()">
                        @error('harga_satuan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="kategori" class="form-label">Kategori</label>
                        <select class="form-control @error('kategori') is-invalid @enderror" 
                            id="kategori" name="kategori">
                            <option value="Umum" {{ old('kategori') == 'Umum' ? 'selected' : '' }}>Umum</option>
                            <option value="Makanan" {{ old('kategori') == 'Makanan' ? 'selected' : '' }}>Makanan</option>
                            <option value="Minuman" {{ old('kategori') == 'Minuman' ? 'selected' : '' }}>Minuman</option>
                            <option value="Alat Tulis" {{ old('kategori') == 'Alat Tulis' ? 'selected' : '' }}>Alat Tulis</option>
                            <option value="Kebersihan" {{ old('kategori') == 'Kebersihan' ? 'selected' : '' }}>Kebersihan</option>
                            <option value="Lainnya" {{ old('kategori') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                        </select>
                        @error('kategori')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="supplier_id" class="form-label">Supplier</label>
                        <select class="form-control @error('supplier_id') is-invalid @enderror" 
                            id="supplier_id" name="supplier_id" required>
                            <option value="">Pilih Supplier</option>
                            @foreach($suppliers as $supplier)
                                <option value="{{ $supplier->id }}" {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>
                                    {{ $supplier->nama_supplier }} - Saldo: Rp {{ number_format($supplier->saldo_belanja, 0, ',', '.') }}
                                </option>
                            @endforeach
                        </select>
                        @error('supplier_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="data_koperasi_id" class="form-label">Koperasi Tujuan</label>
                        <select class="form-control @error('data_koperasi_id') is-invalid @enderror" 
                            id="data_koperasi_id" name="data_koperasi_id" required onchange="updateSaldoInfo()">
                            <option value="">Pilih Koperasi</option>
                            @foreach($dataKoperasi as $koperasi)
                                <option value="{{ $koperasi->id }}" 
                                        data-saldo="{{ $koperasi->saldo_belanja }}"
                                        {{ old('data_koperasi_id') == $koperasi->id ? 'selected' : '' }}>
                                    {{ $koperasi->nama_koperasi }} - Saldo: Rp {{ number_format($koperasi->saldo_belanja, 0, ',', '.') }}
                                </option>
                            @endforeach
                        </select>
                        @error('data_koperasi_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="price-info">
                    <div class="row">
                        <div class="col-md-4">
                            <strong>Total Harga:</strong> <span id="totalHarga">Rp 0</span>
                        </div>
                        <div class="col-md-4">
                            <strong>Saldo Koperasi:</strong> <span id="saldoKoperasi">Rp 0</span>
                        </div>
                        <div class="col-md-4">
                            <strong>Sisa Saldo:</strong> <span id="sisaSaldo">Rp 0</span>
                        </div>
                    </div>
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                    <button type="submit" class="btn btn-primary me-md-2" id="btnSubmit">Simpan</button>
                    <a href="{{ route('supply.index') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Format angka ke format rupiah
    function formatRupiah(angka) {
        return 'Rp ' + new Intl.NumberFormat('id-ID').format(angka);
    }
    
    // Hitung total harga
    function hitungTotal() {
        const stok = parseFloat(document.getElementById('stok').value) || 0;
        const hargaSatuan = parseFloat(document.getElementById('harga_satuan').value) || 0;
        const totalHarga = stok * hargaSatuan;
        
        document.getElementById('totalHarga').textContent = formatRupiah(totalHarga);
        
        // Update sisa saldo
        updateSisaSaldo(totalHarga);
    }
    
    // Update informasi saldo koperasi
    function updateSaldoInfo() {
        const selectElement = document.getElementById('data_koperasi_id');
        const selectedOption = selectElement.options[selectElement.selectedIndex];
        let saldo = 0;
        
        if (selectedOption && selectedOption.value) {
            saldo = parseFloat(selectedOption.getAttribute('data-saldo')) || 0;
        }
        
        document.getElementById('saldoKoperasi').textContent = formatRupiah(saldo);
        
        // Update sisa saldo
        const stok = parseFloat(document.getElementById('stok').value) || 0;
        const hargaSatuan = parseFloat(document.getElementById('harga_satuan').value) || 0;
        const totalHarga = stok * hargaSatuan;
        
        updateSisaSaldo(totalHarga);
    }
    
    // Update sisa saldo
    function updateSisaSaldo(totalHarga) {
        const selectElement = document.getElementById('data_koperasi_id');
        const selectedOption = selectElement.options[selectElement.selectedIndex];
        let saldo = 0;
        
        if (selectedOption && selectedOption.value) {
            saldo = parseFloat(selectedOption.getAttribute('data-saldo')) || 0;
        }
        
        const sisaSaldo = saldo - totalHarga;
        document.getElementById('sisaSaldo').textContent = formatRupiah(sisaSaldo);
        
        // Disable submit button if sisa saldo negatif
        const btnSubmit = document.getElementById('btnSubmit');
        if (sisaSaldo < 0) {
            btnSubmit.disabled = true;
            btnSubmit.classList.add('btn-secondary');
            btnSubmit.classList.remove('btn-primary');
        } else {
            btnSubmit.disabled = false;
            btnSubmit.classList.add('btn-primary');
            btnSubmit.classList.remove('btn-secondary');
        }
    }
    
    // Initial calculation
    window.onload = function() {
        updateSaldoInfo();
        hitungTotal();
    };
</script>
@endpush 