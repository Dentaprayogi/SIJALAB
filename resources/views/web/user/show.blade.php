@extends('web.layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between">
                <h1 class="h3 mb-0 text-gray-800">Detail User</h1>
                <a href="{{ route('users.index') }}" class="btn btn-primary">Kembali</a>
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
                </div>
            </div>
        </div>
    </div>
@endsection
