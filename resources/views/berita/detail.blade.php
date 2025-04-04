<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $berita->judul }} - Pondok Pesantren</title>
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
        
        /* Berita Detail */
        .berita-header {
            background-color: var(--primary-color);
            color: white;
            padding: 60px 0;
            margin-bottom: 40px;
        }
        
        .berita-image {
            margin: 20px 0;
            width: 100%;
            max-height: 500px;
            object-fit: cover;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .berita-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 15px;
            text-align: left;
        }
        
        .berita-date {
            display: flex;
            align-items: center;
            margin-bottom: 0;
            font-size: 1.1rem;
            opacity: 0.9;
        }
        
        .berita-date i {
            margin-right: 10px;
        }
        
        .berita-content {
            margin-bottom: 40px;
            font-size: 1.1rem;
            line-height: 1.8;
        }
        
        .berita-summary {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 30px;
            padding: 20px;
            background-color: var(--light-bg);
            border-left: 5px solid var(--accent-color);
            border-radius: 5px;
        }
        
        .back-btn {
            display: inline-flex;
            align-items: center;
            background-color: var(--primary-color);
            color: white;
            padding: 10px 20px;
            border-radius: 30px;
            text-decoration: none;
            transition: all 0.3s;
            font-weight: 500;
            margin-top: 20px;
        }
        
        .back-btn:hover {
            background-color: var(--primary-dark);
            color: white;
            transform: translateY(-2px);
        }
        
        .back-btn i {
            margin-right: 10px;
        }
        
        /* Footer */
        footer {
            background-color: var(--primary-dark);
            color: white;
            padding-top: 60px;
        }
        
        .footer-logo {
            height: 50px;
            margin-bottom: 20px;
        }
        
        .footer-about {
            opacity: 0.8;
            margin-bottom: 20px;
        }
        
        .social-links {
            display: flex;
            gap: 15px;
            margin-bottom: 30px;
        }
        
        .social-links a {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: rgba(255,255,255,0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.2rem;
            transition: all 0.3s;
        }
        
        .social-links a:hover {
            background-color: var(--accent-color);
            transform: translateY(-5px);
        }
        
        .footer-heading {
            font-size: 1.3rem;
            margin-bottom: 20px;
            position: relative;
            padding-bottom: 10px;
        }
        
        .footer-heading:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 50px;
            height: 2px;
            background-color: var(--accent-color);
        }
        
        .footer-links {
            padding: 0;
            list-style: none;
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
            color: var(--accent-color);
            padding-left: 5px;
        }
        
        .contact-info {
            display: flex;
            margin-bottom: 15px;
        }
        
        .contact-info i {
            width: 30px;
            color: var(--accent-color);
            margin-right: 10px;
        }
        
        .footer-bottom {
            background-color: rgba(0,0,0,0.2);
            padding: 20px 0;
            margin-top: 40px;
            text-align: center;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <img src="{{ asset('img/logo_qinna.png') }}" alt="Logo Pondok Pesantren">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('home') }}">Beranda</a>
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
                </ul>
                <div class="ms-lg-3">
                    @if(auth()->check())
                        <a href="{{ route('dashboard') }}" class="btn btn-auth">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-auth">Login</a>
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <!-- Berita Header -->
    <section class="berita-header">
        <div class="container">
            <h1 class="berita-title">{{ $berita->judul }}</h1>
            <div class="berita-date">
                <i class="bi bi-calendar-event"></i>
                <span>{{ \Carbon\Carbon::parse($berita->tanggal)->format('d F Y') }}</span>
            </div>
        </div>
    </section>

    <!-- Berita Content -->
    <section class="container mb-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <img src="{{ asset($berita->image) }}" alt="{{ $berita->judul }}" class="berita-image">
                
                <div class="berita-summary">
                    {{ $berita->ringkasan }}
                </div>
                
                <div class="berita-content">
                    {!! nl2br(e($berita->konten)) !!}
                </div>
                
                <a href="{{ route('home') }}" class="back-btn">
                    <i class="bi bi-arrow-left"></i> Kembali ke Beranda
                </a>
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
                        <li><a href="{{ route('home') }}">Beranda</a></li>
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