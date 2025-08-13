@extends('web.layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h1 class="h3 mb-0 text-gray-800">Detail User</h1>
                <div style="gap: 8px;">
                    <button id="resetPasswordBtn" class="btn btn-warning">
                        Reset Password
                    </button>
                    <a href="{{ route('users.index') }}" class="btn btn-primary">Kembali</a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <!-- Kolom Kiri -->
                    <div class="col-md-6">
                        <table class="table table-striped table-bordered">
                            <tr>
                                <th>Nama</th>
                                <td>{{ $user->name }}</td>
                            </tr>
                            <tr>
                                <th>Username</th>
                                <td>{{ $user->username }}</td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>{{ $user->email }}</td>
                            </tr>
                            <tr>
                                <th>Role</th>
                                <td>{{ ucfirst($user->role) }}</td>
                            </tr>
                            <tr>
                                <th>Status User</th>
                                <td>
                                    <span
                                        class="badge-status {{ $user->status_user === 'aktif' ? 'badge-success' : 'badge-danger' }}">
                                        {{ ucfirst($user->status_user) }}
                                    </span>
                                </td>
                            </tr>
                            @if ($user->mahasiswa)
                                <tr>
                                    <th>NIM</th>
                                    <td>{{ $user->mahasiswa->nim }}</td>
                                </tr>
                                <tr>
                                    <th>Telepon</th>
                                    <td>{{ $user->mahasiswa->telepon }}</td>
                                </tr>
                                <tr>
                                    <th>Prodi</th>
                                    <td>
                                        {{ $user->mahasiswa->prodi->nama_prodi }}
                                        ({{ $user->mahasiswa->kelas->nama_kelas }})
                                    </td>
                                </tr>
                            @endif
                        </table>
                    </div>

                    <!-- Kolom Kanan -->
                    @if ($user->mahasiswa)
                        <div class="col-md-6 text-center">
                            @if ($user->mahasiswa && $user->mahasiswa->foto_ktm)
                                <label class="font-weight-bold">Foto KTM</label>
                                <div class="mt-2">
                                    <img src="{{ asset($user->mahasiswa->foto_ktm) }}" alt="Foto KTM" class="img-thumbnail"
                                        style="max-width: 500px;">
                                </div>
                            @else
                                <p class="text-danger">Foto KTM belum diunggah.</p>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- SweetAlert --}}
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

    <script>
        document.getElementById('resetPasswordBtn').addEventListener('click', function() {
            Swal.fire({
                title: 'Reset Password?',
                text: "Password akan direset menjadi username.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#f6c23e',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, reset sekarang'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "{{ route('users.resetPassword', $user->id) }}";
                }
            });
        });
    </script>
@endsection
