@extends('layouts.app')

@section('title', 'Kantin - Transaksi')

@section('content')
<!-- Add Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Add Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
<!-- Add HTML5 QR Code Scanner -->
<script src="https://unpkg.com/html5-qrcode"></script>

<style>
.input-disabled {
    background-color: #fff !important;
    opacity: 1 !important;
}

.table-container {
    margin-bottom: 1rem;
}

.santri-info {
    background-color: #f8f9fa;
    padding: 15px;
    border-radius: 8px;
    margin-top: 15px;
}

.santri-info h5 {
    margin-bottom: 10px;
    color: #333;
}

.santri-info p {
    margin-bottom: 5px;
    color: #666;
}

.form-group {
    margin-bottom: 1rem;
}

.form-group label {
    font-weight: 500;
    margin-bottom: 0.5rem;
}

.content-wrapper {
    min-height: calc(100vh - 100px);
    display: flex;
    align-items: flex-start;
    padding-top: 0;
}

.form-card {
    max-width: 400px;
    width: 100%;
    margin: 0 auto;
}

/* Override margin dari container fluid di app.blade.php */
.container-fluid.py-4 {
    padding-top: 0 !important;
}

/* Override margin dari page-header di app.blade.php */
.page-header {
    margin-bottom: 0 !important;
    padding: 0.5rem 0 !important;
}

#reader {
    width: 100%;
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
</style>

<div class="container">
    <div class="content-wrapper">
        <div class="form-card">
            <!-- Form Transaksi -->
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="form-group">
                        <label for="hargaSatuan">Harga Satuan</label>
                        <input type="number" class="form-control" id="hargaSatuan" placeholder="Masukkan harga">
                    </div>
                    <div class="form-group">
                        <label for="jumlah">Jumlah</label>
                        <input type="number" class="form-control" id="jumlah" value="1" min="1">
                    </div>
                    <div class="form-group mb-0">
                        <label for="total">Total</label>
                        <input type="text" class="form-control" id="total" readonly>
                    </div>
                </div>
            </div>

            <!-- Tombol Scan dan Informasi Santri -->
            <div class="card shadow-sm mt-3">
                <div class="card-body">
                    <button type="button" class="btn btn-warning w-100 mb-3" id="scanBtn">
                        <i class="bi bi-upc-scan"></i> Scan Kartu
                    </button>

                    <div id="santriInfo" class="santri-info" style="display: none;">
                        <h5>Informasi Santri</h5>
                        <p>Nama Santri: <span id="namaSantri">-</span></p>
                        <p>Kelas: <span id="kelasSantri">-</span></p>
                        <p>Saldo Belanja: <span id="saldoBelanja">Rp 0</span></p>
                    </div>

                    <button type="button" class="btn btn-success w-100 mt-3" id="bayarBtn" disabled>
                        <i class="bi bi-cash-coin"></i> Bayar
                    </button>
                </div>
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
    const hargaSatuanInput = document.getElementById('hargaSatuan');
    const jumlahInput = document.getElementById('jumlah');
    const totalInput = document.getElementById('total');
    const bayarBtn = document.getElementById('bayarBtn');
    const scanBtn = document.getElementById('scanBtn');
    const santriInfo = document.getElementById('santriInfo');
    const scannerContainer = document.getElementById('scannerContainer');
    const closeScanner = document.getElementById('closeScanner');
    let selectedSantriId = null;
    let html5QrcodeScanner = null;
    
    function formatRupiah(number) {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0,
            maximumFractionDigits: 0
        }).format(number);
    }
    
    function hitungTotal() {
        const harga = parseFloat(hargaSatuanInput.value) || 0;
        const jumlah = parseFloat(jumlahInput.value) || 0;
        const total = harga * jumlah;
        totalInput.value = formatRupiah(total);
        bayarBtn.disabled = total === 0 || !selectedSantriId;
    }
    
    function updateSantriInfo(data) {
        selectedSantriId = data.id;
        document.getElementById('namaSantri').textContent = data.nama;
        document.getElementById('kelasSantri').textContent = data.tingkatan;
        santriInfo.style.display = 'block';
        
        // Ambil data saldo terbaru
        fetch(`/api/santri/${data.id}/saldo`)
            .then(response => response.json())
            .then(data => {
                const saldoBelanja = parseFloat(data.saldo_belanja);
                document.getElementById('saldoBelanja').textContent = formatRupiah(saldoBelanja);
                hitungTotal(); // Update status tombol bayar

                // Cek apakah total sudah diisi
                const total = parseFloat(totalInput.value.replace(/[^\d]/g, ''));
                if (total > 0) {
                    // Cek apakah saldo mencukupi
                    if (saldoBelanja >= total) {
                        // Lakukan pembayaran otomatis
                        prosesPembayaran(total);
                    } else {
                        alert('Saldo belanja tidak mencukupi untuk melakukan pembayaran');
                    }
                }
            });
    }

    function prosesPembayaran(total) {
        // Kirim data pembayaran
        fetch('/kantin/bayar', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                santri_id: selectedSantriId,
                total: total,
                items: [{
                    harga_satuan: parseFloat(hargaSatuanInput.value),
                    jumlah: parseFloat(jumlahInput.value),
                    sub_total: total
                }]
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Pembayaran berhasil!');
                // Update saldo yang ditampilkan
                document.getElementById('saldoBelanja').textContent = formatRupiah(data.new_saldo_belanja);
                // Reset form
                hargaSatuanInput.value = '';
                jumlahInput.value = '1';
                totalInput.value = '';
                hitungTotal();
            } else {
                alert(data.message || 'Terjadi kesalahan saat memproses pembayaran');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat memproses pembayaran');
        });
    }
    
    function initializeScanner() {
        html5QrcodeScanner = new Html5QrcodeScanner(
            "reader", { fps: 10, qrbox: 250 }
        );
        
        html5QrcodeScanner.render((decodedText, decodedResult) => {
            try {
                const data = JSON.parse(decodedText);
                if (data.type === 'santri_qr') {
                    updateSantriInfo(data);
                    html5QrcodeScanner.clear();
                    scannerContainer.style.display = 'none';
                }
            } catch (e) {
                console.error('Invalid QR Code format');
            }
        });
    }
    
    hargaSatuanInput.addEventListener('input', hitungTotal);
    jumlahInput.addEventListener('input', hitungTotal);
    
    scanBtn.addEventListener('click', function() {
        scannerContainer.style.display = 'block';
        initializeScanner();
    });
    
    closeScanner.addEventListener('click', function() {
        if (html5QrcodeScanner) {
            html5QrcodeScanner.clear();
        }
        scannerContainer.style.display = 'none';
    });
    
    bayarBtn.addEventListener('click', function() {
        const total = parseFloat(totalInput.value.replace(/[^\d]/g, ''));
        if (!total || total <= 0) {
            alert('Masukkan jumlah pembayaran yang valid');
            return;
        }
        if (!selectedSantriId) {
            alert('Silakan scan kartu santri terlebih dahulu');
            return;
        }
        
        prosesPembayaran(total);
    });
});
</script>
@endsection 