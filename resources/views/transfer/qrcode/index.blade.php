@extends('layouts.app')

@section('title', 'Transfer Saldo QR Code')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="bi bi-qr-code-scan me-2"></i> Transfer via QR Code</h5>
                </div>
                <div class="card-body p-4">
                    @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                    @endif
                    
                    @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                    @endif
                    
                    <!-- Petunjuk Penggunaan -->
                    <div class="alert alert-info mb-4">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-info-circle-fill me-2 fs-4"></i>
                            <div>
                                <h6 class="mb-1">Cara Transfer Via QR Code:</h6>
                                <ol class="mb-0 ps-3">
                                    <li>Klik tombol "Aktifkan Kamera" di bawah</li>
                                    <li>Pindai QR Code pengguna lain</li>
                                    <li>Masukkan jumlah transfer dan pilih jenis saldo</li>
                                    <li>Konfirmasi transfer untuk menyelesaikan</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Informasi Saldo Saya -->
                    <div class="card mb-4 border-0 shadow-sm">
                        <div class="card-header bg-light">
                            <h6 class="mb-0"><i class="bi bi-wallet2 me-2"></i> Saldo Saya</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                @if(isset($saldo['utama']))
                                <div class="col-md-4 mb-2">
                                    <div class="card bg-primary text-white">
                                        <div class="card-body p-2">
                                            <h6 class="mb-1"><i class="bi bi-cash me-1"></i> Utama</h6>
                                            <h5 class="mb-0">Rp {{ number_format($saldo['utama']) }}</h5>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                
                                @if(isset($saldo['belanja']))
                                <div class="col-md-4 mb-2">
                                    <div class="card bg-success text-white">
                                        <div class="card-body p-2">
                                            <h6 class="mb-1"><i class="bi bi-basket me-1"></i> Belanja</h6>
                                            <h5 class="mb-0">Rp {{ number_format($saldo['belanja']) }}</h5>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                
                                @if(isset($saldo['tabungan']))
                                <div class="col-md-4 mb-2">
                                    <div class="card bg-info text-white">
                                        <div class="card-body p-2">
                                            <h6 class="mb-1"><i class="bi bi-piggy-bank me-1"></i> Tabungan</h6>
                                            <h5 class="mb-0">Rp {{ number_format($saldo['tabungan']) }}</h5>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <!-- Area Scanner QR Code -->
                    <div class="card mb-4 border-0 shadow-sm">
                        <div class="card-header bg-light">
                            <h6 class="mb-0"><i class="bi bi-camera me-2"></i> Pindai QR Code</h6>
                        </div>
                        <div class="card-body text-center p-4">
                            <!-- Area Kamera -->
                            <div id="scanner-area" style="width: 100%; max-width: 350px; height: 350px; margin: 0 auto; border: 2px dashed #ccc; border-radius: 12px; position: relative;">
                                <div id="reader" style="width: 100%; height: 100%; border-radius: 10px; overflow: hidden;"></div>
                                <div id="camera-placeholder" class="d-flex flex-column align-items-center justify-content-center" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background-color: #f8f9fa; border-radius: 10px;">
                                    <i class="bi bi-camera-fill" style="font-size: 4rem; color: #6c757d;"></i>
                                    <p class="mt-2">Klik tombol di bawah untuk mulai memindai</p>
                                </div>
                            </div>
                            
                            <!-- Tombol Kontrol Kamera -->
                            <div class="mt-3">
                                <button id="start-camera" class="btn btn-primary px-4">
                                    <i class="bi bi-camera-video-fill me-2"></i> Aktifkan Kamera
                                </button>
                                <button id="switch-camera" class="btn btn-outline-secondary ms-2 d-none">
                                    <i class="bi bi-arrow-repeat me-1"></i> Ganti Kamera
                                </button>
                            </div>
                            
                            <!-- Status Pemindaian -->
                            <div id="status-container" class="alert alert-light border mt-3 text-start">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-info-circle me-2 fs-5"></i>
                                    <span id="status-message">Klik tombol untuk mulai memindai QR Code</span>
                                </div>
                            </div>
                            
                            <!-- Pesan Error -->
                            <div id="error-message" class="alert alert-danger d-none mt-3 text-start">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
                                    <span id="error-text">Error message will appear here</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Input Transfer -->
