@extends('web.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between">
            <h1 class="h3 mb-2 text-gray-800">Daftar Lab</h1>
            <a href="{{ route('lab.create') }}" class="btn btn-primary mb-3">
                <i class="fas fa-plus"></i> Tambah Lab
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead class="thead-primary">
                        <tr>
                            <th>No.</th>
                            <th>Nama</th>
                            <th>Fasilitas</th>
                            <th>Kapasitas</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($lab->isEmpty()) 
                            <tr>
                                <td colspan="6" class="text-center">Belum Ada Data</td>
                            </tr>
                        @else
                            @foreach($lab as $labs)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $labs->nama_lab }}</td>
                                    <td>{{ $labs->fasilitas_lab }}</td>
                                    <td>{{ $labs->kapasitas_lab }}</td>
                                    <td>
                                        <span class="badge-status {{ $labs->status_lab === 'aktif' ? 'badge-success' : 'badge-danger' }}">
                                            {{ ucfirst($labs->status_lab) }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('lab.edit', $labs->id_lab) }}" class="btn btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('lab.destroy', $labs->id_lab) }}" method="POST" style="display:inline-block;" class="form-delete">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-delete" type="button" data-id="{{ $labs->id_lab }}" title="Hapus">
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

{{-- SweetAlert untuk success dan error --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if (session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Berhasil',
        text: '{{ session('success') }}',
        timer: 1500,
        showConfirmButton: false
    });
</script>
@endif

@if (session('error'))
<script>
    Swal.fire({
        icon: 'error',
        title: 'Gagal',
        text: '{{ session('error') }}',
        timer: 1500,
        showConfirmButton: false
    });
</script>
@endif

<script>
    document.querySelectorAll('.btn-delete').forEach(button => {
        button.addEventListener('click', function () {
            const id = this.getAttribute('data-id');
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Lab yang dihapus tidak bisa dikembalikan!",
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
