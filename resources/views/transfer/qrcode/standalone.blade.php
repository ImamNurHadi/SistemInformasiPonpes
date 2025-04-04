<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Transfer Saldo QR - Pondok Pesantren</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        :root {
            --primary-color: #058B42;
            --primary-dark: #02361A;
            --accent-color: #F9B234;
            --text-color: #333;
            --light-bg: #f8f9fa;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: var(--text-color);
            line-height: 1.6;
            background-color: var(--light-bg);
            padding-bottom: 80px;
        }
        
        .navbar {
            background-color: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 15px 0;
        }
        
        .navbar-brand img {
            height: 45px;
        }
        
        .user-container {
            margin-top: 20px;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            background-color: white;
        }
        
        .user-header {
            background-color: var(--primary-color);
            color: white;
            padding: 15px;
            text-align: center;
        }
        
        .user-body {
            padding: 20px;
        }
        
        .scanner-container {
            margin-top: 20px;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            background-color: white;
        }
        
        .scanner-header {
            background-color: var(--primary-color);
            color: white;
            padding: 15px;
            text-align: center;
        }
        
        .scanner-body {
            padding: 20px;
        }
        
        #reader {
            width: 100%;
            max-width: 350px;
            height: 350px;
            margin: 0 auto;
            border: 2px dashed #ccc;
            border-radius: 10px;
        }
        
        #camera-placeholder {
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background-color: #f8f9fa;
            border-radius: 10px;
        }
        
        .saldo-container {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin-bottom: 20px;
        }
        
        .saldo-card {
            flex: 1;
            min-width: 120px;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
            text-align: center;
            transition: all 0.3s;
        }
        
        .saldo-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }
        
        .saldo-card.primary {
            background-color: #0d6efd;
            color: white;
        }
        
        .saldo-card.success {
            background-color: #198754;
            color: white;
        }
        
        .saldo-card.info {
            background-color: #0dcaf0;
            color: white;
        }
        
        .saldo-title {
            font-size: 0.9rem;
            opacity: 0.9;
            margin-bottom: 5px;
        }
        
        .saldo-amount {
            font-size: 1.3rem;
            font-weight: 700;
        }
        
        .btn-scan {
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            transition: all 0.3s;
        }
        
        .btn-scan:hover, .btn-scan:focus {
            background-color: var(--primary-dark);
            color: white;
            transform: translateY(-2px);
        }
        
        /* Footer Action Bar */
        .action-bar {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            background-color: white;
            box-shadow: 0 -2px 10px rgba(0,0,0,0.1);
            padding: 15px;
            display: flex;
            justify-content: space-around;
            z-index: 1000;
        }
        
        .action-button {
            display: flex;
            flex-direction: column;
            align-items: center;
            color: #666;
            text-decoration: none;
            font-size: 0.8rem;
        }
        
        .action-button i {
            font-size: 1.5rem;
            margin-bottom: 5px;
        }
        
        .action-button.active {
            color: var(--primary-color);
        }
        
        .target-info {
            background-color: rgba(0,0,0,0.03);
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 20px;
            text-align: center;
            border: 1px solid #ddd;
        }
        
        .target-name {
            font-size: 1.3rem;
            font-weight: 600;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand" href="{{ route('transfer.qrcode.standalone') }}">
                <img src="{{ asset('img/logo_qinna.png') }}" alt="Pondok Pesantren Logo">
            </a>
            <div class="d-flex align-items-center">
                <span class="me-3">{{ $user->name }}</span>
                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-outline-danger">
                        <i class="bi bi-box-arrow-right me-1"></i> Keluar
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container">
        <!-- User Information -->
        <div class="user-container">
            <div class="user-header">
                <h5 class="mb-0"><i class="bi bi-wallet2 me-2"></i> Informasi Saldo</h5>
            </div>
            <div class="user-body">
                <div class="saldo-container">
                    @if(isset($saldo['utama']))
                    <div class="saldo-card primary">
                        <div class="saldo-title">Saldo Utama</div>
                        <div class="saldo-amount" id="saldo-utama">Rp {{ number_format($saldo['utama']) }}</div>
                    </div>
                    @endif
                    
                    @if(isset($saldo['belanja']))
                    <div class="saldo-card success">
                        <div class="saldo-title">Saldo Belanja</div>
                        <div class="saldo-amount" id="saldo-belanja">Rp {{ number_format($saldo['belanja']) }}</div>
                    </div>
                    @endif
                    
                    @if(isset($saldo['tabungan']))
                    <div class="saldo-card info">
                        <div class="saldo-title">Saldo Tabungan</div>
                        <div class="saldo-amount" id="saldo-tabungan">Rp {{ number_format($saldo['tabungan']) }}</div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Scanner Container -->
        <div class="scanner-container" id="scannerContainer">
            <div class="scanner-header">
                <h5 class="mb-0"><i class="bi bi-qr-code-scan me-2"></i> Pindai QR Code</h5>
            </div>
            <div class="scanner-body">
                <div class="alert alert-info mb-3">
                    <div class="d-flex">
                        <i class="bi bi-info-circle-fill me-2 fs-4"></i>
                        <div>
                            <strong>Langkah-langkah Transfer:</strong>
                            <ol class="mb-0 mt-1">
                                <li>Arahkan kamera ke QR Code pengguna yang akan menerima transfer</li>
                                <li>Isi jumlah transfer dan pilih jenis saldo (sumber &amp; tujuan)</li>
                                <li>Konfirmasi detail transfer</li>
                            </ol>
                        </div>
                    </div>
                </div>
                
                <div id="reader-container" class="mb-4 text-center">
                    <div id="reader"></div>
                    <div id="camera-placeholder">
                        <i class="bi bi-camera-fill" style="font-size: 4rem; color: #aaa;"></i>
                        <p class="mt-2">Mencari kamera...</p>
                        <div class="spinner-border text-primary mt-2" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>
                
                <div class="text-center mb-3">
                    <button id="switch-camera" class="btn btn-outline-secondary ms-2 d-none">
                        <i class="bi bi-arrow-repeat me-1"></i> Ganti Kamera
                    </button>
                </div>
                
                <div id="scanning-status" class="alert alert-light border">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-info-circle me-2"></i>
                        <span id="status-message">Mempersiapkan kamera...</span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Transfer Form (Hidden by default) -->
        <div class="scanner-container d-none" id="transferContainer">
            <div class="scanner-header">
                <h5 class="mb-0"><i class="bi bi-send me-2"></i> Transfer Saldo</h5>
            </div>
            <div class="scanner-body">
                <div class="target-info mb-4">
                    <i class="bi bi-person-circle" style="font-size: 3rem; color: #6c757d;"></i>
                    <div class="target-name" id="targetName">Nama Penerima</div>
                </div>
                
                <form id="transferForm">
                    <div class="mb-3">
                        <label for="amount" class="form-label">Jumlah Transfer</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" class="form-control" id="amount" min="1000" placeholder="10000" required>
                        </div>
                        <div class="form-text">Minimal Rp 1.000</div>
                    </div>
                    
                    <div class="row">
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="sourceType" class="form-label">Dari Saldo</label>
                                <select class="form-select" id="sourceType" required>
                                    <option value="">-- Pilih --</option>
                                    <option value="utama">Utama</option>
                                    <option value="belanja">Belanja</option>
                                    <option value="tabungan">Tabungan</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="targetType" class="form-label">Ke Saldo</label>
                                <select class="form-select" id="targetType" required>
                                    <option value="">-- Pilih --</option>
                                    <option value="utama">Utama</option>
                                    <option value="belanja">Belanja</option>
                                    <option value="tabungan">Tabungan</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="note" class="form-label">Keterangan (Opsional)</label>
                        <input type="text" class="form-control" id="note" placeholder="Keterangan transfer">
                    </div>
                    
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-scan">
                            <i class="bi bi-send-fill me-2"></i> Kirim Transfer
                        </button>
                        <button type="button" id="cancelBtn" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left me-2"></i> Kembali ke Pemindaian
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Action Bar -->
    <div class="action-bar">
        <a href="{{ route('transfer.qrcode.standalone') }}" class="action-button active">
            <i class="bi bi-qr-code-scan"></i>
            <span>Scan QR</span>
        </a>
        <a href="{{ route('transfer.qrcode.login-qr') }}" class="action-button">
            <i class="bi bi-person-badge"></i>
            <span>QR Saya</span>
        </a>
        <a href="{{ route('home') }}" class="action-button">
            <i class="bi bi-house"></i>
            <span>Beranda</span>
        </a>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Elements
            const readerContainer = document.getElementById('reader-container');
            const cameraPlaceholder = document.getElementById('camera-placeholder');
            const switchButton = document.getElementById('switch-camera');
            const statusMessage = document.getElementById('status-message');
            const scannerContainer = document.getElementById('scannerContainer');
            const transferContainer = document.getElementById('transferContainer');
            const cancelBtn = document.getElementById('cancelBtn');
            
            // QR Scanner variables
            let html5QrCode = null;
            let currentCamera = null;
            let targetUserId = null;
            let targetName = null;
            
            // Initialize QR Scanner
            function initQRScanner() {
                if (!html5QrCode) {
                    html5QrCode = new Html5Qrcode("reader");
                }
                
                // Check available cameras
                Html5Qrcode.getCameras().then(devices => {
                    if (devices && devices.length) {
                        // Show switch camera button if more than one camera available
                        if (devices.length > 1) {
                            switchButton.classList.remove('d-none');
                        }
                        
                        // Try to select back camera if available
                        let selectedCamera = devices[0].id;
                        for (const device of devices) {
                            if (device.label && (device.label.toLowerCase().includes('back') || 
                                                device.label.toLowerCase().includes('belakang'))) {
                                selectedCamera = device.id;
                                break;
                            }
                        }
                        
                        currentCamera = selectedCamera;
                        startQRScanner(currentCamera);
                    } else {
                        showError('Tidak ada kamera yang tersedia');
                        statusMessage.textContent = 'Kamera tidak ditemukan';
                    }
                }).catch(error => {
                    showError('Error mengakses kamera: ' + error.message);
                    statusMessage.textContent = 'Gagal mengakses kamera';
                });
            }
            
            // Start QR Scanner with camera ID
            function startQRScanner(cameraId) {
                // Hide placeholder
                cameraPlaceholder.style.display = 'none';
                
                // QR Scanner config
                const config = {
                    fps: 10,
                    qrbox: { width: 250, height: 250 },
                    aspectRatio: 1.0
                };
                
                // Start scanner
                html5QrCode.start(
                    cameraId,
                    config,
                    onQRCodeSuccess,
                    onQRCodeScanningProgress
                ).then(() => {
                    statusMessage.textContent = 'Memindai QR Code...';
                }).catch(err => {
                    showError('Gagal memulai kamera: ' + err.message);
                    statusMessage.textContent = 'Gagal mengaktifkan kamera';
                    cameraPlaceholder.style.display = 'flex';
                });
            }
            
            // Switch Camera
            function switchCamera() {
                if (html5QrCode && html5QrCode.isScanning) {
                    html5QrCode.stop().then(() => {
                        Html5Qrcode.getCameras().then(devices => {
                            if (devices && devices.length > 1) {
                                const currentIndex = devices.findIndex(device => device.id === currentCamera);
                                const nextIndex = (currentIndex + 1) % devices.length;
                                
                                currentCamera = devices[nextIndex].id;
                                statusMessage.textContent = 'Mengganti kamera...';
                                startQRScanner(currentCamera);
                            }
                        }).catch(error => {
                            showError('Gagal mendapatkan daftar kamera: ' + error.message);
                        });
                    }).catch(error => {
                        showError('Gagal menghentikan kamera: ' + error.message);
                    });
                }
            }
            
            // QR Code Success Callback
            function onQRCodeSuccess(decodedText) {
                // Stop scanning
                if (html5QrCode && html5QrCode.isScanning) {
                    html5QrCode.stop().then(() => {
                        statusMessage.textContent = 'QR Code berhasil dipindai! Memproses...';
                        processQRCode(decodedText);
                    }).catch(error => {
                        showError('Gagal menghentikan scanner: ' + error.message);
                    });
                }
            }
            
            // QR Code Scanning Progress Callback (not needed for functionality)
            function onQRCodeScanningProgress(decodedText, decodedResult) {
                // Just for progress tracking, no implementation needed
            }
            
            // Process QR Code data
            function processQRCode(content) {
                console.log('QR Code data:', content);
                
                try {
                    // Try to parse as JSON
                    let qrData;
                    try {
                        qrData = JSON.parse(content);
                    } catch (error) {
                        showError('Format QR code tidak valid. Pastikan memindai QR code yang benar.');
                        resetScanner();
                        return;
                    }
                    
                    // Validate QR data
                    if (!qrData.user_id || !qrData.name) {
                        // Try alternative format
                        if (qrData.type === 'santri_qr' && qrData.id && qrData.nama) {
                            fetchSantriData(qrData.id);
                        } else {
                            showError('Data QR code tidak lengkap atau tidak valid');
                            resetScanner();
                        }
                        return;
                    }
                    
                    // Set transfer data
                    targetUserId = qrData.user_id;
                    targetName = qrData.name;
                    
                    // Show transfer form
                    showTransferForm();
                } catch (error) {
                    showError('Gagal memproses QR code: ' + error.message);
                    resetScanner();
                }
            }
            
            // Fetch santri data for alternative QR format
            function fetchSantriData(santriId) {
                statusMessage.textContent = 'Mengambil data santri...';
                
                fetch(`/api/santri/id/${santriId}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            targetUserId = data.user_id;
                            targetName = data.nama;
                            showTransferForm();
                        } else {
                            showError(data.message || 'Data santri tidak ditemukan');
                            resetScanner();
                        }
                    })
                    .catch(error => {
                        showError('Gagal mengambil data dari server');
                        console.error('Error:', error);
                        resetScanner();
                    });
            }
            
            // Show transfer form
            function showTransferForm() {
                // Hide scanner container and show transfer container
                scannerContainer.classList.add('d-none');
                transferContainer.classList.remove('d-none');
                
                // Set target name
                document.getElementById('targetName').textContent = targetName;
                
                // Clear form fields
                document.getElementById('amount').value = '';
                document.getElementById('sourceType').selectedIndex = 0;
                document.getElementById('targetType').selectedIndex = 0;
                document.getElementById('note').value = '';
            }
            
            // Reset scanner
            function resetScanner() {
                cameraPlaceholder.style.display = 'flex';
                statusMessage.textContent = 'Memulai kamera kembali...';
                
                // Mulai scanner kembali
                setTimeout(() => {
                    initQRScanner();
                }, 1000);
            }
            
            // Show error message
            function showError(message) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: message,
                    confirmButtonColor: '#058B42'
                });
            }
            
            // Process transfer
            function processTransfer(formData) {
                fetch('{{ route("transfer.qrcode.standalone.process") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify(formData)
                })
                .then(response => response.json())
                .then(result => {
                    if (result.success) {
                        // Show success message
                        Swal.fire({
                            icon: 'success',
                            title: 'Transfer Berhasil',
                            text: result.message,
                            confirmButtonColor: '#058B42'
                        }).then(() => {
                            // Update saldo display
                            updateSaldoDisplay(result.saldo);
                            
                            // Return to scanner
                            transferContainer.classList.add('d-none');
                            scannerContainer.classList.remove('d-none');
                            resetScanner();
                        });
                    } else {
                        // Show error message
                        showError(result.message);
                    }
                })
                .catch(error => {
                    showError('Terjadi kesalahan: ' + error.message);
                });
            }
            
            // Update saldo display
            function updateSaldoDisplay(saldo) {
                if (saldo.utama !== undefined) {
                    document.getElementById('saldo-utama').textContent = 'Rp ' + formatNumber(saldo.utama);
                }
                if (saldo.belanja !== undefined) {
                    document.getElementById('saldo-belanja').textContent = 'Rp ' + formatNumber(saldo.belanja);
                }
                if (saldo.tabungan !== undefined) {
                    document.getElementById('saldo-tabungan').textContent = 'Rp ' + formatNumber(saldo.tabungan);
                }
            }
            
            // Format number with thousand separator
            function formatNumber(number) {
                return Number(number).toLocaleString('id-ID');
            }
            
            // Event Listeners
            switchButton.addEventListener('click', function() {
                switchCamera();
            });
            
            // Cancel button - back to scanner
            cancelBtn.addEventListener('click', function() {
                transferContainer.classList.add('d-none');
                scannerContainer.classList.remove('d-none');
                resetScanner();
            });
            
            // Transfer form submission
            document.getElementById('transferForm').addEventListener('submit', function(e) {
                e.preventDefault();
                
                const amount = document.getElementById('amount').value;
                const sourceType = document.getElementById('sourceType').value;
                const targetType = document.getElementById('targetType').value;
                const note = document.getElementById('note').value;
                
                // Validate input
                if (!amount || amount < 1000) {
                    showError('Jumlah transfer minimal Rp 1.000');
                    return;
                }
                
                if (!sourceType) {
                    showError('Pilih saldo sumber');
                    return;
                }
                
                if (!targetType) {
                    showError('Pilih saldo tujuan');
                    return;
                }
                
                // Confirm transfer
                Swal.fire({
                    title: 'Konfirmasi Transfer',
                    html: `
                        <div class="text-start">
                            <p><strong>Penerima:</strong> ${targetName}</p>
                            <p><strong>Jumlah:</strong> Rp ${formatNumber(amount)}</p>
                            <p><strong>Dari:</strong> Saldo ${sourceType.charAt(0).toUpperCase() + sourceType.slice(1)}</p>
                            <p><strong>Ke:</strong> Saldo ${targetType.charAt(0).toUpperCase() + targetType.slice(1)}</p>
                        </div>
                    `,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#058B42',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, Transfer Sekarang',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Process transfer
                        processTransfer({
                            target_id: targetUserId,
                            amount: amount,
                            source_type: sourceType,
                            target_type: targetType,
                            keterangan: note
                        });
                    }
                });
            });
            
            // Automatically start the camera when the page loads
            initQRScanner();
        });
    </script>
</body>
</html> 