<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@yield('title', 'Dashboard') - Ponpes</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
        <!-- SweetAlert2 CSS -->
        <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
        <!-- Favicon -->
        <link rel="icon" type="image/png" href="{{ asset('img/logo_qinna.png') }}">
        <style>
            body {
                min-height: 100vh;
                display: flex;
                overflow: hidden;
            }

            .sidebar {
                width: 280px;
                height: 100vh;
                background: #02361A;
                box-shadow: 0 0 10px rgba(0, 0, 0, .1);
                display: flex;
                flex-direction: column;
                position: fixed;
                top: 0;
                left: 0;
                z-index: 1000;
                transition: all 0.3s ease;
            }

            .sidebar.collapsed {
                left: -280px;
            }

            .sidebar-logo {
                text-align: center;
                padding: 1rem;
            }

            .sidebar-logo img {
                max-width: 150px;
                height: auto;
                margin-bottom: 1rem;
            }

            .welcome-text {
                text-align: center;
                padding: 0 1rem 1rem;
                border-bottom: 1px solid rgba(255, 255, 255, 0.2);
                color: white;
            }

            .welcome-text h6 {
                margin-bottom: 0.5rem;
                font-weight: 600;
                color: white;
            }

            .welcome-text p {
                margin-bottom: 0;
                font-size: 0.9rem;
                color: rgba(255, 255, 255, 0.95);
            }

            @media (max-width: 767.98px) {
                .sidebar {
                    left: -280px;
                }

                .content {
                    margin-left: 0;
                }

                .sidebar.show {
                    left: 0;
                }
            }

            .sidebar-sticky {
                flex: 1;
                overflow-x: hidden;
                overflow-y: auto;
                padding: 1rem;
                scrollbar-width: none; /* Firefox */
                -ms-overflow-style: none; /* Internet Explorer dan Edge */
            }

            /* Untuk Webkit (Chrome, Safari, dll) */
            .sidebar-sticky::-webkit-scrollbar {
                display: none;
            }

            .nav-item {
                margin-bottom: 0.5rem;
            }

            .nav-link {
                color: rgba(255, 255, 255, 0.95);
                font-weight: 500;
                padding: 0.75rem 1rem;
                border-radius: 0.25rem;
                transition: all 0.3s ease;
                position: relative;
            }

            .nav-link.main-menu {
                background: rgba(2, 54, 26, 0.3);
                margin-bottom: 0.25rem;
                color: white;
                font-weight: 600;
            }

            .nav-link.main-menu:hover,
            .nav-link.main-menu.active {
                background: #058B42;
                color: white;
            }

            .nav-link:hover {
                background: rgba(255, 255, 255, 0.1);
                color: white;
            }

            .nav-link.active {
                background: rgba(255, 255, 255, 0.2);
                color: white;
                font-weight: 600;
            }

            .nav-link i {
                width: 20px;
                text-align: center;
                margin-right: 8px;
            }

            .submenu {
                padding-left: 1rem;
                margin-top: 0.25rem;
                margin-bottom: 0.5rem;
                border-left: 1px solid rgba(255, 255, 255, 0.1);
            }

            .submenu .nav-link {
                font-size: 0.9rem;
                padding: 0.5rem 1rem;
                color: rgba(255, 255, 255, 0.9);
                font-weight: 500;
            }

            .submenu .nav-link:hover {
                background: #058B42;
                color: white;
            }

            .submenu .nav-link.active {
                background: #058B42;
                color: white;
                font-weight: 600;
            }

            .bi-chevron-down {
                transition: transform 0.3s ease;
            }

            [aria-expanded="true"] .bi-chevron-down {
                transform: rotate(180deg);
            }

            .content {
                flex: 1;
                margin-left: 280px;
                overflow-y: auto;
                height: 100vh;
                transition: all 0.3s ease;
                background: #f8f9fa;
            }

            .content.expanded {
                margin-left: 0;
            }

            .sidebar-toggle {
                position: fixed;
                left: 280px;
                top: 0;
                z-index: 1001;
                transition: all 0.3s ease;
                background: #058B42;
                color: white;
                border: none;
                width: 50px;
                height: 50px;
                border-radius: 0;
                display: flex;
                align-items: center;
                justify-content: center;
                cursor: pointer;
            }

            .sidebar-toggle.collapsed {
                left: 0;
            }

            .sidebar-toggle:hover {
                background: #058B42;
            }

            /* Card Styles */
            .border-left-primary {
                border-left: 4px solid #058B42 !important;
            }
            
            .border-left-success {
                border-left: 4px solid #058B42 !important;
            }
            
            .border-left-info {
                border-left: 4px solid #058B42 !important;
            }
            
            .border-left-warning {
                border-left: 4px solid #058B42 !important;
            }

            .text-primary {
                color: #058B42 !important;
            }

            .bg-primary {
                background-color: #058B42 !important;
            }

            .btn-primary {
                background-color: #0d6efd;
                border-color: #0d6efd;
            }

            .btn-primary:hover {
                background-color: #0b5ed7;
                border-color: #0a58ca;
            }

            .sidebar-footer {
                padding: 1rem;
                border-top: 1px solid rgba(255, 255, 255, 0.1);
            }

            .logout-btn {
                width: 100%;
                color: white;
                background: rgba(255, 255, 255, 0.1);
                border: none;
                padding: 0.5rem;
                border-radius: 0.25rem;
                text-align: left;
                transition: all 0.3s ease;
            }

            .logout-btn:hover {
                background: rgba(255, 255, 255, 0.2);
            }

            .navbar {
                position: sticky;
                top: 0;
                z-index: 999;
            }

            /* Breadcrumb Styles */
            .page-header {
                padding: 1rem 0;
                margin-bottom: 1rem;
            }

            .breadcrumb-navigation {
                display: flex;
                align-items: center;
                gap: 0.5rem;
            }

            .back-button {
                color: #058B42;
                text-decoration: none;
                display: inline-flex;
                align-items: center;
                padding: 0.5rem 0;
                transition: all 0.3s ease;
            }

            .back-button:hover {
                color: #02361A;
            }

            .breadcrumb {
                margin: 0;
                padding: 0;
                background: none;
                display: flex;
                align-items: center;
                gap: 0.5rem;
            }

            .breadcrumb-item {
                color: #6c757d;
                font-size: 1rem;
            }

            .breadcrumb-item a {
                color: #058B42;
                text-decoration: none;
                transition: all 0.3s ease;
            }

            .breadcrumb-item a:hover {
                color: #02361A;
            }

            .breadcrumb-item.active {
                color: #343a40;
                font-weight: 600;
            }

            .breadcrumb-item + .breadcrumb-item::before {
                content: "/";
                color: #6c757d;
            }

            .sidebar-nav .nav-link:hover,
            .sidebar-nav .nav-link.active {
                background: #058B42;
                color: white;
            }

            .sidebar-nav .nav-link.active i {
                color: white;
            }

            .sidebar-nav .nav-link:hover i {
                color: white;
            }

            /* Styling untuk menu Saldo */
            .nav-link.main-menu {
                padding: 0.8rem 1rem;
                color: rgba(255, 255, 255, 0.95);
                transition: all 0.3s ease;
            }
            
            .nav-link.main-menu:hover,
            .nav-link.main-menu[aria-expanded="true"] {
                background: #058B42;
                color: white;
            }

            .nav-link.main-menu .bi-chevron-down {
                transition: transform 0.3s ease;
            }

            .nav-link.main-menu[aria-expanded="true"] .bi-chevron-down {
                transform: rotate(180deg);
            }

            /* Styling untuk submenu */
            .submenu {
                padding-left: 1rem;
                background: transparent;
                border-left: 1px solid rgba(255, 255, 255, 0.1);
            }

            .submenu .nav-link {
                padding: 0.7rem 1rem;
                color: rgba(255, 255, 255, 0.9);
                transition: all 0.3s ease;
                border-radius: 0.375rem;
                margin: 0.2rem 0;
            }

            .submenu .nav-link:hover {
                background: #058B42;
                color: white;
                padding-left: 1.25rem;
            }

            .submenu .nav-link.active {
                background: #058B42;
                color: white;
                font-weight: 500;
            }

            /* Memastikan lebar submenu sesuai */
            .submenu .nav-item {
                min-width: 200px;
            }

            /* Memastikan ikon selalu putih */
            .nav-link i,
            .submenu .nav-link i {
                color: rgba(255, 255, 255, 0.95);
            }

            .nav-link:hover i,
            .submenu .nav-link:hover i,
            .nav-link.active i,
            .submenu .nav-link.active i {
                color: white;
            }
        </style>
        @stack('styles')
    </head>
    <body>
        <!-- Sidebar Toggle Button -->
        <button class="sidebar-toggle" id="sidebarToggle">
            <i class="bi bi-list" id="toggleIcon"></i>
        </button>

        <!-- Sidebar -->
        <nav class="sidebar" id="sidebar">
            <div class="sidebar-logo">
                <img src="{{ asset('img/logo_qinna.png') }}" alt="Logo Ponpes" class="img-fluid">
                <div class="welcome-text">
                    <h6>Assalamualaikum</h6>
                    <p>Selamat Datang</p>
                </div>
            </div>

            <div class="sidebar-sticky">
                <ul class="nav flex-column">
                @if(auth()->user()->isAdmin())
                    <li class="nav-item">
                        <a href="{{ route('dashboard') }}" class="nav-link main-menu {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                            <i class="bi bi-speedometer2 me-2"></i>
                            Dashboard
                        </a>
                    </li>
                @endif

                <!-- Pengaturan - Semua role dapat mengakses -->
                <li class="nav-item">
                    <a href="#pengaturanSubmenu" data-bs-toggle="collapse" class="nav-link main-menu {{ request()->routeIs('users.*') || request()->routeIs('roles.*') || request()->routeIs('profile.*') ? 'active' : '' }}">
                        <i class="bi bi-gear me-2"></i>
                        Pengaturan
                        <i class="bi bi-chevron-down float-end"></i>
                    </a>
                    <div class="collapse {{ request()->routeIs('users.*') || request()->routeIs('roles.*') || request()->routeIs('profile.*') ? 'show' : '' }}" id="pengaturanSubmenu">
                        <ul class="nav flex-column submenu">
                            <li class="nav-item">
                                <a href="{{ route('profile.edit') }}" class="nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">Profile</a>
                            </li>
                            @if(auth()->user()->isAdmin())
                            <li class="nav-item">
                                <a href="{{ route('users.index') }}" class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}">Manajemen User</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('roles.index') }}" class="nav-link {{ request()->routeIs('roles.*') ? 'active' : '' }}">Manajemen Role</a>
                            </li>
                            @endif
                        </ul>
                    </div>
                </li>
          
                <!-- Koperasi - Only visible for Koperasi -->
                @if(auth()->user()->isKoperasi())
                        <li class="nav-item">
                            <a href="{{ route('koperasi.index') }}" class="nav-link main-menu {{ request()->routeIs('koperasi.*') ? 'active' : '' }}">
                                <i class="bi bi-shop me-2"></i>
                                Koperasi
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('kantin.index') }}" class="nav-link main-menu {{ request()->routeIs('koperasi.*') ? 'active' : '' }}">
                                <i class="bi bi-shop me-2"></i>
                                Kantin
                            </a>
                        </li>
                        <li class="nav-item">
                        <a href="#supplySubmenu" data-bs-toggle="collapse" class="nav-link main-menu {{ request()->routeIs('supply.*') ? 'active' : '' }}">
                            <i class="bi bi-box-seam me-2"></i>
                            Supply
                            <i class="bi bi-chevron-down float-end"></i>
                        </a>
                        <div class="collapse {{ request()->routeIs('supply.*') ? 'show' : '' }}" id="supplySubmenu">
                            <ul class="nav flex-column submenu">
                                <li class="nav-item">
                                    <a href="{{ route('supply.index', ['kategori' => 'koperasi']) }}" class="nav-link {{ request()->routeIs('supply.*') && request()->query('kategori') == 'koperasi' ? 'active' : '' }}">
                                        <i class="bi bi-shop me-2"></i>
                                        Koperasi
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                @endif

                @if(!auth()->user()->isKoperasi())
                    <!-- Master Data -->
                    @if(!auth()->user()->isSantri())
                    <li class="nav-item">
                        <a href="#masterDataSubmenu" data-bs-toggle="collapse" class="nav-link main-menu {{ request()->routeIs('pengajar.*') || request()->routeIs('santri.*') || request()->routeIs('pengurus.*') || request()->routeIs('divisi.*') || request()->routeIs('koperasi.*') || request()->routeIs('saldo.*') || request()->routeIs('tabungan.*') || request()->routeIs('berita.*') ? 'active' : '' }}">
                            <i class="bi bi-database me-2"></i>
                            Master Data
                            <i class="bi bi-chevron-down float-end"></i>
                        </a>
                        <div class="collapse {{ request()->routeIs('pengajar.*') || request()->routeIs('santri.*') || request()->routeIs('pengurus.*') || request()->routeIs('divisi.*') || request()->routeIs('koperasi.*') || request()->routeIs('saldo.*') || request()->routeIs('tabungan.*') || request()->routeIs('berita.*') ? 'show' : '' }}" id="masterDataSubmenu">
                            <ul class="nav flex-column submenu">
                                <li class="nav-item">
                                    <a href="{{ route('berita.index') }}" class="nav-link {{ request()->routeIs('berita.*') ? 'active' : '' }}">Berita</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('pengajar.index') }}" class="nav-link {{ request()->routeIs('pengajar.*') ? 'active' : '' }}">Pengajar</a>
                                </li>
                                <li class="nav-item">
                                    <a href="#santriSubmenu" data-bs-toggle="collapse" class="nav-link {{ request()->routeIs('santri.*') || request()->routeIs('tingkatan.*') || request()->routeIs('kamar.*') || request()->routeIs('komplek.*') || request()->routeIs('ruang-kelas.*') ? 'active' : '' }}">
                                        Santri
                                        <i class="bi bi-chevron-down float-end"></i>
                                    </a>
                                    <div class="collapse {{ request()->routeIs('santri.*') || request()->routeIs('tingkatan.*') || request()->routeIs('kamar.*') || request()->routeIs('komplek.*') || request()->routeIs('ruang-kelas.*') ? 'show' : '' }}" id="santriSubmenu">
                                        <ul class="nav flex-column submenu">
                                            <li class="nav-item">
                                                <a href="{{ route('santri.index') }}" class="nav-link {{ request()->routeIs('santri.*') ? 'active' : '' }}">Data Santri</a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="{{ route('tingkatan.index') }}" class="nav-link {{ request()->routeIs('tingkatan.*') ? 'active' : '' }}">Tingkatan</a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="{{ route('kamar.index') }}" class="nav-link {{ request()->routeIs('kamar.*') ? 'active' : '' }}">Kamar</a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="{{ route('komplek.index') }}" class="nav-link {{ request()->routeIs('komplek.*') ? 'active' : '' }}">Komplek</a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="{{ route('ruang-kelas.index') }}" class="nav-link {{ request()->routeIs('ruang-kelas.*') ? 'active' : '' }}">Ruang Kelas</a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('pengurus.index') }}" class="nav-link {{ request()->routeIs('pengurus.*') ? 'active' : '' }}">Pengurus</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('divisi.index') }}" class="nav-link {{ request()->routeIs('divisi.*') ? 'active' : '' }}">Divisi</a>
                                </li>
                                <li class="nav-item">
                                    <a href="#koperasiSubmenu" data-bs-toggle="collapse" class="nav-link {{ request()->routeIs('data-koperasi.*') || request()->routeIs('supply.*') ? 'active' : '' }}">
                                        Koperasi
                                        <i class="bi bi-chevron-down float-end"></i>
                                    </a>
                                    <div class="collapse {{ request()->routeIs('data-koperasi.*') || request()->routeIs('supply.*') ? 'show' : '' }}" id="koperasiSubmenu">
                                        <ul class="nav flex-column submenu">
                                            <li class="nav-item">
                                                <a href="{{ route('data-koperasi.index') }}" class="nav-link {{ request()->routeIs('data-koperasi.*') ? 'active' : '' }}">Data Koperasi</a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="{{ route('supplier.index') }}" class="nav-link {{ request()->routeIs('supplier.*') ? 'active' : '' }}">Data Supplier</a>
                                            </li>
                                            @if(auth()->user()->isOperator())
                                            <li class="nav-item">
                                                <a href="{{ route('supply.index', ['kategori' => 'koperasi']) }}" class="nav-link {{ request()->routeIs('supply.*') && request()->query('kategori') == 'koperasi' ? 'active' : '' }}">Supply</a>
                                            </li>
                                            @endif
                                        </ul>
                                    </div>
                                </li>
                                <!-- Menu Pembayaran -->
                                <li class="nav-item">
                                    <a href="#pembayaranSubmenu" data-bs-toggle="collapse" class="nav-link {{ request()->routeIs('pembayaran-pondok.*') || request()->routeIs('pembayaran-kamar.*') || request()->routeIs('pembayaran-ruang-kelas.*') || request()->routeIs('pembayaran-tingkatan.*') || request()->routeIs('pembayaran-komplek.*') || request()->routeIs('pembayaran-auto.*') ? 'active' : '' }}">
                                        Pembayaran
                                        <i class="bi bi-chevron-down float-end"></i>
                                    </a>
                                    <div class="collapse {{ request()->routeIs('pembayaran-pondok.*') || request()->routeIs('pembayaran-kamar.*') || request()->routeIs('pembayaran-ruang-kelas.*') || request()->routeIs('pembayaran-tingkatan.*') || request()->routeIs('pembayaran-komplek.*') || request()->routeIs('pembayaran-auto.*') ? 'show' : '' }}" id="pembayaranSubmenu">
                                        <ul class="nav flex-column submenu">
                                            <li class="nav-item">
                                                <a href="{{ route('pembayaran-pondok.index') }}" class="nav-link {{ request()->routeIs('pembayaran-pondok.*') ? 'active' : '' }}">Pembayaran Pondok</a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="{{ route('pembayaran-kamar.index') }}" class="nav-link {{ request()->routeIs('pembayaran-kamar.*') ? 'active' : '' }}">Pembayaran Kamar</a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="{{ route('pembayaran-ruang-kelas.index') }}" class="nav-link {{ request()->routeIs('pembayaran-ruang-kelas.*') ? 'active' : '' }}">Pembayaran Ruang Kelas</a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="{{ route('pembayaran-tingkatan.index') }}" class="nav-link {{ request()->routeIs('pembayaran-tingkatan.*') ? 'active' : '' }}">Pembayaran Tingkatan</a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="{{ route('pembayaran-komplek.index') }}" class="nav-link {{ request()->routeIs('pembayaran-komplek.*') ? 'active' : '' }}">Pembayaran Komplek</a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="{{ route('pembayaran-auto.index') }}" class="nav-link {{ request()->routeIs('pembayaran-auto.*') ? 'active' : '' }}">Pembayaran Otomatis</a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                                <!-- Menu Saldo dan Tabungan dihapus -->
                                <li class="nav-item">
                                    <a class="nav-link main-menu d-flex align-items-center justify-content-between" data-bs-toggle="collapse" href="#saldoMenu" role="button" 
                                        aria-expanded="{{ request()->routeIs('cek-saldo.*') || request()->routeIs('histori-saldo.*') || request()->routeIs('histori-belanja.*') ? 'true' : 'false' }}" 
                                        aria-controls="saldoMenu">
                                        <div>
                                            <i class="bi bi-wallet2 me-2"></i>
                                            <span>Transaksi</span>
                                        </div>
                                        <i class="bi bi-chevron-down"></i>
                                    </a>
                                    <div class="collapse {{ request()->routeIs('cek-saldo.*') || request()->routeIs('histori-saldo.*') || request()->routeIs('histori-belanja.*') ? 'show' : '' }}" id="saldoMenu">
                                        <ul class="nav submenu">
                                            <li class="nav-item w-100">
                                                <a href="{{ route('cek-saldo.index') }}" class="nav-link d-flex align-items-center {{ request()->routeIs('cek-saldo.*') ? 'active' : '' }}">
                                                    <i class="bi bi-cash me-2"></i>
                                                    <span>Cek Saldo</span>
                                                </a>
                                            </li>
                                            <li class="nav-item w-100">
                                                <a href="{{ route('histori-saldo.index') }}" class="nav-link d-flex align-items-center {{ request()->routeIs('histori-saldo.*') ? 'active' : '' }}">
                                                    <i class="bi bi-clock-history me-2"></i>
                                                    <span>Top Up Saldo</span>
                                                </a>
                                            </li>
                                            @if(auth()->user()->isOperator())
                                            <li class="nav-item w-100">
                                                <a href="{{ route('tarik-tunai.index') }}" class="nav-link d-flex align-items-center {{ request()->routeIs('tarik-tunai.*') ? 'active' : '' }}">
                                                    <i class="bi bi-cash-stack me-2"></i>
                                                    <span>Tarik Tunai</span>
                                                </a>
                                            </li>
                                            @endif
                                            <li class="nav-item w-100">
                                                <a href="{{ route('histori-belanja.index') }}" class="nav-link d-flex align-items-center {{ request()->routeIs('histori-belanja.*') ? 'active' : '' }}">
                                                    <i class="bi bi-cart-check me-2"></i>
                                                    <span>Histori Belanja</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </li>
                    @endif
                   
                    
                    <!-- Akun Menu -->
                                <li class="nav-item">
                        <a class="nav-link main-menu d-flex align-items-center justify-content-between" data-bs-toggle="collapse" href="#akunMenu" role="button" 
                            aria-expanded="{{ request()->routeIs('akun-belanja.*') || request()->routeIs('akun-utama.*') || request()->routeIs('akun-tabungan.*') ? 'true' : 'false' }}" 
                            aria-controls="akunMenu">
                            <div>
                                <i class="bi bi-person-circle me-2"></i>
                                <span>Akun</span>
                            </div>
                            <i class="bi bi-chevron-down"></i>
                        </a>
                        <div class="collapse {{ request()->routeIs('akun-belanja.*') || request()->routeIs('akun-utama.*') || request()->routeIs('akun-tabungan.*') ? 'show' : '' }}" id="akunMenu">
                            <ul class="nav submenu">
                                <li class="nav-item w-100">
                                    <a href="{{ route('akun-belanja.index') }}" class="nav-link d-flex align-items-center {{ request()->routeIs('akun-belanja.*') ? 'active' : '' }}">
                                        <i class="bi bi-cart me-2"></i>
                                        <span>Akun Belanja</span>
                                    </a>
                                </li>
                                <li class="nav-item w-100">
                                    <a href="{{ route('akun-utama.index') }}" class="nav-link d-flex align-items-center {{ request()->routeIs('akun-utama.*') ? 'active' : '' }}">
                                        <i class="bi bi-person me-2"></i>
                                        <span>Akun Utama</span>
                                    </a>
                                </li>
                                <li class="nav-item w-100">
                                    <a href="{{ route('akun-tabungan.index') }}" class="nav-link d-flex align-items-center {{ request()->routeIs('akun-tabungan.*') ? 'active' : '' }}">
                                        <i class="bi bi-piggy-bank me-2"></i>
                                        <span>Akun Tabungan</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    
                    <!-- Transaksi Menu - Hanya untuk non-admin -->
                    @if(!auth()->user()->isAdmin())
                    <li class="nav-item">
                        <a class="nav-link main-menu d-flex align-items-center justify-content-between" data-bs-toggle="collapse" href="#transaksiMenu" role="button" 
                            aria-expanded="{{ request()->routeIs('cek-saldo.*') || request()->routeIs('histori-saldo.*') || request()->routeIs('histori-belanja.*') || request()->routeIs('topup.*') || request()->routeIs('tarik-tunai.*') ? 'true' : 'false' }}" 
                            aria-controls="transaksiMenu">
                            <div>
                                <i class="bi bi-cash-coin me-2"></i>
                                <span>Transaksi</span>
                            </div>
                            <i class="bi bi-chevron-down"></i>
                        </a>
                        <div class="collapse {{ request()->routeIs('cek-saldo.*') || request()->routeIs('histori-saldo.*') || request()->routeIs('histori-belanja.*') || request()->routeIs('topup.*') || request()->routeIs('tarik-tunai.*') ? 'show' : '' }}" id="transaksiMenu">
                            <ul class="nav submenu">
                                <li class="nav-item w-100">
                                    <a href="{{ route('cek-saldo.index') }}" class="nav-link d-flex align-items-center {{ request()->routeIs('cek-saldo.*') ? 'active' : '' }}">
                                        <i class="bi bi-wallet me-2"></i>
                                        <span>Cek Saldo</span>
                                    </a>
                                </li>
                                <li class="nav-item w-100">
                                    <a href="{{ route('histori-saldo.index') }}" class="nav-link d-flex align-items-center {{ request()->routeIs('histori-saldo.*') ? 'active' : '' }}">
                                        <i class="bi bi-clock-history me-2"></i>
                                        <span>Histori Saldo</span>
                                    </a>
                                </li>
                                <li class="nav-item w-100">
                                    <a href="{{ route('histori-belanja.index') }}" class="nav-link d-flex align-items-center {{ request()->routeIs('histori-belanja.*') ? 'active' : '' }}">
                                        <i class="bi bi-bag-check me-2"></i>
                                        <span>Histori Belanja</span>
                                    </a>
                                </li>
                                @if(auth()->user()->isOperator())
                                <li class="nav-item w-100">
                                    <a href="{{ route('topup.index') }}" class="nav-link d-flex align-items-center {{ request()->routeIs('topup.*') ? 'active' : '' }}">
                                        <i class="bi bi-plus-circle me-2"></i>
                                        <span>Top Up</span>
                                    </a>
                                </li>
                                <li class="nav-item w-100">
                                    <a href="{{ route('tarik-tunai.index') }}" class="nav-link d-flex align-items-center {{ request()->routeIs('tarik-tunai.*') ? 'active' : '' }}">
                                        <i class="bi bi-cash me-2"></i>
                                        <span>Tarik Tunai</span>
                                    </a>
                                </li>
                                @endif
                            </ul>
                        </div>
                    </li>
                    @endif
                    
                    <!-- Transfer Menu - Only visible for Santri -->
                    @if(auth()->user()->isSantri())
                    <li class="nav-item">
                        <a href="{{ route('transfer.index') }}" class="nav-link main-menu {{ request()->routeIs('transfer.*') ? 'active' : '' }}">
                            <i class="bi bi-arrow-left-right me-2"></i>
                            Transfer
                        </a>
                    </li>
                    @endif
                    
                    <!-- Laporan Menu -->
                    @if(auth()->user()->isAdmin() || auth()->user()->isOperator())
                    <li class="nav-item">
                        <a class="nav-link main-menu d-flex align-items-center justify-content-between" data-bs-toggle="collapse" href="#laporanMenu" role="button" 
                            aria-expanded="{{ request()->routeIs('laporan-transaksi.*') || request()->routeIs('laporan-pembayaran.*') || request()->routeIs('laporan-tarik-tunai.*') || request()->routeIs('laporan-akun-saldo.*') || request()->routeIs('laporan-pembayaran-santri.*') ? 'true' : 'false' }}" 
                            aria-controls="laporanMenu">
                            <div>
                                <i class="bi bi-file-earmark-text me-2"></i>
                                <span>Laporan</span>
                            </div>
                            <i class="bi bi-chevron-down"></i>
                        </a>
                        <div class="collapse {{ request()->routeIs('laporan-transaksi.*') || request()->routeIs('laporan-pembayaran.*') || request()->routeIs('laporan-tarik-tunai.*') || request()->routeIs('laporan-akun-saldo.*') || request()->routeIs('laporan-pembayaran-santri.*') ? 'show' : '' }}" id="laporanMenu">
                            <ul class="nav submenu">
                                <li class="nav-item w-100">
                                    <a href="{{ route('laporan-transaksi.index') }}" class="nav-link d-flex align-items-center {{ request()->routeIs('laporan-transaksi.*') ? 'active' : '' }}">
                                        <i class="bi bi-receipt me-2"></i>
                                        <span>Laporan Transaksi Santri</span>
                                    </a>
                                </li>
                                <li class="nav-item w-100">
                                    <a href="{{ route('laporan-pembayaran.index') }}" class="nav-link d-flex align-items-center {{ request()->routeIs('laporan-pembayaran.*') ? 'active' : '' }}">
                                        <i class="bi bi-cart-check me-2"></i>
                                        <span>Laporan Pembelanjaan Santri</span>
                                    </a>
                                </li>
                                <li class="nav-item w-100">
                                    <a href="{{ route('laporan-pembayaran-santri.index') }}" class="nav-link d-flex align-items-center {{ request()->routeIs('laporan-pembayaran-santri.*') ? 'active' : '' }}">
                                        <i class="bi bi-receipt-cutoff me-2"></i>
                                        <span>Laporan Pembayaran Santri</span>
                                    </a>
                                </li>
                                <li class="nav-item w-100">
                                    <a href="{{ route('laporan-tarik-tunai.index') }}" class="nav-link d-flex align-items-center {{ request()->routeIs('laporan-tarik-tunai.*') ? 'active' : '' }}">
                                        <i class="bi bi-cash-coin me-2"></i>
                                        <span>Laporan Tarik Tunai</span>
                                    </a>
                                </li>
                                <li class="nav-item w-100">
                                    <a href="{{ route('laporan-akun-saldo.index') }}" class="nav-link d-flex align-items-center {{ request()->routeIs('laporan-akun-saldo.*') ? 'active' : '' }}">
                                        <i class="bi bi-wallet me-2"></i>
                                        <span>Laporan Akun dan Saldo</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    @endif
                    @endif
                </ul>
            </div>

            <!-- Logout Button -->
            <div class="sidebar-footer">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="logout-btn">
                        <i class="bi bi-box-arrow-right me-2"></i>
                        Logout
                    </button>
                </form>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="content">
            <nav class="navbar navbar-expand-md navbar-light bg-white border-bottom">
                <div class="container-fluid">
                    <button class="btn btn-link d-md-none" onclick="toggleSidebar()">
                        <i class="bi bi-list"></i>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarNav">
                        <!-- Kosongkan bagian kiri navbar -->
                        <ul class="navbar-nav me-auto">
                        </ul>
                        <!-- Item navbar di kanan -->
                        <ul class="navbar-nav align-items-center">
                            <li class="nav-item">
                                <a class="nav-link" href="#">About</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Help</a>
                            </li>
                            <li class="nav-item">
                                <span class="nav-link">
                                    <span class="text-muted">{{ Auth::user()->name }}</span>
                                </span>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>

            <div class="container-fluid py-4">
                <!-- Page Header with Breadcrumb -->
                <div class="page-header">
                    <div class="d-flex align-items-center">
                        @php
                            $hideBackButton = in_array(request()->route()->getName(), ['kantin.index', 'koperasi.index']);
                        @endphp
                        @unless($hideBackButton)
                        <a href="javascript:history.back()" class="back-button">
                            <i class="bi bi-arrow-left"></i>
                        </a>
                        @endunless
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0">
                                @php
                                    $currentRoute = request()->route()->getName();
                                    $routeParts = explode('.', $currentRoute);
                                    $breadcrumbs = [];
                                    
                                    // Tentukan struktur breadcrumb berdasarkan route
                                    if (in_array($routeParts[0], ['santri', 'tingkatan', 'kompleks-kamar'])) {
                                        $breadcrumbs[] = ['title' => 'Master Data', 'route' => '#'];
                                        $breadcrumbs[] = ['title' => 'Santri', 'route' => 'santri.index'];
                                    } elseif ($routeParts[0] === 'pengurus') {
                                        $breadcrumbs[] = ['title' => 'Master Data', 'route' => '#'];
                                        $breadcrumbs[] = ['title' => 'Pengurus', 'route' => 'pengurus.index'];
                                    } elseif ($routeParts[0] === 'pengajar') {
                                        $breadcrumbs[] = ['title' => 'Master Data', 'route' => '#'];
                                        $breadcrumbs[] = ['title' => 'Pengajar', 'route' => 'pengajar.index'];
                                    } elseif ($routeParts[0] === 'divisi') {
                                        $breadcrumbs[] = ['title' => 'Master Data', 'route' => '#'];
                                        $breadcrumbs[] = ['title' => 'Divisi', 'route' => 'divisi.index'];
                                    }
                                    
                                    // Tambahkan judul halaman saat ini
                                    if (isset($routeParts[1])) {
                                        switch ($routeParts[1]) {
                                            case 'create':
                                                $breadcrumbs[] = ['title' => 'Tambah Data', 'route' => '#'];
                                                break;
                                            case 'edit':
                                                $breadcrumbs[] = ['title' => 'Edit Data', 'route' => '#'];
                                                break;
                                            case 'show':
                                                $breadcrumbs[] = ['title' => 'Detail Data', 'route' => '#'];
                                                break;
                                            default:
                                                if ($routeParts[0] === 'tingkatan') {
                                                    $breadcrumbs[] = ['title' => 'Tingkatan', 'route' => '#'];
                                                } elseif ($routeParts[0] === 'kompleks-kamar') {
                                                    $breadcrumbs[] = ['title' => 'Kamar', 'route' => '#'];
                                                }
                                                break;
                                        }
                                    }
                                @endphp

                                @foreach($breadcrumbs as $key => $breadcrumb)
                                    <li class="breadcrumb-item {{ $loop->last ? 'active fw-bold' : '' }}">
                                        @if($loop->last || $breadcrumb['route'] === '#')
                                            {{ $breadcrumb['title'] }}
                                        @else
                                            <a href="{{ route($breadcrumb['route']) }}" class="text-success">
                                                {{ $breadcrumb['title'] }}
                                            </a>
                                        @endif
                                    </li>
                                @endforeach
                            </ol>
                        </nav>
                    </div>
                </div>
                @yield('content')
            </div>
        </main>

        <!-- Bootstrap Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- jQuery -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <!-- SweetAlert2 JS -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        
        <!-- Custom Sweet Alert Config -->
        <script>
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
            });

            @if(session('success'))
                Toast.fire({
                    icon: 'success',
                    title: "{{ session('success') }}"
                });
            @endif

            @if(session('error'))
                Toast.fire({
                    icon: 'error',
                    title: "{{ session('error') }}"
                });
            @endif

            @if(session('warning'))
                Toast.fire({
                    icon: 'warning',
                    title: "{{ session('warning') }}"
                });
            @endif

            @if(session('info'))
                Toast.fire({
                    icon: 'info',
                    title: "{{ session('info') }}"
                });
            @endif

            function toggleSidebar() {
                document.getElementById('sidebar').classList.toggle('show');
            }

            // Fungsi untuk konfirmasi hapus
            function confirmDelete(formId) {
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Data yang dihapus tidak dapat dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById(formId).submit();
                    }
                });
                return false;
            }
            // Fungsi untuk toggle sidebar
            document.getElementById('sidebarToggle').addEventListener('click', function() {
                const sidebar = document.getElementById('sidebar');
                const content = document.querySelector('.content');
                const toggleBtn = document.getElementById('sidebarToggle');
                
                sidebar.classList.toggle('collapsed');
                content.classList.toggle('expanded');
                toggleBtn.classList.toggle('collapsed');
            });
        </script>

        @push('scripts')
        <script>
            $(document).ready(function() {
                // Fungsi untuk menyimpan status menu ke localStorage
                function saveMenuState(key, value) {
                    localStorage.setItem(key, JSON.stringify(value));
                }

                // Fungsi untuk mendapatkan status menu dari localStorage
                function getMenuState(key) {
                    const state = localStorage.getItem(key);
                    return state ? JSON.parse(state) : null;
                }

                // Fungsi untuk mengatur status menu aktif
                function setActiveMenu() {
                    const currentRoute = '{{ request()->route()->getName() }}';
                    const routeBase = currentRoute.split('.')[0];

                    // Definisi struktur menu
                    const menuStructure = {
                        'santri': ['tingkatan', 'kamar', 'komplek'],
                        'pengurus': [],
                        'pengajar': [],
                        'divisi': [],
                        'koperasi': [],
                        'saldo': [],
                        'tabungan': []
                    };

                    // Cek apakah route saat ini adalah bagian dari menu Santri
                    if (routeBase === 'santri' || menuStructure['santri'].includes(routeBase)) {
                        // Buka Master Data submenu
                        $('#masterDataSubmenu').addClass('show');
                        $('[href="#masterDataSubmenu"]').addClass('active');

                        // Buka Santri submenu
                        $('#santriSubmenu').addClass('show');
                        $('[href="#santriSubmenu"]').addClass('active');

                        // Simpan status
                        saveMenuState('masterDataSubmenu', true);
                        saveMenuState('santriSubmenu', true);

                        // Khusus untuk tingkatan dan kamar
                        if (routeBase === 'tingkatan' || routeBase === 'kamar' || routeBase === 'komplek') {
                            // Pastikan parent menu tetap terbuka
                            $('#masterDataSubmenu').addClass('show');
                            $('#santriSubmenu').addClass('show');
                            
                            // Tambahkan kelas active pada parent menu
                            $('[href="#masterDataSubmenu"]').addClass('active');
                            $('[href="#santriSubmenu"]').addClass('active');
                            
                            // Simpan state
                            saveMenuState('masterDataSubmenu', true);
                            saveMenuState('santriSubmenu', true);
                        }
                    }

                    // Aktifkan link yang sesuai
                    $('.nav-link').each(function() {
                        const href = $(this).attr('href');
                        if (href && href.includes(routeBase)) {
                            $(this).addClass('active');
                            
                            // Jika ini adalah link tingkatan atau kamar, cegah collapse
                            if (routeBase === 'tingkatan' || routeBase === 'kamar' || routeBase === 'komplek') {
                                $(this).on('click', function(e) {
                                    e.stopPropagation();
                                });
                            }
                        }
                    });
                }

                // Event listener untuk klik pada menu
                $('.nav-link[data-bs-toggle="collapse"]').on('click', function(e) {
                    const target = $(this).attr('data-bs-target').replace('#', '');
                    const isExpanded = !$(target).hasClass('show');
                    
                    // Jika menu yang diklik adalah parent dari tingkatan atau kamar
                    if (target === 'santriSubmenu' || target === 'masterDataSubmenu') {
                        const currentRoute = '{{ request()->route()->getName() }}';
                        const routeBase = currentRoute.split('.')[0];
                        
                        // Jika sedang di halaman tingkatan atau kamar, cegah collapse
                        if (routeBase === 'tingkatan' || routeBase === 'kamar' || routeBase === 'komplek') {
                            e.preventDefault();
                            e.stopPropagation();
                            return false;
                        }
                    }
                    
                    saveMenuState(target, isExpanded);
                });

                // Inisialisasi status menu saat halaman dimuat
                $('.collapse').each(function() {
                    const menuId = $(this).attr('id');
                    const savedState = getMenuState(menuId);
                    
                    if (savedState) {
                        $(this).addClass('show');
                        $(`[data-bs-target="#${menuId}"]`).addClass('active');
                    }
                });

                // Set menu aktif berdasarkan route saat ini
                setActiveMenu();

                // Sidebar toggle dengan penyimpanan state
                $('#sidebarToggle').click(function() {
                    const sidebar = $('#sidebar');
                    const content = $('.content');
                    const toggleBtn = $(this);
                    const isCollapsed = !sidebar.hasClass('collapsed');
                    
                    saveMenuState('sidebarCollapsed', isCollapsed);
                    
                    sidebar.toggleClass('collapsed');
                    content.toggleClass('expanded');
                    toggleBtn.toggleClass('collapsed');
                });

                // Inisialisasi status sidebar
                const sidebarCollapsed = getMenuState('sidebarCollapsed');
                if (sidebarCollapsed) {
                    $('#sidebar').addClass('collapsed');
                    $('.content').addClass('expanded');
                    $('#sidebarToggle').addClass('collapsed');
                }

                // Tambahkan event listener untuk mencegah collapse menu saat mengklik link aktif
                $('.nav-link').on('click', function(e) {
                    if ($(this).hasClass('active')) {
                        e.preventDefault();
                        e.stopPropagation();
                    }
                });
            });
        </script>
        @endpush
    </body>
</html>