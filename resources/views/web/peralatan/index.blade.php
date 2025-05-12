@extends('web.layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between">
                <h1 class="h3 mb-2 text-gray-800">Daftar Peralatan</h1>
                <!-- Button Tambah Peralatan -->
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahPeralatan">
                    <i class="fas fa-plus"></i> Tambah Peralatan
                </button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead class="thead-primary">
                            <tr>
                                <th>No.</th>
                                <th>Nama Peralatan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($peralatan->isEmpty())
                                <tr>
                                    <td colspan="5" class="text-center">Belum Ada Data</td>
                                </tr>
                            @else
                                @foreach ($peralatan as $peralatans)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $peralatans->nama_peralatan }}</td>
                                        <td>
                                            <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                                data-bs-target="#modalEditPeralatan{{ $peralatans->id_peralatan }}"
                                                title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <form action="{{ route('peralatan.destroy', $peralatans->id_peralatan) }}"
                                                method="POST" style="display:inline-block;" class="form-delete">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger btn-delete" type="button"
                                                    data-id="{{ $peralatans->id_peralatan }}" title="Hapus">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
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

    @include('web.peralatan.create')
    @include('web.peralatan.edit')

    <!-- Tambahkan SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
        document.addEventListener("DOMContentLoaded", function() {
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: '{{ session('success') }}',
                    showConfirmButton: false,
                    timer: 3000
                });
            @endif

            @if ($errors->any())
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: '{{ $errors->first() }}',
                    showConfirmButton: true
                }).then(() => {
                    let oldId = "{{ old('id_peralatan') }}"; // Ambil id dari form edit yang gagal

                    if (oldId) {
                        var editModal = new bootstrap.Modal(document.getElementById('modalEditPeralatan' +
                            oldId));
                        editModal.show();
                    } else {
                        var tambahModal = new bootstrap.Modal(document.getElementById(
                            'modalTambahPeralatan'));
                        tambahModal.show();
                    }
                });
            @endif
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Fungsi untuk menghapus error di dalam modal
            function bersihkanError(modal) {
                modal.querySelectorAll('.is-invalid').forEach(input => {
                    input.classList.remove('is-invalid');
                });

                modal.querySelectorAll('.invalid-feedback').forEach(error => {
                    error.style.display = 'none'; // Sembunyikan pesan error tanpa menghapusnya
                });
            }

            // Event listener saat modal ditutup -> Hapus error
            document.querySelectorAll('.modal').forEach(modal => {
                modal.addEventListener('hidden.bs.modal', function() {
                    bersihkanError(this);
                });

                // Event listener saat modal dibuka -> Pastikan error hanya tampil di modal yang sesuai
                modal.addEventListener('show.bs.modal', function() {
                    // Hapus error di semua modal lain sebelum modal yang baru ditampilkan
                    document.querySelectorAll('.modal').forEach(otherModal => {
                        if (otherModal !== this) {
                            bersihkanError(otherModal);
                        }
                    });
                });
            });
        });
    </script>

    <script>
        document.querySelectorAll('.btn-delete').forEach(button => {
            button.addEventListener('click', function() {
                const fasilitasId = this.getAttribute('data-id');
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Peralatan yang dihapus tidak bisa dikembalikan!",
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
                })
            });
        });
    </script>

@endsection
