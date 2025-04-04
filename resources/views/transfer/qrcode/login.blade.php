@extends('layouts.guest')

@section('title', 'Login QR Code')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="bi bi-qr-code-scan me-2"></i> Login dengan QR Code</h5>
                </div>
                <div class="card-body py-5">
                    <div class="text-center mb-4">
                        <img src="{{ asset('img/logo_qinna.png') }}" alt="Logo" style="max-width: 150px;">
                        <h4 class="mt-4 mb-3">Scan QR Code untuk Login</h4>
                        <p class="text-muted">Silakan scan QR Code dari akun Anda untuk melanjutkan ke Transfer Saldo</p>
                        <div class="alert alert-info mt-3">
                            <i class="bi bi-info-circle me-2"></i>
                            <strong>Informasi:</strong> Gunakan QR code yang sudah Anda miliki dari menu <strong>"Lihat QR Code Login Saya"</strong> di dashboard. Jika belum memiliki, silakan login terlebih dahulu melalui cara biasa.
                        </div>
                    </div>
                    
                    <div id="scanner-container" class="text-center mb-4">
                        <div id="reader" style="width: 100%; max-width: 400px; margin: 0 auto;"></div>
                    </div>
                    
                    <div id="scanning-status" class="alert alert-info d-none">
                        <i class="bi bi-info-circle me-2"></i> 
                        <span id="status-message">Memindai QR Code...</span>
                    </div>
                    
                    <div id="error-message" class="alert alert-danger d-none">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        <span id="error-text"></span>
                    </div>
                    
                    <div class="text-center mt-4">
                        <a href="{{ route('login') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left me-2"></i> Login Biasa
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const scanningStatus = document.getElementById('scanning-status');
        const statusMessage = document.getElementById('status-message');
        const errorMessage = document.getElementById('error-message');
        const errorText = document.getElementById('error-text');
        
        // Tampilkan status pemindaian
        scanningStatus.classList.remove('d-none');
        
        // Inisialisasi scanner QR code
        const html5QrCode = new Html5Qrcode("reader");
        const qrCodeSuccessCallback = (decodedText, decodedResult) => {
            try {
                // Periksa apakah QR code berisi HTML (indikasi dari error <!DOCTYPE)
                if (decodedText.includes('<!DOCTYPE') || decodedText.includes('<html')) {
                    showError("QR Code tidak valid: QR code berisi kode HTML. Pastikan Anda menggunakan QR code yang benar dan tidak memindai halaman web.");
                    console.error("QR berisi HTML:", decodedText.substring(0, 100) + "...");
                    startScanner();
                    return;
                }
                
                // Hentikan pemindaian
                html5QrCode.stop();
                
                // Update status
                statusMessage.textContent = "QR Code terdeteksi! Memproses login...";
                
                // Parse data QR
                console.log("QR Data:", decodedText);
                
                // Coba parse JSON, jika gagal mungkin bukan format JSON
                let qrData;
                try {
                    qrData = JSON.parse(decodedText);
                } catch (jsonError) {
                    console.error("Error parsing JSON:", jsonError);
                    showError("QR Code tidak valid: Format data tidak sesuai. Pastikan menggunakan QR Code yang benar dari menu 'Lihat QR Code Login Saya'");
                    startScanner();
                    return;
                }
                
                // Kirim data ke server untuk verifikasi
                verifyQRLogin(decodedText);
            } catch (error) {
                showError("QR Code tidak valid: " + error.message + ". Pastikan Anda menggunakan QR Code yang benar dari menu 'Lihat QR Code Login Saya'");
                console.error("Error parsing QR data:", error, "QR content:", decodedText.substring(0, 100) + "...");
                
                // Mulai pemindaian lagi
                startScanner();
            }
        };
        
        const config = { fps: 10, qrbox: { width: 250, height: 250 } };
        
        // Fungsi untuk memulai scanner
        function startScanner() {
            html5QrCode.start(
                { facingMode: "environment" }, 
                config, 
                qrCodeSuccessCallback
            ).catch(err => {
                showError("Tidak dapat mengakses kamera: " + err);
            });
        }
        
        // Fungsi untuk menampilkan error
        function showError(message) {
            errorText.textContent = message;
            errorMessage.classList.remove('d-none');
            scanningStatus.classList.add('d-none');
            
            // Otomatis sembunyikan pesan error setelah 8 detik
            setTimeout(() => {
                errorMessage.classList.add('d-none');
                scanningStatus.classList.remove('d-none');
            }, 8000);
        }
        
        // Fungsi untuk verifikasi login
        function verifyQRLogin(qrData) {
            fetch('{{ route('login.qrcode.verify') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ qr_data: qrData })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    statusMessage.textContent = data.message;
                    scanningStatus.classList.remove('alert-info');
                    scanningStatus.classList.add('alert-success');
                    
                    // Redirect ke halaman transfer standalone (bukan sistem informasi)
                    setTimeout(() => {
                        window.location.href = "{{ route('transfer.qrcode.standalone') }}";
                    }, 1000);
                } else {
                    showError(data.message);
                    console.error("Login error:", data);
                    // Mulai pemindaian lagi
                    startScanner();
                }
            })
            .catch(error => {
                showError("Terjadi kesalahan: " + error.message);
                console.error("Network error:", error);
                // Mulai pemindaian lagi
                startScanner();
            });
        }
        
        // Mulai scanner
        startScanner();
    });
</script>
@endpush
@endsection 