<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - Sistem Inventory Konstruksi</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #797f9a 0%, #b8b2be 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
        }

        .login-container {
            max-width: 450px;
            margin: 0 auto;
        }

        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.30);
            overflow: hidden;
        }

        .card-header {
            background: linear-gradient(135deg, #f3c52d 0%, #9b6701 100%);
            color: #fff;
            text-align: center;
            padding: 2rem 1rem;
            border-bottom: none;
        }

        .card-header h4 {
            font-weight: 700;
            margin-bottom: .5rem;
        }

        .card-header p {
            margin-bottom: 0;
            opacity: .9;
        }

        .card-body {
            padding: 2rem;
        }

        .input-group {
            border: 2px solid #e3e6f0;
            border-radius: 10px;
            overflow: hidden;
            transition: .3s;
        }

        .input-group:focus-within {
            border-color: #4e73df;
            box-shadow: 0 0 0 .15rem rgba(78,115,223,.20);
        }

        .form-control {
            border: none;
            padding: .85rem 1rem;
        }

        .form-control:focus {
            box-shadow: none;
        }

        .input-group-text {
            background: transparent;
            border: none;
            color: #6c757d;
        }

        .btn-login {
            background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
            border: none;
            border-radius: 10px;
            padding: .85rem;
            font-weight: 600;
            transition: .3s;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(78,115,223,.25);
        }

        .alert {
            border-radius: 10px;
            border: none;
        }

        .icon-building {
            font-size: 3rem;
            margin-bottom: 1rem;
            animation: float 3s ease-in-out infinite;
        }

        .footer-text {
            text-align: center;
            margin-top: 1.5rem;
            color: rgba(255,255,255,.8);
            font-size: .85rem;
        }

        @keyframes float {
            0%,100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-10px);
            }
        }

        .forgot-link {
            text-decoration: none;
            font-size: .9rem;
        }

        .forgot-link:hover {
            text-decoration: underline;
        }

        @media(max-width:576px){
            .card-body{
                padding:1.5rem;
            }
        }
    </style>
</head>
<body>

<div class="container">

    <div class="login-container">

        <div class="card">

            <div class="card-header">

                <i class="fas fa-hard-hat icon-building"></i>

                <h4>Sistem Inventory Proyek</h4>

                <p>Sign in to start your session</p>

            </div>

            <div class="card-body">

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show">

                        <i class="fas fa-exclamation-circle me-2"></i>

                        {{ $errors->first() }}

                        <button type="button"
                                class="btn-close"
                                data-bs-dismiss="alert">
                        </button>

                    </div>
                @endif

                @if(session('status'))
                    <div class="alert alert-success alert-dismissible fade show">

                        {{ session('status') }}

                        <button type="button"
                                class="btn-close"
                                data-bs-dismiss="alert">
                        </button>

                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">

                    @csrf

                    <div class="mb-4">

                        <label class="form-label fw-bold">
                            Email
                        </label>

                        <div class="input-group">

                            <input
                                type="email"
                                name="email"
                                value="{{ old('email') }}"
                                class="form-control @error('email') is-invalid @enderror"
                                placeholder="Masukkan email Anda"
                                required
                                autofocus>

                            <span class="input-group-text">
                                <i class="fas fa-user"></i>
                            </span>

                        </div>

                        @error('email')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>

                    <div class="mb-4">

                        <label class="form-label fw-bold">
                            Password
                        </label>

                        <div class="input-group">

                            <input
                                type="password"
                                name="password"
                                id="password"
                                class="form-control @error('password') is-invalid @enderror"
                                placeholder="Masukkan password"
                                required>

                            <span class="input-group-text"
                                  onclick="togglePassword()"
                                  style="cursor:pointer">

                                <i class="fas fa-eye"
                                   id="toggleIcon"></i>

                            </span>

                        </div>

                        @error('password')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-4">

                        <div class="form-check">

                            <input
                                type="checkbox"
                                name="remember"
                                class="form-check-input"
                                id="remember">

                            <label class="form-check-label"
                                   for="remember">

                                Ingat Saya

                            </label>

                        </div>

                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}"
                               class="forgot-link">

                                Lupa Password?

                            </a>
                        @endif

                    </div>

                    <button type="submit"
                            class="btn btn-primary btn-login w-100">

                        <i class="fas fa-sign-in-alt me-2"></i>

                        Masuk

                    </button>

                </form>

            </div>

        </div>

        <div class="footer-text">

            <p>
                &copy; {{ date('Y') }}
                Sistem Inventory Proyek.
                All rights reserved.
            </p>

        </div>

    </div>

</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>

function togglePassword() {

    const passwordInput =
        document.getElementById('password');

    const toggleIcon =
        document.getElementById('toggleIcon');

    if(passwordInput.type === 'password') {

        passwordInput.type = 'text';

        toggleIcon.classList.remove('fa-eye');
        toggleIcon.classList.add('fa-eye-slash');

    } else {

        passwordInput.type = 'password';

        toggleIcon.classList.remove('fa-eye-slash');
        toggleIcon.classList.add('fa-eye');

    }
}

setTimeout(() => {

    let alert =
        document.querySelector('.alert');

    if(alert){

        let bsAlert =
            new bootstrap.Alert(alert);

        bsAlert.close();
    }

}, 5000);

</script>

</body>
</html>