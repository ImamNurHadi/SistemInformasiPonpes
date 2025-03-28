<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Cek Saldo QR - Pondok Pesantren</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
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
        }
        
        .navbar {
            background-color: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 15px 0;
        }
        
        .navbar-brand img {
            height: 45px;
        }
        
        .scanner-container {
            margin-top: 30px;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            background-color: white;
        }
        
        #reader {
            width: 100%;
            border-radius: 10px;
            overflow: hidden;
        }
        
        .scanner-header {
            background-color: var(--primary-color);
            color: white;
            padding: 15px;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
            text-align: center;
        }
        
        .scanner-footer {
            padding: 15px;
            text-align: center;
            border-top: 1px solid #eee;
        }
        
        .btn-scan {
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 10px 25px;
            border-radius: 30px;
            font-weight: 500;
            transition: all 0.3s;
        }
        
        .btn-scan:hover {
            background-color: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .btn-back {
            background-color: #6c757d;
            color: white;
            border: none;
            padding: 10px 25px;
            border-radius: 30px;
            font-weight: 500;
            transition: all 0.3s;
        }
        
        .btn-back:hover {
            background-color: #5a6268;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        /* Result Styling */
        .result-container {
            display: none;
            margin-top: 30px;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            background-color: white;
        }
        
        .result-header {
            background-color: var(--primary-color);
            color: white;
            padding: 15px;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
            text-align: center;
        }
        
        .result-body {
            padding: 20px;
        }
        
        .user-profile {
            text-align: center;
            padding-bottom: 20px;
            border-bottom: 1px solid #eee;
            margin-bottom: 20px;
        }
        
        .profile-photo {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 15px;
            border: 3px solid var(--primary-color);
        }
        
        .profile-name {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 5px;
        }
        
        .profile-role {
            color: #666;
            font-size: 0.9rem;
            margin-bottom: 10px;
        }
        
        .profile-detail {
            margin-bottom: 5px;
            color: #555;
        }
        
        .saldo-cards {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            justify-content: center;
        }
        
        .saldo-card {
            flex: 1;
            min-width: 200px;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
            transition: all 0.3s;
            text-align: center;
        }
        
        .saldo-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
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
            font-size: 1rem;
            font-weight: 500;
            margin-bottom: 10px;
            opacity: 0.9;
        }
        
        .saldo-amount {
            font-size: 1.5rem;
            font-weight: 700;
        }
        
        .error-message {
            padding: 15px;
            border-radius: 10px;
            background-color: #f8d7da;
            border: 1px solid #f5c2c7;
            color: #842029;
            margin-top: 20px;
            display: none;
        }
        
        .loading-spinner {
            text-align: center;
            padding: 20px;
            display: none;
        }
        
        .spinner-border {
            width: 3rem;
            height: 3rem;
            color: var(--primary-color);
        }
        
        @media (max-width: 768px) {
            .scanner-container {
                margin-top: 20px;
            }
            
            .saldo-cards {
                flex-direction: column;
            }
            
            .saldo-card {
                min-width: 100%;
            }
        }
    </style>

    <script>
        // Untuk memastikan CSRF token tersedia di semua requests
        window.csrfToken = "{{ csrf_token() }}";
    </script>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <img src="{{ asset('img/logo_qinna.png') }}" alt="Pondok Pesantren Logo">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">Kembali ke Beranda</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <!-- Scanner Container -->
                <div class="scanner-container" id="scannerContainer">
                    <div class="scanner-header">
                        <h4 class="mb-0"><i class="bi bi-qr-code-scan me-2"></i> Scan QR Code</h4>
                    </div>
                    <div id="reader"></div>
                    <div class="scanner-footer">
                        <p>Posisikan QR Code pengguna di dalam area pemindaian</p>
                        <button id="startButton" class="btn btn-scan" onclick="startScanner()">
                            <i class="bi bi-camera me-2"></i> Mulai Pemindaian
                        </button>
                    </div>
                </div>
                
                <!-- Loading Spinner -->
                <div class="loading-spinner" id="loadingSpinner">
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-3">Memuat informasi saldo...</p>
                </div>
                
                <!-- Error Message -->
                <div class="error-message" id="errorMessage">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    <span id="errorText">Terjadi kesalahan. Silakan coba lagi.</span>
                    <div id="debugInfo" class="mt-2 small" style="border-top: 1px dashed #f5c2c7; padding-top: 8px;">
                        <strong>Debug Info:</strong> <span id="debugText"></span>
                    </div>
                </div>
                
                <!-- Result Container -->
                <div class="result-container" id="resultContainer">
                    <div class="result-header">
                        <h4 class="mb-0"><i class="bi bi-wallet me-2"></i> Informasi Saldo</h4>
                    </div>
                    <div class="result-body">
                        <div class="user-profile">
                            <img id="profilePhoto" src="{{ asset('img/default-user.png') }}" alt="Foto Profil" class="profile-photo">
                            <h4 id="profileName" class="profile-name">Nama Pengguna</h4>
                            <div id="profileRole" class="profile-role">Role Pengguna</div>
                            <div id="profileDetail" class="profile-detail"></div>
                        </div>
                        
                        <div class="saldo-cards" id="saldoCards">
                            <!-- Saldo cards will be inserted here -->
                        </div>
                        
                        <div class="text-center mt-4">
                            <button class="btn btn-scan me-2" onclick="scanAnother()">
                                <i class="bi bi-arrow-repeat me-2"></i> Scan Lainnya
                            </button>
                            <a href="{{ route('home') }}" class="btn btn-back">
                                <i class="bi bi-house me-2"></i> Kembali ke Beranda
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let html5QrCode;
        
        function startScanner() {
            document.getElementById('startButton').style.display = 'none';
            
            html5QrCode = new Html5Qrcode("reader");
            const config = { fps: 10, qrbox: { width: 250, height: 250 } };
            
            html5QrCode.start(
                { facingMode: "environment" },
                config,
                onScanSuccess,
                onScanFailure
            );
        }
        
        function onScanSuccess(decodedText, decodedResult) {
            // Stop scanner after successful scan
            html5QrCode.stop().then(() => {
                document.getElementById('scannerContainer').style.display = 'none';
                document.getElementById('loadingSpinner').style.display = 'block';
                processQRCode(decodedText);
            }).catch(err => {
                console.error('Error stopping QR scanner:', err);
                showError('Terjadi kesalahan saat menghentikan scanner.', { error: err.message });
            });
        }
        
        function onScanFailure(error) {
            // Handle scan failure silently - user will try again
            console.log(`QR scan error: ${error}`);
        }
        
        function processQRCode(qrCodeText) {
            console.log('QR Code scanned:', qrCodeText); // Debug output
            
            // Handle kasus khusus: QR berisi HTML (error)
            if (qrCodeText.includes('<!DOCTYPE') || qrCodeText.includes('<html')) {
                console.error('QR contains HTML, likely an error');
                showError('QR Code berisi HTML yang tidak valid. Silakan coba lagi dengan QR Code yang benar.', {
                    qrCodeStart: qrCodeText.substring(0, 100) // Tampilkan 100 karakter pertama
                });
                document.getElementById('loadingSpinner').style.display = 'none';
                return;
            }
            
            // Mencoba membersihkan string jika berisi karakter khusus atau UUID
            let cleanedQRCode = qrCodeText;
            
            // Jika QR code berisi karakter yang bukan JSON valid, coba ekstrak UUID
            const uuidMatch = qrCodeText.match(/([0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12})/i);
            if (uuidMatch) {
                console.log('Found UUID in QR code:', uuidMatch[1]);
                cleanedQRCode = uuidMatch[1]; // Gunakan UUID sebagai QR code value
            }
            
            // Tampilkan informasi pada UI
            document.getElementById('errorMessage').style.display = 'none';
            document.getElementById('loadingSpinner').style.display = 'block';
            
            try {
                // Get the CSRF token from meta tag
                const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                
                fetch('{{ route("cek-saldo-qr.check") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        qr_code: cleanedQRCode // Gunakan QR code yang sudah dibersihkan
                    })
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok: ' + response.status);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Response data:', data); // Debug output
                    document.getElementById('loadingSpinner').style.display = 'none';
                    
                    if (data.success) {
                        displayResult(data);
                    } else {
                        showError(data.message || 'Terjadi kesalahan saat memproses QR Code.', {
                            response: data,
                            qrCode: cleanedQRCode
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    document.getElementById('loadingSpinner').style.display = 'none';
                    showError('Terjadi kesalahan pada server. Silakan coba lagi.', {
                        errorMessage: error.message,
                        qrCode: cleanedQRCode
                    });
                });
            } catch (error) {
                console.error('Error in processQRCode:', error);
                document.getElementById('loadingSpinner').style.display = 'none';
                showError('Terjadi kesalahan saat memproses QR Code.', {
                    errorMessage: error.message,
                    qrCode: cleanedQRCode
                });
            }
        }
        
        function displayResult(data) {
            // Set user information
            const user = data.user;
            const saldo = data.saldo;
            
            // Set profile image if available
            if (user.photo) {
                document.getElementById('profilePhoto').src = `{{ asset('storage/') }}/${user.photo}`;
            }
            
            // Set name and role
            document.getElementById('profileName').textContent = user.name;
            document.getElementById('profileRole').textContent = capitalizeFirstLetter(user.role);
            
            // Set detail information based on user type
            let detailHTML = '';
            if (user.detail) {
                if (user.role === 'santri' && user.detail.nis) {
                    detailHTML += `<div><strong>NIS:</strong> ${user.detail.nis}</div>`;
                } else if (user.role === 'pengurus' && user.detail.nip) {
                    detailHTML += `<div><strong>NIP:</strong> ${user.detail.nip}</div>`;
                } else if (user.role === 'supplier' && user.detail.nama_supplier) {
                    detailHTML += `<div><strong>Supplier:</strong> ${user.detail.nama_supplier}</div>`;
                } else if (user.role === 'koperasi' && user.detail.nama_koperasi) {
                    detailHTML += `<div><strong>Koperasi:</strong> ${user.detail.nama_koperasi}</div>`;
                }
            }
            document.getElementById('profileDetail').innerHTML = detailHTML;
            
            // Display saldo cards
            const saldoCardsContainer = document.getElementById('saldoCards');
            saldoCardsContainer.innerHTML = '';
            
            if (saldo.utama) {
                saldoCardsContainer.innerHTML += `
                    <div class="saldo-card primary">
                        <div class="saldo-title"><i class="bi bi-cash-coin me-2"></i> Saldo Utama</div>
                        <div class="saldo-amount">${saldo.utama.formattedAmount}</div>
                    </div>
                `;
            }
            
            if (saldo.belanja) {
                saldoCardsContainer.innerHTML += `
                    <div class="saldo-card success">
                        <div class="saldo-title"><i class="bi bi-basket me-2"></i> Saldo Belanja</div>
                        <div class="saldo-amount">${saldo.belanja.formattedAmount}</div>
                    </div>
                `;
            }
            
            if (saldo.tabungan) {
                saldoCardsContainer.innerHTML += `
                    <div class="saldo-card info">
                        <div class="saldo-title"><i class="bi bi-piggy-bank me-2"></i> Saldo Tabungan</div>
                        <div class="saldo-amount">${saldo.tabungan.formattedAmount}</div>
                    </div>
                `;
            }
            
            // Display the result container
            document.getElementById('resultContainer').style.display = 'block';
        }
        
        function scanAnother() {
            // Reset the page for another scan
            document.getElementById('resultContainer').style.display = 'none';
            document.getElementById('errorMessage').style.display = 'none';
            document.getElementById('scannerContainer').style.display = 'block';
            document.getElementById('startButton').style.display = 'inline-block';
        }
        
        function showError(message, debugInfo = null) {
            document.getElementById('errorText').textContent = message;
            
            // Tampilkan debug info jika ada
            const debugElement = document.getElementById('debugInfo');
            const debugTextElement = document.getElementById('debugText');
            
            if (debugInfo) {
                debugTextElement.textContent = JSON.stringify(debugInfo);
                debugElement.style.display = 'block';
            } else {
                debugElement.style.display = 'none';
            }
            
            document.getElementById('errorMessage').style.display = 'block';
            document.getElementById('scannerContainer').style.display = 'block';
            document.getElementById('startButton').style.display = 'inline-block';
        }
        
        function capitalizeFirstLetter(string) {
            return string.charAt(0).toUpperCase() + string.slice(1);
        }
    </script>
</body>
</html> 