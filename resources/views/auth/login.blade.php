<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Ponpes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #1d976c 0%, #93f9b9 100%);
        }
        .login-container {
            min-height: 100vh;
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
        .login-section {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            background: rgba(255, 255, 255, 0.9);
        }
        .login-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 25px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            width: 100%;
            max-width: 400px;
        }
        .form-control {
            padding: 0.75rem 1rem;
            border: 1px solid #e2e8f0;
        }
        .form-control:focus {
            border-color: #1d976c;
            box-shadow: 0 0 0 0.2rem rgba(29, 151, 108, 0.25);
        }
        .btn-primary {
            background-color: #1d976c;
            border-color: #1d976c;
            padding: 0.75rem 1rem;
        }
        .btn-primary:hover {
            background-color: #167d58;
            border-color: #167d58;
        }
        .auth-links {
            text-align: center;
            margin-top: 1.5rem;
        }
        .auth-links a {
            color: #1d976c;
            text-decoration: none;
        }
        .auth-links a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row login-container">
            <!-- Brand Section (Left) -->
            <div class="col-lg-7 brand-section d-none d-lg-flex">
                <div>
                    <h1 class="brand-title">Sistem Informasi Enterprise<br>Pondok Pesantren</h1>
                    <p class="brand-subtitle">Sistem Informasi terintegrasi untuk mengatur proses operasional administrasi & transaksi</p>
                </div>
            </div>

            <!-- Login Section (Right) -->
            <div class="col-lg-5 login-section">
                <div class="login-card">
                    <h3 class="text-center mb-4">Login</h3>
                    
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                id="email" name="email" value="{{ old('email') }}" required autofocus>
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

                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="remember" name="remember">
                            <label class="form-check-label" for="remember">Ingat Saya</label>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Login</button>
                        </div>

                        <div class="auth-links">
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="d-block mb-2">
                                    Lupa kata sandi?
                                </a>
                            @endif
                            
                            @if (Route::has('register'))
                                <span class="d-block">
                                    Belum punya akun? 
                                    <a href="{{ route('register') }}">Daftar</a>
                                </span>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
