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
        <style>
            body {
                min-height: 100vh;
                display: flex;
                overflow: hidden;
            }

            .sidebar {
                width: 280px;
                height: 100vh;
                background: #058B42;
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
                max-width: 100px;
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
                background: #02361A;
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
                background: rgba(255, 255, 255, 0.1);
                color: white;
            }

            .submenu .nav-link.active {
                background: rgba(255, 255, 255, 0.2);
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
                background: #02361A;
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
                background: #02361A;
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
                background-color: #058B42;
                border-color: #058B42;
            }

            .btn-primary:hover {
                background-color: #02361A;
                border-color: #02361A;
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
                <img src="{{ asset('img/logo.png') }}" alt="Logo Ponpes" class="img-fluid">
                <div class="welcome-text">
                    <h6>Assalamualaikum</h6>
                    <p>Selamat Datang</p>
                </div>
            </div>

            <div class="sidebar-sticky">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a href="{{ route('dashboard') }}" class="nav-link main-menu {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                            <i class="bi bi-speedometer2 me-2"></i>
                            Dashboard
                        </a>
                    </li>

                    <!-- Pengaturan -->
                    <li class="nav-item">
                        <a href="#pengaturanSubmenu" data-bs-toggle="collapse" class="nav-link main-menu {{ request()->routeIs('users.*') || request()->routeIs('roles.*') ? 'active' : '' }}">
                            <i class="bi bi-gear me-2"></i>
                            Pengaturan
                            <i class="bi bi-chevron-down float-end"></i>
                        </a>
                        <div class="collapse {{ request()->routeIs('users.*') || request()->routeIs('roles.*') ? 'show' : '' }}" id="pengaturanSubmenu">
                            <ul class="nav flex-column submenu">
                                <li class="nav-item">
                                    <a href="{{ route('users.index') }}" class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}">User</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('roles.index') }}" class="nav-link {{ request()->routeIs('roles.*') ? 'active' : '' }}">Hak User Role</a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <!-- Master Data -->
                    <li class="nav-item">
                        <a href="#masterDataSubmenu" data-bs-toggle="collapse" class="nav-link main-menu {{ request()->routeIs('pengajar.*') || request()->routeIs('santri.*') || request()->routeIs('mahrom.*') || request()->routeIs('pengurus.*') || request()->routeIs('divisi.*') || request()->routeIs('koperasi.*') || request()->routeIs('saldo.*') || request()->routeIs('tabungan.*') ? 'active' : '' }}">
                            <i class="bi bi-database me-2"></i>
                            Master Data
                            <i class="bi bi-chevron-down float-end"></i>
                        </a>
                        <div class="collapse {{ request()->routeIs('pengajar.*') || request()->routeIs('santri.*') || request()->routeIs('mahrom.*') || request()->routeIs('pengurus.*') || request()->routeIs('divisi.*') || request()->routeIs('koperasi.*') || request()->routeIs('saldo.*') || request()->routeIs('tabungan.*') ? 'show' : '' }}" id="masterDataSubmenu">
                            <ul class="nav flex-column submenu">
                                <li class="nav-item">
                                    <a href="{{ route('pengajar.index') }}" class="nav-link {{ request()->routeIs('pengajar.*') ? 'active' : '' }}">Pengajar</a>
                                </li>
                                <li class="nav-item">
                                    <a href="#santriSubmenu" data-bs-toggle="collapse" class="nav-link {{ request()->routeIs('santri.*') || request()->routeIs('tingkatan.*') ? 'active' : '' }}">
                                        Santri
                                        <i class="bi bi-chevron-down float-end"></i>
                                    </a>
                                    <div class="collapse {{ request()->routeIs('santri.*') || request()->routeIs('tingkatan.*') ? 'show' : '' }}" id="santriSubmenu">
                                        <ul class="nav flex-column submenu">
                                            <li class="nav-item">
                                                <a href="{{ route('santri.index') }}" class="nav-link {{ request()->routeIs('santri.*') ? 'active' : '' }}">Data Santri</a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="{{ route('tingkatan.index') }}" class="nav-link {{ request()->routeIs('tingkatan.*') ? 'active' : '' }}">Tingkatan</a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="{{ route('kompleks-kamar.index') }}" class="nav-link {{ request()->routeIs('kompleks-kamar.*') ? 'active' : '' }}">Kompleks & Kamar</a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                                <li class="nav-item">
                                    <a href="#pengurusSubmenu" data-bs-toggle="collapse" class="nav-link {{ request()->routeIs('pengurus.*') ? 'active' : '' }}">
                                        Pengurus
                                        <i class="bi bi-chevron-down float-end"></i>
                                    </a>
                                    <div class="collapse {{ request()->routeIs('pengurus.*') ? 'show' : '' }}" id="pengurusSubmenu">
                                        <ul class="nav flex-column submenu">
                                            <li class="nav-item">
                                                <a href="{{ route('pengurus.index') }}" class="nav-link {{ request()->routeIs('pengurus.*') ? 'active' : '' }}">Data Pengurus</a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('divisi.index') }}" class="nav-link {{ request()->routeIs('divisi.*') ? 'active' : '' }}">
                                        <i class="bi bi-diagram-3 me-2"></i>
                                        Divisi
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('koperasi.index') }}" class="nav-link {{ request()->routeIs('koperasi.*') ? 'active' : '' }}">Koperasi</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('saldo.index') }}" class="nav-link {{ request()->routeIs('saldo.*') ? 'active' : '' }}">Saldo</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('tabungan.index') }}" class="nav-link {{ request()->routeIs('tabungan.*') ? 'active' : '' }}">Tabungan</a>
                                </li>
                            </ul>
                        </div>
                    </li>
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
                @yield('content')
            </div>
        </main>

        <!-- jQuery -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <!-- Bootstrap Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
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
    </body>
</html>