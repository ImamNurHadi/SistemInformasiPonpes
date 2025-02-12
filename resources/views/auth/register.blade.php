<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Ponpes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #1d976c 0%, #93f9b9 100%);
        }
        .register-container {
            min-height: 100vh;
            position: relative;
        }
        .brand-section {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            color: white;
            padding: 3rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
            overflow: hidden;
            box-shadow: 0 0 40px rgba(0, 0, 0, 0.1);
            transform: perspective(1000px) rotateY(5deg);
            transform-origin: right center;
            transition: transform 0.5s ease;
        }
        .brand-section:hover {
            transform: perspective(1000px) rotateY(0deg);
        }
        .brand-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('{{ asset('img/santri.jpeg') }}') center/cover no-repeat;
            opacity: 0.3;
            z-index: 0;
            filter: blur(5px);
        }
        .brand-section > * {
            position: relative;
            z-index: 1;
        }
        .brand-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
        }
        .brand-subtitle {
            font-size: 1.1rem;
            opacity: 0.9;
            line-height: 1.6;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.2);
        }
        .register-section {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            background: rgba(255, 255, 255, 0.95);
            transform: perspective(1000px) rotateY(-5deg);
            transform-origin: left center;
            transition: transform 0.5s ease;
        }
        .register-section:hover {
            transform: perspective(1000px) rotateY(0deg);
        }
        .register-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            padding: 2.5rem;
            width: 100%;
            max-width: 420px;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .register-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        .register-title {
            font-size: 2rem;
            font-weight: 700;
            color: #1d976c;
            margin-bottom: 0.5rem;
        }
        .register-subtitle {
            color: #666;
            font-size: 0.95rem;
        }
        .form-control {
            padding: 0.75rem 1rem;
            border: 1px solid rgba(29, 151, 108, 0.2);
            background: rgba(255, 255, 255, 0.9);
            transition: all 0.3s ease;
        }
        .form-control:focus {
            border-color: #1d976c;
            box-shadow: 0 0 0 0.2rem rgba(29, 151, 108, 0.25);
            background: white;
        }
        .form-label {
            color: #2c3e50;
            font-weight: 500;
        }
        .btn-primary {
            background-color: #1d976c;
            border-color: #1d976c;
            padding: 0.75rem 1rem;
            font-weight: 500;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            background-color: #167d58;
            border-color: #167d58;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(29, 151, 108, 0.2);
        }
        .auth-links {
            text-align: center;
            margin-top: 1.5rem;
        }
        .auth-links a {
            color: #1d976c;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        .auth-links a:hover {
            color: #167d58;
            text-decoration: none;
        }
        @media (max-width: 992px) {
            .brand-section, .register-section {
                transform: none;
            }
            .brand-section:hover, .register-section:hover {
                transform: none;
            }
        }
        @media (max-width: 576px) {
            .register-card {
                padding: 1.5rem;
            }
            .register-title {
                font-size: 1.75rem;
            }
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row register-container">
            <!-- Brand Section (Left) -->
            <div class="col-lg-7 brand-section d-none d-lg-flex">
                <div>
                    <h1 class="brand-title">Sistem Informasi Enterprise<br>Pondok Pesantren</h1>
                    <p class="brand-subtitle">Sistem Informasi terintegrasi untuk mengatur proses operasional administrasi & transaksi</p>
                </div>
            </div>

            <!-- Register Section (Right) -->
            <div class="col-lg-5 register-section">
                <div class="register-card">
                    <div class="register-header">
                        <h1 class="register-title">Daftar Akun</h1>
                        <p class="register-subtitle">Silakan lengkapi data diri Anda</p>
                    </div>
                    
    <form method="POST" action="{{ route('register') }}">
        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                id="name" name="name" value="{{ old('name') }}" required autofocus>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                id="email" name="email" value="{{ old('email') }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                id="password" name="password" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                            <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" 
                                id="password_confirmation" name="password_confirmation" required>
        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Daftar</button>
        </div>

                        <div class="auth-links">
                            <span class="d-block">
                                Sudah punya akun? 
                                <a href="{{ route('login') }}">Login</a>
                            </span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
