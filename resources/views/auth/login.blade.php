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
            flex-direction: column;
            justify-content: center;
        }
        .brand-section {
            color: white;
            padding: 3rem;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
        }
        .brand-title {
            font-size: 5rem;
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
            max-width: 380px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
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
            text-transform: uppercase;
            font-size: 1rem;
            letter-spacing: 0.5px;
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
            font-size: 1rem;
        }
        .auth-links a {
            color: #058B42;
            text-decoration: none;
        }
        .auth-links a:hover {
            color: #02361A;
            text-decoration: underline;
        }
        .form-check-input:checked {
            background-color: #058B42;
            border-color: #058B42;
        }
        .form-check-label {
            color: #4a5568;
            font-size: 1rem;
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
        <div class="row login-container">
            <div class="col-lg-7 content-section">
                <h1 class="brand-title">Qinna Manajemen Sistem</h1>
            </div>

            <div class="col-lg-5 login-section">
                <div class="login-card">
                    <h3 class="text-center mb-4" style="font-size: 2rem;">LOGIN</h3>
                    
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label">EMAIL / NIS</label>
                            <input type="text" class="form-control @error('email') is-invalid @enderror" 
                                id="email" name="email" value="{{ old('email') }}" required autofocus>
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

                        <div class="mb-3 d-flex justify-content-between align-items-center">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="remember" name="remember">
                                <label class="form-check-label" for="remember">Ingat Saya</label>
                            </div>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-end">
                                    Lupa kata sandi?
                                </a>
                            @endif
                        </div>

                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-primary">MASUK</button>
                        </div>

                        <div class="auth-links">
                            @if (Route::has('register'))
                                <div class="text-muted">
                                    Belum punya akun? 
                                    <a href="{{ route('register') }}">Daftar</a>
                                </div>
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
