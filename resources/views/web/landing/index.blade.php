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
    <link href="{{ asset('startbootstrap/css/sb-admin-2-custom.css') }}" rel="stylesheet">
    <style>
        body {
            background-image: url('{{ asset('assets/img/poliwangi 2.jpg') }}');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            min-height: 100vh;
            padding-top: 70px;
        }

        .nav-link.active {
            font-weight: bold;
            color: #ffffff !important;
            border-bottom: 2px solid #ffffff;
        }

        .lab-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .lab-card:hover {
            transform: scale(1.03);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.2);
        }
    </style>

</head>

<body>

    <!-- Topbar -->
    <nav class="navbar navbar-expand-lg custom-navbar">
        <div class="container-fluid px-4">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('/') ? 'active' : '' }}" href="{{ url('/') }}">Beranda</a>
                </li>
            </ul>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent"
                aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarContent">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('login') ? 'active' : '' }}"
                            href="{{ route('login') }}">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('register') ? 'active' : '' }}"
                            href="{{ route('register') }}">Register</a>
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
                    <div class="card shadow-sm text-center lab-card" data-id="{{ $lab->id_lab }}"
                        style="cursor:pointer;">
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

    @include('web.landing.jadwalLab')

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    {{-- memuat jadwal lab --}}
    <script>
        document.querySelectorAll('.lab-card').forEach(card => {
            card.addEventListener('click', function() {
                const idLab = this.getAttribute('data-id');
                const jadwalContent = document.getElementById('jadwal-content');
                jadwalContent.innerHTML = 'Memuat jadwal...';

                fetch(`/jadwal-lab/hari-ini/${idLab}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.length === 0) {
                            jadwalContent.innerHTML = '<p>Tidak ada jadwal hari ini.</p>';
                        } else {
                            let html = '<ul class="list-group">';
                            data.forEach(item => {
                                html += `<li class="list-group-item">
                                    <strong>Jam: ${item.jam_mulai} - ${item.jam_selesai}
                                    Matkul: ${item.nama_mk}  
                                    Kelas: ${item.nama_kelas} (${item.singkatan_prodi})</strong> 
                                </li>`;
                            });
                            html += '</ul>';
                            jadwalContent.innerHTML = html;
                        }

                        const modal = new bootstrap.Modal(document.getElementById('jadwalModal'));
                        modal.show();
                    })
                    .catch(error => {
                        console.error(error);
                        jadwalContent.innerHTML = '<p>Gagal memuat jadwal.</p>';
                    });
            });
        });
    </script>
</body>

</html>
