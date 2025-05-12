@extends('web.layouts.app')
@section('content')

    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between">
                <h1 class="h3 mb-2 text-gray-800">Daftar Users</h1>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead class="thead-primary">
                            <tr>
                                <th>No.</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($users->isEmpty())
                                <tr>
                                    <td colspan="5" class="text-center">Belum Ada Data</td>
                                </tr>
                            @else
                                @foreach ($users as $user)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ ucfirst($user->role) }}</td>
                                        <td>
                                            <!-- Toggle Switch Status -->
                                            <div class="form-switch-toggle">
                                                @php
                                                    $id = $user->id;
                                                    $isTeknisi = $user->role === 'teknisi';
                                                @endphp

                                                <input type="hidden" name="status_user"
                                                    id="status_user_hidden_{{ $id }}"
                                                    value="{{ $user->status_user }}">

                                                <input type="checkbox" id="status_user_switch_{{ $id }}"
                                                    class="switch-toggle status-toggle" data-id="{{ $id }}"
                                                    data-role="{{ $user->role }}"
                                                    {{ $user->status_user == 'aktif' ? 'checked' : '' }}
                                                    @if ($isTeknisi) disabled
                                                    title="Tidak bisa diubah"
                                                    style="cursor: not-allowed;" @endif>
                                                <label for="status_user_switch_{{ $id }}"
                                                    class="switch-label"></label>
                                                <span
                                                    id="status_text_{{ $id }}">{{ $user->status_user == 'aktif' ? 'Aktif' : 'Nonaktif' }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <!-- Tombol Detail -->
                                            <a href="{{ route('users.show', $user->id) }}" class="btn btn-info"
                                                title="Lihat Detail">
                                                <i class="fas fa-eye"></i> <!-- Icon Detail -->
                                            </a>
                                            @if ($user->role === 'teknisi')
                                                <!-- Tombol Hapus (non-aktif) -->
                                                <button class="btn btn-secondary" type="button" title="Tidak bisa dihapus"
                                                    style="cursor: not-allowed;">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            @else
                                                <!-- Tombol Hapus -->
                                                <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                                                    style="display:inline-block;" class="form-delete">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-danger btn-delete" type="button"
                                                        data-id="{{ $user->id }}" title="Hapus">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: '{{ session('success') }}',
                    timer: 3000,
                    showConfirmButton: false
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
        document.addEventListener('DOMContentLoaded', function() {
            // Toggle Status
            const switches = document.querySelectorAll('.status-toggle');

            switches.forEach(function(toggle) {
                toggle.addEventListener('change', function(e) {
                    const userId = this.dataset.id;
                    const userRole = this.dataset.role;
                    const isChecked = this.checked;
                    const newStatus = isChecked ? 'aktif' : 'nonaktif';
                    const switchEl = this;

                    if (userRole === 'teknisi') {
                        e.preventDefault();
                        Swal.fire({
                            icon: 'warning',
                            title: 'Akses Ditolak',
                            text: 'Status user dengan role teknisi tidak dapat diubah.',
                        });
                        switchEl.checked = !isChecked;
                        return;
                    }

                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: `Status user akan diubah menjadi ${newStatus.toUpperCase()}`,
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Ya, ubah!',
                        cancelButtonColor: '#d33',
                        cancelButtonText: 'Batal',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            document.getElementById(`status_text_${userId}`).textContent =
                                newStatus.charAt(0).toUpperCase() + newStatus.slice(1);

                            fetch(`/users/${userId}/toggle-status`, {
                                    method: 'PATCH',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    },
                                    body: JSON.stringify({
                                        status_user: newStatus
                                    })
                                })
                                .then(response => response.json())
                                .then(data => {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Berhasil',
                                        text: data.message
                                    });
                                })
                                .catch(error => {
                                    console.error('Error:', error);
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Gagal',
                                        text: 'Terjadi kesalahan saat mengubah status.'
                                    });
                                    switchEl.checked = !isChecked;
                                });
                        } else {
                            switchEl.checked = !isChecked;
                        }
                    });
                });
            });

            // Konfirmasi Hapus User
            const deleteButtons = document.querySelectorAll('.btn-delete');

            deleteButtons.forEach(function(btn) {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();

                    const form = this.closest('form');
                    const userName = this.dataset.name || 'user ini';

                    Swal.fire({
                        title: 'Hapus User?',
                        text: `Apakah Anda yakin ingin menghapus ${userName}?`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonColor: '#d33',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>

@endsection
