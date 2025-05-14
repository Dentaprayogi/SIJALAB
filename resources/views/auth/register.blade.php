<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Register | Sistem Peminjaman lab Komputer Jurusan Bisnis dan Informatika</title>
    <link href="https://fonts.googleapis.com/css2?family=Figtree:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="icon" href="{{ asset('assets/img/logo poliwangi.png') }}" type="image/png">
    <link rel="stylesheet" href="{{ asset('login-form/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('login-form/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('login-form/css/custom.css') }}">

</head>

<body class="custom-bg">

    <div class="register-box">
        <h3 class="form-title text-primary-custom"><strong>Form Registrasi</strong></h3>

        <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <!-- KIRI -->
                <div class="col-md-6 form-section">
                    <div class="form-group mb-3">
                        <label for="name">Nama Lengkap</label>
                        <input type="text" class="form-control" id="name" name="name"
                            value="{{ old('name') }}" required autofocus>
                    </div>

                    <div class="form-group mb-3">
                        <label for="telepon">Telepon</label>
                        <input type="text" class="form-control" id="telepon" name="telepon"
                            value="{{ old('telepon') }}" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email"
                            value="{{ old('email') }}" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="password_confirmation">Konfirmasi Password</label>
                        <input type="password" class="form-control" id="password_confirmation"
                            name="password_confirmation" required>
                    </div>
                </div>

                <!-- KANAN -->
                <div class="col-md-6 form-section">
                    <div class="form-group mb-3">
                        <label for="nim">NIM</label>
                        <input type="text" class="form-control" id="nim" name="nim"
                            value="{{ old('nim') }}" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="id_prodi">Program Studi</label>
                        <select class="form-control" name="id_prodi" id="id_prodi" required>
                            <option value="" selected disabled>-- Pilih Prodi --</option>
                            @foreach ($prodiList as $prodi)
                                <option value="{{ $prodi->id_prodi }}">{{ $prodi->nama_prodi }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label for="id_kelas">Kelas</label>
                        <select class="form-control" name="id_kelas" id="id_kelas" required>
                            <option value="" selected disabled>-- Pilih Kelas --</option>
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label for="foto_ktm" class="form-label">Foto KTM (Max: 5 MB)</label>
                        <input type="file" name="foto_ktm" id="foto_ktm" class="form-control" accept="image/*"
                            required>
                        <img id="preview-image" src="#" alt="Preview Foto KTM"
                            style="max-width: 200px; margin-top: 10px; display: none;">
                    </div>
                </div>
            </div>

            <!-- Checkbox Terms -->
            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                <div class="form-group mt-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="terms" id="terms" required>
                        <label class="form-check-label" for="terms">
                            {!! __('Saya setuju dengan :terms_of_service dan :privacy_policy', [
                                'terms_of_service' => '<a target="_blank" href="' . route('terms.show') . '">Syarat Layanan</a>',
                                'privacy_policy' => '<a target="_blank" href="' . route('policy.show') . '">Kebijakan Privasi</a>',
                            ]) !!}
                        </label>
                    </div>
                </div>
            @endif

            <div class="mt-4">
                <input type="submit" class="btn btn-primary" value="Daftar">
            </div>
        </form>

        <!-- Link Login -->
        <div class="mt-3 text-center">
            Sudah punya akun? <a href="{{ route('login') }}" class="text-primary-custom">Login di sini</a>
        </div>

        <!-- SweetAlert Error -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        @if ($errors->any())
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: '{{ $errors->first() }}',
                    showConfirmButton: 'Ok'
                });
            </script>
        @endif
    </div>

    <script>
        // Load kelas berdasarkan prodi
        document.addEventListener('DOMContentLoaded', function() {
            const prodiSelect = document.getElementById('id_prodi');
            const kelasSelect = document.getElementById('id_kelas');

            prodiSelect.addEventListener('change', function() {
                const idProdi = this.value;
                kelasSelect.innerHTML = '<option value="" disabled selected>-- Pilih Kelas --</option>';

                if (idProdi) {
                    fetch(`/get-kelas/${idProdi}`)
                        .then(response => response.json())
                        .then(data => {
                            data.forEach(kelas => {
                                const option = document.createElement('option');
                                option.value = kelas.id_kelas;
                                option.textContent = kelas.nama_kelas;
                                kelasSelect.appendChild(option);
                            });
                        })
                        .catch(error => {
                            console.error('Gagal mengambil data kelas:', error);
                        });
                }
            });
        });
    </script>
    <script>
        document.getElementById('foto_ktm').addEventListener('change', function(event) {
            const file = event.target.files[0];

            if (file) {
                const maxSize = 5 * 1024 * 1024; // 5 MB

                // Cek ukuran file
                if (file.size > maxSize) {
                    alert("Ukuran file melebihi 5 MB. Silakan pilih file yang lebih kecil.");
                    event.target.value = ""; // reset input file
                    document.getElementById('preview-image').style.display = 'none';
                    return;
                }

                // Tampilkan preview
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.getElementById('preview-image');
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                };
                reader.readAsDataURL(file);
            }
        });
    </script>


    <script src="{{ asset('login-form/js/bootstrap.min.js') }}"></script>
</body>

</html>
