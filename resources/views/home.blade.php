<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pondok Pesantren - Sistem Informasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
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
        }
        
        /* Header & Navbar */
        .navbar {
            background-color: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 15px 0;
        }
        
        .navbar-brand img {
            height: 45px;
        }
        
        .navbar-nav .nav-link {
            color: var(--text-color);
            font-weight: 500;
            padding: 10px 15px;
            transition: color 0.3s;
        }
        
        .navbar-nav .nav-link:hover,
        .navbar-nav .nav-link.active {
            color: var(--primary-color);
        }
        
        .btn-auth {
            background-color: var(--primary-color);
            color: white;
            padding: 8px 20px;
            border-radius: 30px;
            font-weight: 500;
            transition: all 0.3s;
        }
        
        .btn-auth:hover {
            background-color: var(--primary-dark);
            color: white;
            transform: translateY(-2px);
        }
        
        /* Hero Section */
        .hero {
            background: linear-gradient(135deg, rgba(5, 139, 66, 0.9) 0%, rgba(2, 54, 26, 0.9) 100%), url('/img/santri.jpeg') center/cover no-repeat;
            color: white;
            padding: 120px 0;
            text-align: center;
        }
        
        .hero h1 {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 20px;
            text-shadow: 2px 2px 3px rgba(0,0,0,0.2);
        }
        
        .hero p {
            font-size: 1.2rem;
            max-width: 800px;
            margin: 0 auto 30px;
            opacity: 0.9;
        }
        
        .btn-cta {
            background-color: var(--accent-color);
            color: var(--text-color);
            padding: 12px 30px;
            font-size: 1.1rem;
            font-weight: 600;
            border-radius: 30px;
            transition: all 0.3s;
        }
        
        .btn-cta:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        
        /* Saldo Info Styles */
        .saldo-info {
            margin-top: 30px;
        }
        
        .saldo-info .card {
            border-radius: 10px;
            border: none;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
            transition: all 0.3s;
            margin-bottom: 15px;
        }
        
        .saldo-info .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.3);
        }
        
        .saldo-info .card-body {
            padding: 15px 10px;
        }
        
        .saldo-info h6 {
            font-size: 0.9rem;
            opacity: 0.9;
        }
        
        .saldo-info h5 {
            font-size: 1.2rem;
            font-weight: 700;
        }
        
        /* Stats Section */
        .stats {
            background-color: white;
            padding: 40px 0;
            text-align: center;
        }
        
        .stat-item {
            padding: 20px;
        }
        
        .stat-number {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 10px;
            display: block;
        }
        
        .stat-label {
            font-size: 1.1rem;
            color: #666;
        }
        
        /* Features */
        .features {
            padding: 80px 0;
            background-color: var(--light-bg);
        }
        
        .section-title {
            text-align: center;
            margin-bottom: 50px;
        }
        
        .section-title h2 {
            font-size: 2.5rem;
            color: var(--primary-color);
            position: relative;
            display: inline-block;
        }
        
        .section-title h2:after {
            content: '';
            position: absolute;
            width: 70%;
            height: 3px;
            background-color: var(--accent-color);
            bottom: -10px;
            left: 15%;
        }
        
        .feature-card {
            text-align: center;
            padding: 30px 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            transition: all 0.3s;
            height: 100%;
        }
        
        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.1);
        }
        
        .feature-icon {
            width: 80px;
            height: 80px;
            background-color: rgba(5, 139, 66, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
        }
        
        .feature-icon i {
            font-size: 35px;
            color: var(--primary-color);
        }
        
        .feature-title {
            font-size: 1.4rem;
            font-weight: 600;
            margin-bottom: 15px;
        }
        
        /* News Section */
        .news {
            padding: 80px 0;
        }
        
        .news-card {
            border: none;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            transition: all 0.3s;
            height: 100%;
        }
        
        .news-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }
        
        .news-img-container {
            height: 200px;
            overflow: hidden;
            position: relative;
        }
        
        .news-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s;
        }
        
        .news-card:hover .news-img {
            transform: scale(1.1);
        }
        
        .news-date {
            position: absolute;
            top: 15px;
            right: 15px;
            background-color: var(--primary-color);
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 0.8rem;
        }
        
        .news-body {
            padding: 20px;
        }
        
        .news-title {
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 10px;
            color: var(--primary-color);
        }
        
        .news-text {
            color: #666;
            margin-bottom: 15px;
        }
        
        .btn-more {
            color: var(--primary-color);
            font-weight: 500;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
        }
        
        .btn-more i {
            margin-left: 5px;
            transition: transform 0.3s;
        }
        
        .btn-more:hover i {
            transform: translateX(5px);
        }
        
        /* Footer */
        footer {
            background-color: var(--primary-dark);
            color: white;
            padding: 60px 0 0;
        }
        
        .footer-logo {
            margin-bottom: 20px;
            max-width: 200px;
        }
        
        .footer-about {
            margin-bottom: 20px;
            opacity: 0.8;
        }
        
        .footer-heading {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 20px;
            position: relative;
            padding-bottom: 10px;
        }
        
        .footer-heading:after {
            content: '';
            position: absolute;
            width: 40px;
            height: 2px;
            background-color: var(--accent-color);
            bottom: 0;
            left: 0;
        }
        
        .footer-links {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .footer-links li {
            margin-bottom: 10px;
        }
        
        .footer-links a {
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            transition: all 0.3s;
        }
        
        .footer-links a:hover {
            color: white;
            padding-left: 5px;
        }
        
        .contact-info {
            margin-bottom: 10px;
            display: flex;
            align-items: flex-start;
        }
        
        .contact-info i {
            margin-right: 10px;
            color: var(--accent-color);
        }
        
        .social-links {
            margin-top: 20px;
        }
        
        .social-links a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            background-color: rgba(255,255,255,0.1);
            border-radius: 50%;
            margin-right: 10px;
            color: white;
            transition: all 0.3s;
        }
        
        .social-links a:hover {
            background-color: var(--accent-color);
            transform: translateY(-3px);
        }
        
        .footer-bottom {
            background-color: rgba(0,0,0,0.2);
            padding: 20px 0;
            margin-top: 40px;
            text-align: center;
        }
        
        .footer-bottom p {
            margin: 0;
            opacity: 0.8;
        }
        
        /* Responsive */
        @media (max-width: 992px) {
            .hero {
                padding: 80px 0;
            }
            
            .hero h1 {
                font-size: 2.5rem;
            }
        }
        
        @media (max-width: 768px) {
            .navbar {
                padding: 10px 0;
            }
            
            .hero {
                padding: 60px 0;
            }
            
            .hero h1 {
                font-size: 2rem;
            }
            
            .hero p {
                font-size: 1rem;
            }
            
            .stats {
                padding: 20px 0;
            }
            
            .stat-number {
                font-size: 2rem;
            }
            
            .section-title h2 {
                font-size: 2rem;
            }
            
            .features, .news {
                padding: 50px 0;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <a class="navbar-brand" href="/">
                <img src="{{ asset('img/logo_qinna.png') }}" alt="Pondok Pesantren Logo">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="#">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Profil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Program</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Berita</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Kontak</a>
                    </li>
                    <li class="nav-item ms-lg-3">
                        <a class="btn btn-auth" href="{{ route('login') }}">Masuk</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <h1>Pondok Pesantren Modern</h1>
            <p>Mengelola pendidikan Islam dengan teknologi modern untuk menciptakan generasi santri yang unggul dalam ilmu agama dan keterampilan hidup.</p>
            
            <!-- Tampilkan saldo jika user sudah login -->
            @if($isLoggedIn && !empty($userSaldo))
            <div class="saldo-info mb-4">
                <div class="row justify-content-center">
                    @if(isset($userSaldo['utama']))
                    <div class="col-md-3 mb-2">
                        <div class="card bg-primary text-white">
                            <div class="card-body text-center py-2">
                                <h6 class="mb-1"><i class="bi bi-cash-coin me-1"></i> Saldo Utama</h6>
                                <h5 class="mb-0">Rp {{ number_format($userSaldo['utama']) }}</h5>
                            </div>
                        </div>
                    </div>
                    @endif
                    
                    @if(isset($userSaldo['belanja']))
                    <div class="col-md-3 mb-2">
                        <div class="card bg-success text-white">
                            <div class="card-body text-center py-2">
                                <h6 class="mb-1"><i class="bi bi-basket me-1"></i> Saldo Belanja</h6>
                                <h5 class="mb-0">Rp {{ number_format($userSaldo['belanja']) }}</h5>
                            </div>
                        </div>
                    </div>
                    @endif
                    
                    @if(isset($userSaldo['tabungan']))
                    <div class="col-md-3 mb-2">
                        <div class="card bg-info text-white">
                            <div class="card-body text-center py-2">
                                <h6 class="mb-1"><i class="bi bi-piggy-bank me-1"></i> Saldo Tabungan</h6>
                                <h5 class="mb-0">Rp {{ number_format($userSaldo['tabungan']) }}</h5>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            @endif
            
            <div class="mt-4">
                @if($isLoggedIn)
                    <a href="{{ route('transfer.qrcode.standalone') }}" class="btn btn-cta me-3">
                        <i class="bi bi-qr-code me-2"></i> Transfer QR
                    </a>
                    <a href="{{ route('cek-saldo-qr.index') }}" class="btn btn-cta me-3">
                        <i class="bi bi-qr-code-scan me-2"></i> Cek Saldo QR
                    </a>
                    <a href="{{ route('dashboard') }}" class="btn btn-cta">
                        <i class="bi bi-pc-display me-2"></i> Sistem Informasi
                    </a>
                @else
                    <a href="{{ route('login.qrcode') }}" class="btn btn-cta me-3">
                        <i class="bi bi-qr-code me-2"></i> Transfer QR
                    </a>
                    <a href="{{ route('cek-saldo-qr.index') }}" class="btn btn-cta me-3">
                        <i class="bi bi-qr-code-scan me-2"></i> Cek Saldo QR
                    </a>
                    <a href="{{ route('login') }}" class="btn btn-cta">
                        <i class="bi bi-pc-display me-2"></i> Sistem Informasi
                    </a>
                @endif
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="stat-item">
                        <span class="stat-number">{{ number_format($totalSantri) }}+</span>
                        <span class="stat-label">Santri Aktif</span>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-item">
                        <span class="stat-number">{{ number_format($totalPengurus) }}+</span>
                        <span class="stat-label">Pengajar & Pengurus</span>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-item">
                        <span class="stat-number">{{ number_format($totalKoperasi) }}</span>
                        <span class="stat-label">Unit Usaha</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features">
        <div class="container">
            <div class="section-title">
                <h2>Keunggulan Kami</h2>
            </div>
            <div class="row g-4">
                @foreach($keunggulan as $item)
                <div class="col-md-6 col-lg-3">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi {{ $item['icon'] }}"></i>
                        </div>
                        <h3 class="feature-title">{{ $item['judul'] }}</h3>
                        <p>{{ $item['deskripsi'] }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- News Section -->
    <section class="news">
        <div class="container">
            <div class="section-title">
                <h2>Berita Terkini</h2>
            </div>
            <div class="row g-4">
                @foreach($berita as $item)
                <div class="col-md-6 col-lg-4">
                    <div class="card news-card">
                        <div class="news-img-container">
                            <img src="{{ asset($item['image']) }}" class="news-img" alt="{{ $item['judul'] }}">
                            <div class="news-date">{{ $item['tanggal'] }}</div>
                        </div>
                        <div class="news-body">
                            <h5 class="news-title">{{ $item['judul'] }}</h5>
                            <p class="news-text">{{ $item['ringkasan'] }}</p>
                            <a href="{{ route('berita.detail', $item['slug']) }}" class="btn-more">Baca Selengkapnya <i class="bi bi-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4">
                    <img src="{{ asset('img/logo_qinna.png') }}" alt="Logo" class="footer-logo">
                    <p class="footer-about">Sistem Informasi Pondok Pesantren Modern yang menggabungkan pendidikan Islam dengan teknologi untuk menciptakan generasi unggul.</p>
                    <div class="social-links">
                        <a href="#"><i class="bi bi-facebook"></i></a>
                        <a href="#"><i class="bi bi-twitter"></i></a>
                        <a href="#"><i class="bi bi-instagram"></i></a>
                        <a href="#"><i class="bi bi-youtube"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 mb-4">
                    <h4 class="footer-heading">Navigasi</h4>
                    <ul class="footer-links">
                        <li><a href="#">Beranda</a></li>
                        <li><a href="#">Profil</a></li>
                        <li><a href="#">Program</a></li>
                        <li><a href="#">Berita</a></li>
                        <li><a href="#">Kontak</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <h4 class="footer-heading">Program</h4>
                    <ul class="footer-links">
                        <li><a href="#">Tahfidz Al-Qur'an</a></li>
                        <li><a href="#">Kitab Kuning</a></li>
                        <li><a href="#">Pendidikan Formal</a></li>
                        <li><a href="#">Keterampilan Bahasa</a></li>
                        <li><a href="#">Kewirausahaan</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <h4 class="footer-heading">Kontak</h4>
                    <div class="contact-info">
                        <i class="bi bi-geo-alt"></i>
                        <span>Jl. Pondok Pesantren No. 123<br>Kota, Provinsi, Indonesia</span>
                    </div>
                    <div class="contact-info">
                        <i class="bi bi-telephone"></i>
                        <span>+62 123 4567 890</span>
                    </div>
                    <div class="contact-info">
                        <i class="bi bi-envelope"></i>
                        <span>info@pondokpesantren.ac.id</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <div class="container">
                <p>&copy; {{ date('Y') }} Sistem Informasi Pondok Pesantren. All Rights Reserved.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 