<div class="modal fade" id="transferModal" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title"><i class="bi bi-send-fill me-2"></i> Transfer Saldo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="text-center mb-4">
                    <i class="bi bi-person-circle" style="font-size: 3rem; color: #0d6efd;"></i>
                    <h5 class="mt-2 mb-0" id="targetName">Nama Penerima</h5>
                    <p class="text-muted small">Tujuan Transfer</p>
                </div>
                
                <div class="mb-3">
                    <label for="transferAmount" class="form-label fw-medium">Jumlah Transfer</label>
                    <div class="input-group">
                        <span class="input-group-text">Rp</span>
                        <input type="number" class="form-control" id="transferAmount" placeholder="10000" min="1000" required>
                    </div>
                    <div class="form-text">Minimal Rp 1.000</div>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="sourceAccount" class="form-label fw-medium">Dari Saldo</label>
                        <select class="form-select" id="sourceAccount" required>
                            <option value="">-- Pilih Saldo --</option>
                            @if(isset($saldo['utama']))
                            <option value="utama">Utama (Rp {{ number_format($saldo['utama']) }})</option>
                            @endif
                            @if(isset($saldo['belanja']))
                            <option value="belanja">Belanja (Rp {{ number_format($saldo['belanja']) }})</option>
                            @endif
                            @if(isset($saldo['tabungan']))
                            <option value="tabungan">Tabungan (Rp {{ number_format($saldo['tabungan']) }})</option>
                            @endif
                        </select>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label for="targetAccount" class="form-label fw-medium">Ke Saldo</label>
                        <select class="form-select" id="targetAccount" required>
                            <option value="">-- Pilih Saldo --</option>
                            <option value="utama">Saldo Utama</option>
                            <option value="belanja">Saldo Belanja</option>
                            <option value="tabungan">Saldo Tabungan</option>
                        </select>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label for="transferNote" class="form-label fw-medium">Keterangan</label>
                    <input type="text" class="form-control" id="transferNote" placeholder="Opsional">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                <button type="button" id="confirmTransferBtn" class="btn btn-primary">Lanjut</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Konfirmasi Transfer -->
