@extends('web.layouts.app')
@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between">
            <h1 class="h3 mb-2 text-gray-800">Daftar Tahun Ajaran</h1>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahTahunAjaranModal">
                <i class="fas fa-plus"></i> Tambah Tahun Ajaran
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead class="thead-primary">
                        <tr>
                            <th>No.</th>
                            <th>Tahun Ajaran</th>
                            <th>Semester</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($tahunAjaran->isEmpty()) 
                            <tr>
                                <td colspan="5" class="text-center">Belum Ada Data</td>
                            </tr>
                        @else
                            @foreach($tahunAjaran as $tahun)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $tahun->tahun_ajaran }}</td>
                                    <td>{{ ucfirst($tahun->semester) }}</td>
                                    <td>
                                        <span class="badge-status {{ $tahun->status_tahunAjaran === 'aktif' ? 'badge-success' : 'badge-danger' }}">
                                            {{ ucfirst($tahun->status_tahunAjaran) }}
                                        </span>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editTahunAjaranModal{{ $tahun->id_tahunAjaran }}" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <form action="{{ route('tahunajaran.destroy', $tahun->id_tahunAjaran) }}" method="POST" style="display:inline-block;" class="form-delete">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-delete" type="button" data-id="{{ $tahun->id_tahunAjaran }}" title="Hapus">
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
@include('web.tahunajaran.create')
@include('web.tahunajaran.edit')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Jika ada pesan sukses dari session
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session("success") }}',
                showConfirmButton: false,
                timer: 3000
            });
        @endif

        // Jika ada pesan error dari session (misalnya tahun ajaran & semester sudah ada)
        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: '{{ session("error") }}',
                showConfirmButton: true
            }).then(() => {
                let oldId = "{{ old('id_tahunAjaran', session('id_tahunAjaran')) }}"; // Cek old() dan session

                if (oldId) {
                    var editModal = new bootstrap.Modal(document.getElementById('editTahunAjaranModal' + oldId));
                    editModal.show();
                } else {
                    var tambahModal = new bootstrap.Modal(document.getElementById('tambahTahunAjaranModal'));
                    tambahModal.show();
                }
            });
        @endif

        // Jika ada pesan error validasi
        @if ($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: '{{ $errors->first() }}',
                showConfirmButton: true
            }).then(() => {
                let oldId = "{{ old('id_tahunAjaran', session('id_tahunAjaran')) }}"; // Cek old() dan session

                if (oldId) {
                    var editModal = new bootstrap.Modal(document.getElementById('editTahunAjaranModal' + oldId));
                    editModal.show();
                } else {
                    var tambahModal = new bootstrap.Modal(document.getElementById('tambahTahunAjaranModal'));
                    tambahModal.show();
                }
            });
        @endif
    });
</script>

<script>
    document.querySelectorAll('.btn-delete').forEach(button => {
        button.addEventListener('click', function () {
            const fasilitasId = this.getAttribute('data-id');
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Tahun Ajaran yang dihapus tidak bisa dikembalikan!",
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
