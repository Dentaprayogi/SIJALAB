@extends('web.layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between">
                <h1 class="h3 mb-2 text-gray-800">Daftar Unit Peralatan</h1>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                    data-bs-target="#modalTambahUnitPeralatan">
                    <i class="fas fa-plus"></i> Tambah Unit
                </button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead class="thead-primary">
                            <tr>
                                <th>No.</th>
                                <th>Nama Peralatan</th>
                                <th>Kode Unit</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($units->isEmpty())
                                <tr>
                                    <td colspan="5" class="text-center">Belum Ada Data</td>
                                </tr>
                            @else
                                @foreach ($units as $unit)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $unit->peralatan->nama_peralatan ?? '-' }}</td>
                                        <td>{{ $unit->kode_unit }}</td>
                                        <td>
                                            @php
                                                $badgeClass = match ($unit->status_unit) {
                                                    'tersedia' => 'badge-success',
                                                    'dipinjam' => 'badge-primary',
                                                    'rusak' => 'badge-danger',
                                                };
                                            @endphp
                                            <span class="badge-status {{ $badgeClass }}">
                                                {{ ucfirst($unit->status_unit) }}
                                            </span>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                                data-bs-target="#modalEditUnit{{ $unit->id_unit }}" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <form action="{{ route('unit-peralatan.destroy', $unit->id_unit) }}"
                                                method="POST" style="display:inline-block;" class="form-delete">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger btn-delete" type="button"
                                                    data-id="{{ $unit->id_unit }}" title="Hapus">
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

    {{-- Include Modal Tambah dan Edit --}}
    @include('web.unit_peralatan.create')
    @include('web.unit_peralatan.edit')

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: '{{ session('error') }}'
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
                    })
                    .then(() => {
                        let oldId = "{{ old('id_unit') }}";
                        if (oldId) {
                            var editModal = new bootstrap.Modal(document.getElementById('modalEditUnit' +
                                oldId));
                            editModal.show();
                        } else {
                            var tambahModal = new bootstrap.Modal(document.getElementById(
                                'modalTambahUnitPeralatan'));
                            tambahModal.show();
                        }
                    });
            @endif
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
    </script>
@endsection
