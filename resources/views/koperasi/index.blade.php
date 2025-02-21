@extends('layouts.app')

@section('title', 'Koperasi - Kalkulator')

@section('content')
<!-- Add Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Add Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
<!-- Add Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<style>
.numpad-button {
    width: 100%;
    padding: 10px;
    margin: 5px 0;
    background-color: #f8f9fa;
    border: 1px solid #dee2e6;
    border-radius: 5px;
    font-size: 1.1em;
}

.numpad-button:hover {
    background-color: #e9ecef;
}

.numpad-container {
    background: white;
    padding: 15px;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    margin-top: 10px;
}

.input-disabled {
    background-color: #fff !important;
    opacity: 1 !important;
}

.calculator-container {
    position: fixed;
    right: 1rem;
    top: 6rem;
    width: 350px;
    z-index: 1000;
}

.table-container {
    margin-right: 380px;
}

@media (max-width: 992px) {
    .calculator-container {
        position: static;
        width: 100%;
        margin-bottom: 1rem;
    }
    
    .table-container {
        margin-right: 0;
    }
}
</style>

<div class="container-fluid">
    <!-- Tabel Transaksi (Panel Kiri) -->
    <div class="table-container">
        <!-- Form Pemilihan Santri -->
        <div class="card mb-4">
            <div class="card-body">
                <form id="pembayaranForm">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="santri_id" class="form-label">Pilih Santri</label>
                            <select class="form-select select2" id="santri_id" name="santri_id" required>
                                <option value="">Pilih Santri</option>
                                @foreach($santri as $s)
                                    <option value="{{ $s->id }}" data-saldo="{{ $s->saldo }}">{{ $s->nis }} - {{ $s->nama }} (Saldo: Rp {{ number_format($s->saldo, 0, ',', '.') }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Saldo Tersedia</label>
                            <div class="form-control" id="saldoDisplay">Rp 0</div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card bg-success text-white">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table text-white mb-4">
                        <thead>
                            <tr>
                                <th>Harga Satuan</th>
                                <th>Jumlah (Qty)</th>
                                <th>Sub Total</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="transaksiTableBody">
                            <!-- Data transaksi akan ditambahkan di sini -->
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-between align-items-center bg-light text-dark p-2 rounded">
                        <h5 class="mb-0">Grand Total</h5>
                        <h5 class="mb-0" id="grandTotal">Rp 0</h5>
                    </div>
                    <button type="button" class="btn btn-light mt-3 w-100" id="bayarBtn" disabled>
                        <i class="bi bi-cash-coin me-2"></i>Bayar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Kalkulator (Panel Kanan) -->
    <div class="calculator-container">
        <div class="card">
            <div class="card-body">
                <form id="calculatorForm">
                    <div class="mb-3">
                        <label for="hargaSatuan" class="form-label">Harga Satuan</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="text" class="form-control input-disabled" id="hargaSatuan" name="hargaSatuan" required readonly>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="jumlah" class="form-label">Jumlah</label>
                        <input type="text" class="form-control input-disabled" id="jumlah" name="jumlah" required readonly value="1">
                    </div>

                    <!-- Numpad Container -->
                    <div class="numpad-container">
                        <div class="row g-2">
                            <div class="col-4"><button type="button" class="numpad-button" data-value="1">1</button></div>
                            <div class="col-4"><button type="button" class="numpad-button" data-value="2">2</button></div>
                            <div class="col-4"><button type="button" class="numpad-button" data-value="3">3</button></div>
                            <div class="col-4"><button type="button" class="numpad-button" data-value="4">4</button></div>
                            <div class="col-4"><button type="button" class="numpad-button" data-value="5">5</button></div>
                            <div class="col-4"><button type="button" class="numpad-button" data-value="6">6</button></div>
                            <div class="col-4"><button type="button" class="numpad-button" data-value="7">7</button></div>
                            <div class="col-4"><button type="button" class="numpad-button" data-value="8">8</button></div>
                            <div class="col-4"><button type="button" class="numpad-button" data-value="9">9</button></div>
                            <div class="col-4"><button type="button" class="numpad-button" data-value="0">0</button></div>
                            <div class="col-4"><button type="button" class="numpad-button" data-value="00">00</button></div>
                            <div class="col-4"><button type="button" class="numpad-button" data-value="000">000</button></div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-6">
                                <button type="button" class="btn btn-warning w-100" id="clearBtn">
                                    Clear
                                </button>
                            </div>
                            <div class="col-6">
                                <button type="button" class="btn btn-danger w-100" id="backspaceBtn">
                                    <i class="bi bi-backspace"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="d-grid mt-3">
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-plus-circle me-1"></i> Tambah ke Tabel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Add jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Add Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Add Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let activeInput = document.getElementById('hargaSatuan');
    const hargaSatuanInput = document.getElementById('hargaSatuan');
    const jumlahInput = document.getElementById('jumlah');
    const calculatorForm = document.getElementById('calculatorForm');
    const transaksiTableBody = document.getElementById('transaksiTableBody');
    const grandTotalElement = document.getElementById('grandTotal');
    const santriSelect = document.getElementById('santri_id');
    const saldoDisplay = document.getElementById('saldoDisplay');
    const bayarBtn = document.getElementById('bayarBtn');
    let transaksiData = [];
    
    hargaSatuanInput.focus();
    
    function formatRupiah(number) {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0,
            maximumFractionDigits: 0
        }).format(number);
    }
    
    function updateGrandTotal() {
        const grandTotal = transaksiData.reduce((total, item) => total + item.subTotal, 0);
        grandTotalElement.textContent = formatRupiah(grandTotal);
        bayarBtn.disabled = grandTotal === 0;
    }
    
    santriSelect.addEventListener('change', function() {
        let selectedOption = this.options[this.selectedIndex];
        let saldo = selectedOption.getAttribute('data-saldo');
        saldoDisplay.textContent = saldo ? formatRupiah(parseInt(saldo)) : 'Rp 0';
    });
    
    hargaSatuanInput.addEventListener('click', () => activeInput = hargaSatuanInput);
    jumlahInput.addEventListener('click', () => activeInput = jumlahInput);
    
    document.querySelectorAll('.numpad-button').forEach(button => {
        button.addEventListener('click', function() {
            const value = this.dataset.value;
            if (activeInput) {
                activeInput.value = (activeInput.value || '') + value;
            }
        });
    });
    
    document.getElementById('clearBtn').addEventListener('click', function() {
        if (activeInput) activeInput.value = '';
    });
    
    document.getElementById('backspaceBtn').addEventListener('click', function() {
        if (activeInput) activeInput.value = activeInput.value.slice(0, -1);
    });
    
    hargaSatuanInput.addEventListener('input', function() {
        if (this.value.length > 0) {
            jumlahInput.focus();
            activeInput = jumlahInput;
        }
    });
    
    calculatorForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const hargaSatuan = parseInt(hargaSatuanInput.value.replace(/\D/g, ''));
        const jumlah = parseInt(jumlahInput.value);
        
        if (isNaN(hargaSatuan) || isNaN(jumlah) || hargaSatuan <= 0 || jumlah <= 0) {
            alert('Harap masukkan harga satuan dan jumlah yang valid');
            return;
        }
        
        const subTotal = hargaSatuan * jumlah;
        
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td>${formatRupiah(hargaSatuan)}</td>
            <td>${jumlah}</td>
            <td>${formatRupiah(subTotal)}</td>
            <td>
                <button type="button" class="btn btn-danger btn-sm delete-btn">
                    <i class="bi bi-trash"></i>
                </button>
            </td>
        `;
        
        transaksiTableBody.appendChild(tr);
        transaksiData.push({ hargaSatuan, jumlah, subTotal });
        
        updateGrandTotal();
        
        hargaSatuanInput.value = '';
        jumlahInput.value = '1';
        hargaSatuanInput.focus();
        activeInput = hargaSatuanInput;
    });
    
    transaksiTableBody.addEventListener('click', function(e) {
        if (e.target.closest('.delete-btn')) {
            const row = e.target.closest('tr');
            const index = Array.from(transaksiTableBody.children).indexOf(row);
            
            transaksiData.splice(index, 1);
            row.remove();
            updateGrandTotal();
        }
    });
    
    bayarBtn.addEventListener('click', function() {
        let selectedOption = santriSelect.options[santriSelect.selectedIndex];
        let saldo = parseInt(selectedOption.getAttribute('data-saldo'));
        let grandTotal = transaksiData.reduce((total, item) => total + item.subTotal, 0);
        
        if (saldo >= grandTotal) {
            let newSaldo = saldo - grandTotal;
            selectedOption.setAttribute('data-saldo', newSaldo);
            saldoDisplay.textContent = formatRupiah(newSaldo);
            
            transaksiData = [];
            transaksiTableBody.innerHTML = '';
            grandTotalElement.textContent = 'Rp 0';
            bayarBtn.disabled = true;
            
            alert('Pembayaran berhasil! Saldo baru: ' + formatRupiah(newSaldo));
        } else {
            alert('Saldo tidak mencukupi!');
        }
    });
});

</script>
@endsection