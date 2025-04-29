<!doctype html>
<html lang="en">
<head>
    <!-- Meta Tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css2?family=Figtree:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="icon" href="{{ asset('assets/img/logo poliwangi.png') }}" type="image/png">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('login-form/css/bootstrap.min.css') }}">
        <!-- Import CSS -->
    <link rel="stylesheet" href="{{ asset('login-form/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('login-form/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('login-form/css/custom.css') }}">
    <title>Lupa Password | Sistem Peminjaman lab Komputer Jurusan Bisnis dan Informatika</title>
</head>
<body class="custom-bg">
    <div class="auth-box">
        <h3 class="text-center mb-4" style="color: #007bff"><strong>Lupa Password</strong></h3>

        <p class="mb-4 text-center text-muted">
            Lupa password Anda? Masukkan email Anda dan kami akan mengirimkan tautan untuk mengatur ulang password.
        </p>

        @if (session('status'))
            <div class="alert alert-success text-sm text-center">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger text-sm text-center">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="form-group">
                <label for="email">Alamat Email</label>
                <input id="email" class="form-control" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username">
            </div>

            <div class="form-group mt-4">
                <button type="submit" class="btn btn-primary">
                    Kirim Link Reset Password
                </button>
            </div>
        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="{{ asset('login-form/js/bootstrap.min.js') }}"></script>
</body>
</html>
