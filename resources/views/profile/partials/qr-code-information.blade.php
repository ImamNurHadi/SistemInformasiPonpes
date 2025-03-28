<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('QR Code Informasi') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Gunakan QR Code ini untuk cek saldo cepat melalui fitur Cek Saldo QR di halaman utama.') }}
        </p>
    </header>

    <div class="mt-6 space-y-6">
        <div class="qr-code-container">
            <div>
                {!! QrCode::size(200)->generate($qrData) !!}
            </div>
            <p class="mt-3 text-sm text-gray-600">
                {{ __('Tunjukkan QR Code ini kepada petugas atau scan pada fitur Cek Saldo QR untuk melihat informasi saldo Anda dengan cepat.') }}
            </p>
        </div>
    </div>
</section> 