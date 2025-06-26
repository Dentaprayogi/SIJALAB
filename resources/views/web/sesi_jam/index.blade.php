@extends('web.layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between">
                <h1 class="h3 mb-2 text-gray-800">Daftar Sesi Jam</h1>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">
                    <i class="fas fa-plus"></i> Tambah Sesi
                </button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead class="thead-primary">
                            <tr>
                                <th>No.</th>
                                <th>Nama Sesi</th>
                                <th>Jam Mulai</th>
                                <th>Jam Selesai</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sesiJam as $sesi)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $sesi->nama_sesi }}</td>
                                    <td>{{ \Carbon\Carbon::parse($sesi->jam_mulai)->format('H:i') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($sesi->jam_selesai)->format('H:i') }}</td>
                                    <td>
                                        <button class="btn btn-warning" data-bs-toggle="modal"
                                            data-bs-target="#editModal{{ $sesi->id_sesi_jam }}">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <form action="{{ route('sesi-jam.destroy', $sesi->id_sesi_jam) }}" method="POST"
                                            class="form-delete d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-delete" type="button"
                                                data-id="{{ $sesi->id_sesi_jam }}">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>

                                @include('web.sesi_jam.edit')
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @include('web.sesi_jam.create')

    {{-- SweetAlert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 3000
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: '{{ session('error') }}',
                showConfirmButton: true
            });
        </script>
    @endif

    @if ($errors->any())
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: '{{ $errors->first() }}',
                showConfirmButton: true
            }).then(() => {
                var oldId = "{{ old('id_sesi_jam') }}";
                if (oldId) {
                    let modal = new bootstrap.Modal(document.getElementById('editModal' + oldId));
                    modal.show();
                } else {
                    let modal = new bootstrap.Modal(document.getElementById('createModal'));
                    modal.show();
                }
            });
        </script>
    @endif

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            function bersihkanError(modal) {
                modal.querySelectorAll('.is-invalid').forEach(input => {
                    input.classList.remove('is-invalid');
                });
                modal.querySelectorAll('.invalid-feedback').forEach(error => {
                    error.style.display = 'none';
                });
            }

            document.querySelectorAll('.modal').forEach(modal => {
                modal.addEventListener('hidden.bs.modal', function() {
                    bersihkanError(this);
                });
                modal.addEventListener('show.bs.modal', function() {
                    document.querySelectorAll('.modal').forEach(otherModal => {
                        if (otherModal !== this) {
                            bersihkanError(otherModal);
                        }
                    });
                });
            });

            document.querySelectorAll('.btn-delete').forEach(button => {
                button.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: "Data yang dihapus tidak bisa dikembalikan!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            this.closest('form').submit();
                        }
                    });
                });
            });
        });
    </script>
@endsection
