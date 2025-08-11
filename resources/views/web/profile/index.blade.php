@extends('web.layouts.app')

@section('content')
    <div class="container py-5">
        <h2 class="mb-4 fw-bold">Profil Saya</h2>

        {{-- Informasi Akun --}}
        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data"
            class="card p-4 mb-4 shadow-sm border-0">
            @csrf
            @method('PUT')

            <h5 class="mb-3 fw-semibold">Informasi Akun</h5>

            <div class="row g-3">
                <div class="col-md-6 mb-3">
                    <label for="name" class="form-label">Nama</label>
                    <input type="text" class="form-control" name="name" id="name"
                        value="{{ old('name', Auth::user()->name) }}" required>
                    @error('name')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" name="username" id="username"
                        value="{{ old('username', Auth::user()->username) }}"
                        {{ Auth::user()->role === 'mahasiswa' ? 'disabled' : '' }}>
                    @error('username')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" name="email" id="email"
                        value="{{ old('email', Auth::user()->email) }}" required>
                    @error('email')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>

        {{-- Informasi Mahasiswa --}}
        @if (Auth::user()->role === 'mahasiswa')
            <form action="{{ route('profile.mahasiswa.update') }}" method="POST" enctype="multipart/form-data"
                class="card p-4 mb-4 shadow-sm border-0">
                @csrf
                @method('PUT')

                <h5 class="mb-3 fw-semibold">Informasi Mahasiswa</h5>

                <div class="row g-3">
                    <div class="col-md-6 mb-3">
                        <label for="telepon" class="form-label">Telepon</label>
                        <input type="text" name="telepon" id="telepon" class="form-control"
                            value="{{ old('telepon', $mahasiswa->telepon ?? '') }}">
                        @error('telepon')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="nim" class="form-label">NIM</label>
                        <input type="text" name="nim" id="nim" class="form-control"
                            value="{{ old('nim', $mahasiswa->nim ?? '') }}" disabled>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="id_prodi" class="form-label">Program Studi</label>
                        <select name="id_prodi" id="id_prodi" class="form-control" disabled>
                            @foreach ($prodiList as $prodi)
                                <option value="{{ $prodi->id_prodi }}"
                                    {{ $mahasiswa->id_prodi == $prodi->id_prodi ? 'selected' : '' }}>
                                    {{ $prodi->nama_prodi }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="id_kelas" class="form-label">Kelas</label>
                        <select name="id_kelas" id="id_kelas" class="form-control" {{ $canEditKelas ? '' : 'disabled' }}>
                            <option value="">-- Pilih Kelas --</option>
                            @foreach ($kelasList as $kelas)
                                <option value="{{ $kelas->id_kelas }}"
                                    {{ $mahasiswa->id_kelas == $kelas->id_kelas ? 'selected' : '' }}>
                                    {{ $kelas->nama_kelas }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="foto_ktm" class="form-label">Foto KTM</label>
                        <input type="file" name="foto_ktm" id="foto_ktm" class="form-control" accept="image/*">>
                        @if (!empty($mahasiswa->foto_ktm))
                            <div class="mt-2">
                                <img src="{{ asset($mahasiswa->foto_ktm) }}" class="rounded" width="420">
                            </div>
                        @endif
                        @error('foto_ktm')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        @endif

        {{-- Ubah Password --}}
        <form action="{{ route('profile.password.update') }}" method="POST" class="card p-4 shadow-sm border-0">
            @csrf
            @method('PUT')

            <h5 class="mb-3 fw-semibold">Ubah Password</h5>

            <div class="row g-3">
                <div class="col-md-6 mb-3">
                    <label for="current_password" class="form-label">Password Lama</label>
                    <input type="password" name="current_password" id="current_password" class="form-control">
                    @error('current_password')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="password" class="form-label">Password Baru</label>
                    <input type="password" name="password" id="password" class="form-control">
                    @error('password')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
                    @error('password_confirmation')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">Ubah Password</button>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: '{{ session('success') }}',
                    showConfirmButton: false,
                });
            });
        </script>
    @endif

    @if ($errors->any())
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    html: `{!! implode('<br>', $errors->all()) !!}`,
                    confirmButtonText: 'Ok'
                });
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: '{{ session('error') }}',
                showConfirmButton: 'Ok'
            });
        </script>
    @endif
@endsection
