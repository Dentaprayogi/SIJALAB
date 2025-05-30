<!doctype html>
<html lang="en">

<head>
    <!-- Meta Tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css2?family=Figtree:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="icon" href="{{ asset('assets/img/logo poliwangi.png') }}" type="image/png">

    <!-- Import CSS -->
    <link rel="stylesheet" href="{{ asset('login-form/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('login-form/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('login-form/css/custom.css') }}">

    <title>Login | Sistem Peminjaman lab Komputer Jurusan Bisnis dan Informatika</title>
</head>

<body class="custom-bg">

    <!-- Topbar -->
    <nav class="navbar navbar-expand-lg custom-navbar">
        <div class="container-fluid px-4">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/') }}">Beranda</a>
                </li>
            </ul>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent"
                aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarContent">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">Register</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="auth-box-wrapper">
        <div class="logo-kampus-wrapper">
            <img src="{{ asset('assets/img/logo poliwangi.png') }}" alt="Logo Kampus" class="logo-kampus">
        </div>
        <div class="auth-box">
            <h5 class="text-center text-primary-custom mb-3" style="padding-top: 10px"><strong>Sistem Peminjaman Lab
                    Komputer Jurusan Bisnis dan Informatika</strong></h5>
            <p class="text-center mb-4 text-secondary">Silakan login dengan memasukkan alamat email dan kata sandi Anda.
            </p>

            <!-- Form Login -->
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email Input -->
                <div class="form-group mb-3">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email"
                        placeholder="your-email@gmail.com" value="{{ old('email') }}" required autofocus>
                </div>

                <!-- Password Input -->
                <div class="form-group mb-4">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password"
                        placeholder="Your Password" required>
                </div>

                <!-- Link Register dan Forgot Password -->
                <div class="d-flex mb-4 align-items-center justify-content-between">
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="text-primary-custom text-decoration-none">
                            Belum punya akun? <strong>Daftar di sini</strong>
                        </a>
                    @endif
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-primary-custom text-decoration-none">
                            Forgot Password
                        </a>
                    @endif
                </div>

                <!-- Submit Button -->
                <input type="submit" value="Log In" class="btn btn-primary">

                <!-- SweetAlert Error -->
                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                @if ($errors->any())
                    <script>
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: '{{ $errors->first() }}',
                            timer: 3000,
                            showConfirmButton: false
                        });
                    </script>
                @endif
            </form>
        </div>
    </div>

    <!-- Import JS -->
    <script src="{{ asset('login-form/js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('login-form/js/popper.min.js') }}"></script>
    <script src="{{ asset('login-form/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('login-form/js/main.js') }}"></script>

</body>

</html>