<div class="modal fade" id="confirmModal" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title"><i class="bi bi-exclamation-triangle me-2"></i> Konfirmasi Transfer</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="text-center mb-3">
                    <i class="bi bi-shield-check" style="font-size: 4rem; color: #ffc107;"></i>
                    <h5 class="mt-2">Konfirmasi Detail Transfer</h5>
                    <p class="text-muted">Pastikan informasi di bawah sudah benar</p>
                </div>
                
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-5 text-muted">Penerima:</div>
                            <div class="col-7 fw-bold" id="confirmRecipient">Nama Penerima</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-5 text-muted">Jumlah:</div>
                            <div class="col-7 fw-bold" id="confirmAmount">Rp 0</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-5 text-muted">Dari Saldo:</div>
                            <div class="col-7 fw-bold" id="confirmSource">-</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-5 text-muted">Ke Saldo:</div>
                            <div class="col-7 fw-bold" id="confirmTarget">-</div>
                        </div>
                    </div>
                </div>
                
                <div class="alert alert-warning mt-3">
                    <i class="bi bi-info-circle me-2"></i> Transfer tidak dapat dibatalkan setelah dikonfirmasi.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                <button type="button" id="executeTransferBtn" class="btn btn-warning">
                    <i class="bi bi-check2-circle me-1"></i> Konfirmasi Transfer
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Inisialisasi variabel
        let html5QrCode = null;
        let currentCamera = null;
        let targetUserId = null;
        let targetName = null;
        
        // Elemen DOM
        const reader = document.getElementById('reader');
        const cameraPlaceholder = document.getElementById('camera-placeholder');
        const startButton = document.getElementById('start-camera');
        const switchButton = document.getElementById('switch-camera');
        const statusMessage = document.getElementById('status-message');
        const errorContainer = document.getElementById('error-message');
        const errorText = document.getElementById('error-text');
        
        // Modal
        const transferModal = new bootstrap.Modal(document.getElementById('transferModal'));
        const confirmModal = new bootstrap.Modal(document.getElementById('confirmModal'));
        
        // Event listener untuk tombol aktifkan kamera
        startButton.addEventListener('click', function() {
            initCamera();
        });
        
        // Event listener untuk tombol ganti kamera
        switchButton.addEventListener('click', function() {
            if (html5QrCode && html5QrCode.isScanning) {
                html5QrCode.stop().then(() => {
                    switchCamera();
                }).catch(err => {
                    showError('Gagal mengganti kamera: ' + err.message);
                });
            }
        });
        
        // Inisialisasi kamera
        async function initCamera() {
            try {
                statusMessage.textContent = 'Mengakses kamera...';
                
                // Cek ketersediaan kamera
                const devices = await Html5Qrcode.getCameras();
                
                if (devices && devices.length) {
                    // Tampilkan tombol switch jika kamera > 1
                    if (devices.length > 1) {
                        switchButton.classList.remove('d-none');
                    }
                    
                    // Coba pilih kamera belakang (jika ada)
                    let selectedCamera = devices[0].id;
                    for (const device of devices) {
                        if (device.label && (device.label.toLowerCase().includes('back') || 
                                            device.label.toLowerCase().includes('belakang'))) {
                            selectedCamera = device.id;
                            break;
                        }
                    }
                    
                    currentCamera = selectedCamera;
                    startScanner(currentCamera);
                } else {
                    showError('Tidak ada kamera yang tersedia');
                    statusMessage.textContent = 'Kamera tidak ditemukan';
                }
            } catch (error) {
                showError('Error mengakses kamera: ' + error.message);
                statusMessage.textContent = 'Gagal mengakses kamera';
            }
        }
        
        // Mulai pemindaian dengan kamera tertentu
        function startScanner(cameraId) {
            // Sembunyikan placeholder
            cameraPlaceholder.style.display = 'none';
            
            // Buat instance scanner jika belum ada
            if (!html5QrCode) {
                html5QrCode = new Html5Qrcode('reader');
            }
            
            // Konfigurasi QR scanner
            const config = {
                fps: 15,
                qrbox: { width: 250, height: 250 },
                aspectRatio: 1.0,
                experimentalFeatures: {
                    useBarCodeDetectorIfSupported: true
                }
            };
            
            // Mulai scanner
            html5QrCode.start(
                cameraId,
                config,
                onScanSuccess,
                onScanProgress
            ).then(() => {
                // Scanner berhasil dimulai
                statusMessage.textContent = 'Memindai QR Code...';
                startButton.textContent = 'Kamera Aktif';
                startButton.disabled = true;
                hideError();
            }).catch(err => {
                showError('Gagal memulai kamera: ' + err.message);
                statusMessage.textContent = 'Gagal mengaktifkan kamera';
                cameraPlaceholder.style.display = 'flex';
                startButton.disabled = false;
            });
        }
        
        // Ganti kamera
        async function switchCamera() {
            try {
                const devices = await Html5Qrcode.getCameras();
                if (devices && devices.length > 1) {
                    // Temukan indeks kamera saat ini
                    const currentIndex = devices.findIndex(device => device.id === currentCamera);
                    // Pilih kamera berikutnya
                    const nextIndex = (currentIndex + 1) % devices.length;
                    
                    currentCamera = devices[nextIndex].id;
                    statusMessage.textContent = 'Mengganti kamera...';
                    startScanner(currentCamera);
                }
            } catch (error) {
                showError('Gagal mengganti kamera: ' + error.message);
            }
        }
        
        // Callback saat QR berhasil dipindai
        function onScanSuccess(decodedText) {
            // Feedback ke pengguna
            statusMessage.textContent = 'QR Code berhasil dipindai!';
            
            // Hentikan pemindaian
            if (html5QrCode) {
                html5QrCode.stop().then(() => {
                    processQrCode(decodedText);
                }).catch(err => {
                    showError('Gagal menghentikan scanner: ' + err.message);
                    resetScanner();
                });
            }
        }
        
        // Callback kemajuan pemindaian (tidak perlu implementasi)
        function onScanProgress(decodedText, decodedResult) {
            // Kosong - biarkan scanner berjalan
        }
        
        // Proses data QR code
        function processQrCode(content) {
            console.log('QR Code terdeteksi:', content);
            
            try {
                // Parse data QR
                let qrData;
                try {
                    qrData = JSON.parse(content);
                } catch (error) {
                    showError('Format QR code tidak valid. Pastikan memindai QR code yang benar.');
                    resetScanner();
                    return;
                }
                
                // Validasi data QR
                if (!qrData.user_id || !qrData.name) {
                    // Coba format alternatif
                    if (qrData.type === 'santri_qr' && qrData.id && qrData.nama) {
                        fetchSantriData(qrData.id);
                    } else {
                        showError('Data QR code tidak lengkap atau tidak valid');
                        resetScanner();
                    }
                    return;
                }
                
                // Set data untuk transfer
                targetUserId = qrData.user_id;
                targetName = qrData.name;
                
                // Tampilkan modal transfer
                showTransferModal();
                
            } catch (error) {
                showError('Gagal memproses QR code: ' + error.message);
                resetScanner();
            }
        }
        
        // Ambil data santri dari server
        function fetchSantriData(santriId) {
            statusMessage.textContent = 'Mengambil data santri...';
            
            fetch(`/api/santri/${santriId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        targetUserId = data.user_id;
                        targetName = data.nama;
                        showTransferModal();
                    } else {
                        showError(data.message || 'Data santri tidak ditemukan');
                        resetScanner();
                    }
                })
                .catch(error => {
                    showError('Gagal mengambil data dari server');
                    resetScanner();
                });
        }
        
        // Tampilkan modal transfer
        function showTransferModal() {
            document.getElementById('targetName').textContent = targetName;
            transferModal.show();
        }
        
        // Reset scanner
        function resetScanner() {
            startButton.disabled = false;
            startButton.textContent = 'Aktifkan Kamera';
            cameraPlaceholder.style.display = 'flex';
            statusMessage.textContent = 'Klik tombol untuk mulai memindai QR Code';
        }
        
        // Tampilkan pesan error
        function showError(message) {
            errorText.textContent = message;
            errorContainer.classList.remove('d-none');
            console.error('QR Scanner Error:', message);
        }
        
        // Sembunyikan pesan error
        function hideError() {
            errorContainer.classList.add('d-none');
        }
        
        // Event listener untuk konfirmasi transfer
        document.getElementById('confirmTransferBtn').addEventListener('click', function() {
            // Ambil nilai input
            const amount = document.getElementById('transferAmount').value;
            const sourceAccount = document.getElementById('sourceAccount').value;
            const targetAccount = document.getElementById('targetAccount').value;
            const note = document.getElementById('transferNote').value;
            
            // Validasi input
            if (!amount || amount < 1000) {
                alert('Jumlah transfer minimal Rp 1.000');
                return;
            }
            
            if (!sourceAccount) {
                alert('Pilih saldo sumber');
                return;
            }
            
            if (!targetAccount) {
                alert('Pilih saldo tujuan');
                return;
            }
            
            if (sourceAccount === targetAccount) {
                alert('Saldo sumber dan tujuan tidak boleh sama');
                return;
            }
            
            // Isi data konfirmasi
            document.getElementById('confirmRecipient').textContent = targetName;
            document.getElementById('confirmAmount').textContent = 'Rp ' + Number(amount).toLocaleString('id-ID');
            document.getElementById('confirmSource').textContent = capitalizeFirstLetter(sourceAccount);
            document.getElementById('confirmTarget').textContent = capitalizeFirstLetter(targetAccount);
            
            // Ganti ke modal konfirmasi
            transferModal.hide();
            confirmModal.show();
        });
        
        // Event listener untuk eksekusi transfer
        document.getElementById('executeTransferBtn').addEventListener('click', function() {
            // Tampilkan loading pada tombol
            const btn = this;
            const originalText = btn.innerHTML;
            btn.disabled = true;
            btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Memproses...';
            
            // Data transfer
            const data = {
                target_id: targetUserId,
                amount: document.getElementById('transferAmount').value,
                source_type: document.getElementById('sourceAccount').value,
                target_type: document.getElementById('targetAccount').value,
                keterangan: document.getElementById('transferNote').value || 'Transfer via QR Code',
                _token: '{{ csrf_token() }}'
            };
            
            // Kirim request transfer
            fetch('{{ route('transfer.qrcode.process') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(result => {
                confirmModal.hide();
                
                if (result.success) {
                    // Tampilkan pesan sukses
                    Swal.fire({
                        icon: 'success',
                        title: 'Transfer Berhasil!',
                        text: 'Dana telah berhasil ditransfer ke akun tujuan',
                        confirmButtonColor: '#0d6efd'
                    }).then(() => {
                        window.location.reload();
                    });
                } else {
                    // Tampilkan pesan error
                    Swal.fire({
                        icon: 'error',
                        title: 'Transfer Gagal',
                        text: result.message || 'Terjadi kesalahan saat memproses transfer',
                        confirmButtonColor: '#0d6efd'
                    });
                    btn.disabled = false;
                    btn.innerHTML = originalText;
                }
            })
            .catch(error => {
                confirmModal.hide();
                Swal.fire({
                    icon: 'error',
                    title: 'Terjadi Kesalahan',
                    text: 'Gagal menghubungi server. Silakan coba lagi.',
                    confirmButtonColor: '#0d6efd'
                });
                btn.disabled = false;
                btn.innerHTML = originalText;
            });
        });
        
        // Helper untuk kapitalisasi huruf pertama
        function capitalizeFirstLetter(string) {
            return string.charAt(0).toUpperCase() + string.slice(1);
        }
        
        // Reset scanner setelah modal ditutup
        document.addEventListener('hidden.bs.modal', function(event) {
            if (event.target.id === 'transferModal' || event.target.id === 'confirmModal') {
                resetScanner();
            }
        });
    });
</script>

<!-- SweetAlert2 untuk notifikasi yang lebih baik -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush
@endsection 