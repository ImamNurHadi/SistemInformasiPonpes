<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Ponpes</title>
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('img/logo.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
            background: url('{{ asset('img/santri.jpeg') }}') center/cover no-repeat;
            position: relative;
        }
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(5, 139, 66, 0.95) 0%, rgba(2, 54, 26, 0.95) 100%);
            backdrop-filter: blur(0.1px);
        }
        .login-container {
            min-height: 100vh;
            position: relative;
            z-index: 1;
            display: flex;
        }
        .content-section {
            color: white;
            padding: 3rem;
            display: flex;
            align-items: center;
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
            font-size: 3.5rem;
            font-weight: 700;
            color: white;
            margin: 0;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
        }
        .brand-subtitle {
            font-size: 1.1rem;
            opacity: 0.9;
            line-height: 1.6;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.2);
            max-width: 600px;
        }
        .login-section {
            padding: 2rem;
            display: flex;
            align-items: center;
        }
        .login-card {
            background: white;
            border-radius: 10px;
            padding: 2rem;
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
            border: 1px solid #e2e8f0;
        }
        .form-control:focus {
            border-color: #058B42;
            box-shadow: 0 0 0 0.2rem rgba(5, 139, 66, 0.25);
        }
        .form-label {
            color: #4a5568;
            font-weight: 500;
        }
        .btn-primary {
            background-color: #058B42;
            border-color: #058B42;
            padding: 0.75rem 1rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .btn-primary:hover {
            background-color: #02361A;
            border-color: #02361A;
        }
        .auth-links {
            text-align: center;
            margin-top: 1.5rem;
        }
        .auth-links a {
            color: #058B42;
            text-decoration: none;
        }
        .auth-links a:hover {
            color: #02361A;
            text-decoration: underline;
        }
        @media (max-width: 992px) {
            .content-section {
                padding: 2rem;
                text-align: center;
            }
            .brand-subtitle {
                margin: 0 auto;
            }
            .login-section {
                justify-content: center;
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

            <div class="col-lg-5 login-section">
                <div class="login-card">
                    <h3 class="text-center mb-4">DAFTAR AKUN</h3>
                    
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">NAMA LENGKAP</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                id="name" name="name" value="{{ old('name') }}" required autofocus>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">EMAIL</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                id="email" name="email" value="{{ old('email') }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">KATA SANDI</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                id="password" name="password" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">KONFIRMASI KATA SANDI</label>
                            <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" 
                                id="password_confirmation" name="password_confirmation" required>
                        </div>

                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-primary">DAFTAR</button>
                        </div>

                        <div class="auth-links">
                            <div class="text-muted">
                                Sudah punya akun? 
                                <a href="{{ route('login') }}">Login</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
