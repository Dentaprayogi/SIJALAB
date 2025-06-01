<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landing Page - Sistem Peminjaman lab Komputer Jurusan Bisnis dan Informatika</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Figtree:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="icon" href="{{ asset('assets/img/logo poliwangi.png') }}" type="image/png">

    <!-- Import CSS -->
    <link rel="stylesheet" href="{{ asset('login-form/css/custom.css') }}">
    <style>
        body {
            background-image: url('{{ asset('assets/img/poliwangi 2.jpg') }}');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            min-height: 100vh;
            padding-top: 70px;
        }
    </style>

</head>

<body>

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

    <div class="text-center mb-5" style="color: white">
        <h1 class="display-5 fw-bold">Sistem Peminjaman Laboratorium Komputer</h1>
        <p class="lead">Informasi Jadwal & Ketersediaan Ruangan Laboratorium Jurusan Bisnis dan Informatika</p>
    </div>

    <div class="container">
        <div class="row justify-content-center">
            @foreach ($labs as $lab)
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm text-center">
                        <img src="{{ asset('assets/img/lab.jpg') }}" class="mx-auto d-block mt-3"
                            style="max-width: 300px;" alt="Foto Lab">
                        <div class="card-body">
                            <h5 class="card-title">Lab. {{ $lab->nama_lab }}</h5>
                            @php
                                $statusClass = match ($lab->status) {
                                    'Tersedia' => 'badge bg-success',
                                    'Dipinjam' => 'badge bg-primary',
                                    'Kosong' => 'badge bg-secondary',
                                    'Pengajuan' => 'badge bg-warning text-dark',
                                    'Nonaktif' => 'badge bg-dark',
                                    default => 'badge bg-light text-dark',
                                };
                            @endphp
                            <span class="badge-status {{ $statusClass }}">{{ $lab->status }}</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
