@extends('layouts.app')

@section('title', 'Koperasi - Kalkulator')

@section('content')
<!-- Add CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">
<!-- Add Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Add Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
<!-- Add HTML5 QR Code Scanner -->
<script src="https://unpkg.com/html5-qrcode"></script>
<!-- Add SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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

.santri-info {
    background-color: #f8f9fa;
    padding: 15px;
    border-radius: 8px;
    margin-top: 10px;
    margin-bottom: 10px;
    display: none;
}

.santri-info h5 {
    margin-bottom: 10px;
    color: #333;
}

.santri-info p {
    margin-bottom: 5px;
    color: #666;
}

.scanner-container {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.9);
    z-index: 9999;
    padding: 20px;
}

.scanner-content {
    background: white;
    max-width: 500px;
    width: 90%;
    margin: 20px auto;
    padding: 20px;
    border-radius: 8px;
    position: relative;
}

.close-scanner {
    position: absolute;
    top: 10px;
    right: 10px;
    background: none;
    border: none;
    font-size: 1.5rem;
    cursor: pointer;
    color: #666;
}

#reader {
    width: 100%;
    max-width: 100%;
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

/* Responsif styles */
@media (max-width: 576px) {
    .scanner-content {
        width: 95%;
        margin: 10px auto;
        padding: 15px;
    }
    
    #reader {
        width: 100% !important;
        height: auto !important;
    }
}
</style>

<div class="container-fluid">
    <!-- Tabel Transaksi (Panel Kiri) -->
    <div class="table-container">
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
                    <button type="button" class="btn btn-warning mt-3 w-100" id="scanBtn">
                        <i class="bi bi-upc-scan me-2"></i>Scan Kartu
                    </button>
                </div>
            </div>
        </div>

        <!-- Informasi Santri dari QR Code -->
        <div id="santriInfo" class="santri-info mt-3">
            <h5>Informasi Santri</h5>
            <p>Nama Santri: <span id="namaSantri">-</span></p>
            <p>Kelas: <span id="kelasSantri">-</span></p>
            <p>Saldo Belanja: <span id="saldoBelanja">Rp 0</span></p>
            <button type="button" class="btn btn-success w-100 mt-3" id="bayarBtn" disabled>
                <i class="bi bi-cash-coin me-2"></i>Bayar
            </button>
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

<!-- Scanner Container -->
<div class="scanner-container" id="scannerContainer">
    <div class="scanner-content">
        <button type="button" class="close-scanner" id="closeScanner">&times;</button>
        <h5 class="mb-3">Scan QR Code Santri</h5>
        <div id="reader"></div>
    </div>
</div>

