@extends('layouts.app')

@section('title', 'QR Code Saya')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="bi bi-qr-code me-2"></i> QR Code Pengguna</h5>
                </div>
                <div class="card-body text-center py-5">
                    <h5 class="mb-4">{{ auth()->user()->name }}</h5>
                    
                    <div class="qr-container bg-white p-3 d-inline-block mb-4" style="border-radius: 10px; box-shadow: 0 0 15px rgba(0,0,0,0.1);">
                        <div id="qrcode-container">
                            {!! $qrCode !!}
                        </div>
                    </div>
                    
                    <div class="alert alert-info mb-4">
                        <h6><i class="bi bi-info-circle me-2"></i> Cara Menggunakan QR Code:</h6>
                        <ol class="text-start mb-0">
                            <li>QR Code ini dapat digunakan untuk login cepat dan transfer saldo</li>
                            <li>Tunjukkan QR Code ini ke pengguna lain untuk menerima transfer</li>
                            <li>Gunakan QR Code ini untuk login di perangkat lain</li>
                        </ol>
                    </div>
                    
                    <div class="alert alert-warning">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        QR Code ini bersifat privat. Jangan bagikan kepada orang yang tidak dikenal untuk mencegah penyalahgunaan.
                    </div>

                    <div class="mt-3">
                        <a href="#" id="download-qr" class="btn btn-primary me-2">
                            <i class="bi bi-download me-2"></i> Unduh QR Code
                        </a>
                        <a href="{{ route('transfer.qrcode') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left me-2"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Fungsi untuk mengunduh QR code sebagai gambar
        document.getElementById('download-qr').addEventListener('click', function(e) {
            e.preventDefault();
            
            // Ambil QR code sebagai gambar
            const qrContainer = document.getElementById('qrcode-container');
            const qrImage = qrContainer.querySelector('img') || qrContainer.querySelector('svg');
            
            if (qrImage) {
                // Buat canvas untuk konversi
                const canvas = document.createElement('canvas');
                const ctx = canvas.getContext('2d');
                
                // Buat gambar baru
                const img = new Image();
                
                // Jika QR code adalah SVG, perlu konversi
                if (qrImage.tagName === 'SVG') {
                    const xml = new XMLSerializer().serializeToString(qrImage);
                    const svg64 = btoa(xml);
                    const b64Start = 'data:image/svg+xml;base64,';
                    const image64 = b64Start + svg64;
                    
                    img.onload = function() {
                        canvas.width = img.width;
                        canvas.height = img.height;
                        ctx.drawImage(img, 0, 0);
                        downloadImage(canvas.toDataURL('image/png'));
                    };
                    
                    img.src = image64;
                } else {
                    // Jika QR code sudah dalam bentuk gambar
                    downloadImage(qrImage.src);
                }
            } else {
                alert('Tidak dapat mengunduh QR code.');
            }
        });
        
        // Fungsi untuk mengunduh gambar
        function downloadImage(dataUrl) {
            const a = document.createElement('a');
            a.href = dataUrl;
            a.download = 'qrcode-{{ strtolower(str_replace(" ", "-", auth()->user()->name)) }}.png';
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
        }
    });
</script>
@endpush
@endsection 