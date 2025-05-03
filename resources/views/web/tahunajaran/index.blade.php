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
                                        <div class="form-switch-toggle">
                                            @php
                                                $tahunId = $tahun->id_tahunAjaran;
                                            @endphp
                                    
                                            <input type="hidden" name="status_tahunAjaran" id="status_tahunAjaran_hidden_{{ $tahunId }}" value="{{ $tahun->status_tahunAjaran }}">
                                    
                                            <input type="checkbox"
                                                id="status_tahunAjaran_switch_{{ $tahunId }}"
                                                class="switch-toggle tahunAjaran-toggle"
                                                data-id="{{ $tahunId }}"
                                                {{ $tahun->status_tahunAjaran == 'aktif' ? 'checked' : '' }}>
                                    
                                            <label for="status_tahunAjaran_switch_{{ $tahunId }}" class="switch-label"></label>
                                            <span id="status_tahunAjaran_text_{{ $tahunId }}">{{ ucfirst($tahun->status_tahunAjaran) }}</span>
                                        </div>
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

{{-- Toggle Switch Status Tahun Ajaran --}}
<script>
    const tahunToggles = document.querySelectorAll('.tahunAjaran-toggle');
    tahunToggles.forEach(function (toggle) {
        toggle.addEventListener('change', function () {
            const tahunId = this.dataset.id;
            const isChecked = this.checked;
            const newStatus = isChecked ? 'aktif' : 'nonaktif';
            const switchEl = this;

            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: `Status tahun ajaran akan diubah menjadi ${newStatus.toUpperCase()}`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Ya, ubah!',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Batal',
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(`status_tahunAjaran_text_${tahunId}`).textContent = newStatus.charAt(0).toUpperCase() + newStatus.slice(1);

                    fetch(`/tahun-ajaran/${tahunId}/toggle-status`, {
                        method: 'PATCH',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        },
                        body: JSON.stringify({ status_tahunAjaran: newStatus })
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
</script>
@endsection