<!-- Add jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Add Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let activeInput = document.getElementById('hargaSatuan');
    const hargaSatuanInput = document.getElementById('hargaSatuan');
    const jumlahInput = document.getElementById('jumlah');
    const calculatorForm = document.getElementById('calculatorForm');
    const transaksiTableBody = document.getElementById('transaksiTableBody');
    const grandTotalElement = document.getElementById('grandTotal');
    const saldoDisplay = document.getElementById('saldoBelanja');
    const bayarBtn = document.getElementById('bayarBtn');
    const scanBtn = document.getElementById('scanBtn');
    const scannerContainer = document.getElementById('scannerContainer');
    const closeScanner = document.getElementById('closeScanner');
    const santriInfo = document.getElementById('santriInfo');
    const namaSantri = document.getElementById('namaSantri');
    const kelasSantri = document.getElementById('kelasSantri');
    
    let transaksiData = [];
    let selectedSantriId = null;
    let currentSaldoBelanja = 0;
    let html5QrcodeScanner = null;
    
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
        const grandTotal = transaksiData.reduce((total, item) => total + item.total, 0);
        grandTotalElement.textContent = formatRupiah(grandTotal);
        bayarBtn.disabled = grandTotal === 0 || !selectedSantriId;
    }
    
    // Fungsi untuk memperbarui informasi santri dari QR Code
    function updateSantriInfo(data) {
        console.log("Data santri:", data);
        
        try {
            // Periksa apakah data adalah objek santri langsung atau ada dalam properti santri
            let santriData = data;
            if (data.santri) {
                santriData = data.santri;
            }
            
            // Simpan ID santri untuk digunakan dalam pembayaran
            selectedSantriId = santriData.id;
            
            console.log("ID Santri yang digunakan:", selectedSantriId);
            
            if (!selectedSantriId) {
                throw new Error('ID Santri tidak valid');
            }
            
            // Tampilkan informasi santri
            santriInfo.style.display = 'block';
            namaSantri.textContent = santriData.nama || 'Tidak diketahui';
            kelasSantri.textContent = santriData.kelas ? santriData.kelas.nama : (santriData.tingkatan || 'Tidak ada kelas');
            
            // Ambil saldo terbaru
            fetch(`/api/santri/${selectedSantriId}/saldo`, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(err => {
                        throw new Error(err.message || 'Gagal mendapatkan saldo');
                    });
                }
                return response.json();
            })
            .then(response => {
                console.log("Respons saldo:", response);
                if (response.error) {
                    throw new Error(response.message || 'Gagal mendapatkan saldo');
                }
                currentSaldoBelanja = response.saldo_belanja;
                saldoDisplay.textContent = formatRupiah(response.saldo_belanja);
                updateGrandTotal();
                console.log("Saldo berhasil diperbarui:", currentSaldoBelanja);
            })
            .catch(error => {
                console.error('Error fetching saldo:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal Mendapatkan Saldo',
                    text: error.message || 'Terjadi kesalahan saat mengambil data saldo'
                });
            });
        } catch (error) {
            console.error('Error updating santri info:', error);
            santriInfo.style.display = 'none';
            namaSantri.textContent = '-';
            kelasSantri.textContent = '-';
            saldoDisplay.textContent = 'Rp 0';
            selectedSantriId = null;
            updateGrandTotal();
            
            Swal.fire({
                icon: 'error',
                title: 'Data Tidak Valid',
                text: error.message || 'Terjadi kesalahan saat memproses data santri'
            });
        }
    }
    
    // Fungsi untuk inisialisasi scanner
    function initializeScanner() {
        html5QrcodeScanner = new Html5QrcodeScanner(
            "reader", { fps: 10, qrbox: 250 }
        );
        
        html5QrcodeScanner.render((decodedText, decodedResult) => {
            try {
                console.log("Decoded QR:", decodedText); // Debug: Log raw QR data
                const data = JSON.parse(decodedText);
                console.log("Parsed QR data:", data); // Debug: Log parsed data
                
                // Periksa tipe data QR
                if (data.type === 'santri_qr' || data.type === 'santri') {
                    updateSantriInfo(data);
                    html5QrcodeScanner.clear();
                    scannerContainer.style.display = 'none';
                } else if (data.id && (data.nama || data.name)) {
                    // Jika tidak ada type tapi memiliki id dan nama, anggap sebagai data santri
                    updateSantriInfo(data);
                    html5QrcodeScanner.clear();
                    scannerContainer.style.display = 'none';
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'QR Code Tidak Valid',
                        text: 'QR Code bukan milik santri'
                    });
                }
            } catch (error) {
                console.error('Error parsing QR code:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'QR Code Tidak Valid',
                    text: 'Format QR Code tidak sesuai: ' + error.message
                });
            }
        });
    }
    
    // Event listener untuk tombol scan
    scanBtn.addEventListener('click', function() {
        scannerContainer.style.display = 'block';
        initializeScanner();
    });
    
    // Event listener untuk tombol close scanner
    closeScanner.addEventListener('click', function() {
        if (html5QrcodeScanner) {
            html5QrcodeScanner.clear();
        }
        scannerContainer.style.display = 'none';
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
        transaksiData.push({ 
            nama: 'Item ' + (transaksiData.length + 1),
            harga: hargaSatuan,
            kuantitas: jumlah,
            total: subTotal
        });
        
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
        if (!selectedSantriId) {
            Swal.fire({
                icon: 'warning',
                title: 'Perhatian',
                text: 'Scan kartu santri terlebih dahulu'
            });
            return;
        }

        let grandTotal = transaksiData.reduce((total, item) => total + item.total, 0);
        
        if (grandTotal <= 0) {
            Swal.fire({
                icon: 'warning',
                title: 'Perhatian',
                text: 'Tidak ada transaksi untuk dibayar'
            });
            return;
        }

        if (currentSaldoBelanja < grandTotal) {
            Swal.fire({
                icon: 'error',
                title: 'Saldo Tidak Mencukupi',
                text: `Saldo belanja (${formatRupiah(currentSaldoBelanja)}) tidak mencukupi untuk pembayaran sebesar ${formatRupiah(grandTotal)}`
            });
            return;
        }

        // Tampilkan loading
        bayarBtn.disabled = true;
        bayarBtn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Memproses...';

        // Siapkan data untuk dikirim ke server
        const items = transaksiData.map(item => ({
            nama: item.nama,
            harga: item.harga,
            kuantitas: item.kuantitas,
            total: item.total
        }));

        // Log data yang akan dikirim untuk debugging
        console.log('ID Santri (raw):', selectedSantriId);
        console.log('Tipe data ID Santri:', typeof selectedSantriId);
        
        const paymentData = {
            santri_id: selectedSantriId,
            total: grandTotal,
            items: items
        };

        console.log('Data pembayaran yang akan dikirim:', paymentData);
        console.log('Data pembayaran (JSON):', JSON.stringify(paymentData));

        // Kirim data pembayaran ke server
        fetch('/koperasi/bayar', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(paymentData)
        })
        .then(response => {
            console.log('Status response:', response.status);
            console.log('Response headers:', [...response.headers.entries()]);
            
            return response.json().then(data => {
                console.log('Response body:', data);
                if (!response.ok) {
                    throw new Error(data.message || 'Terjadi kesalahan saat memproses pembayaran');
                }
                return data;
            }).catch(err => {
                console.error('Error parsing JSON:', err);
                if (!response.ok) {
                    throw new Error('Terjadi kesalahan pada server. Status: ' + response.status);
                }
                throw err;
            });
        })
        .then(data => {
            console.log('Response data:', data);
            if (data.success) {
                // Update saldo di tampilan
                currentSaldoBelanja = data.new_saldo_belanja;
                
                // Update tampilan saldo
                saldoDisplay.textContent = formatRupiah(currentSaldoBelanja);
                
                // Reset form dan tabel
                transaksiData = [];
                transaksiTableBody.innerHTML = '';
                grandTotalElement.textContent = 'Rp 0';
                
                Swal.fire({
                    icon: 'success',
                    title: 'Pembayaran Berhasil',
                    text: 'Saldo belanja baru: ' + formatRupiah(currentSaldoBelanja)
                });
            } else {
                throw new Error(data.message || 'Terjadi kesalahan saat memproses pembayaran');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Pembayaran Gagal',
                text: error.message || 'Terjadi kesalahan saat memproses pembayaran'
            });
        })
        .finally(() => {
            // Kembalikan tombol ke keadaan semula
            bayarBtn.disabled = (transaksiData.length === 0);
            bayarBtn.innerHTML = '<i class="bi bi-cash-coin me-2"></i>Bayar';
        });
    });
});
</script>
@endsection
