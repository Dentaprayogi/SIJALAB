@extends('web.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between">
            <h1 class="h3 mb-2 text-gray-800">Manajemen Jadwal Lab</h1>
            <a href="{{ route('jadwal_lab.create') }}" class="btn btn-primary mb-3">
                <i class="fas fa-plus"></i> Tambah Jadwal
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead class="thead-primary">
                        <tr>
                            <th>No.</th>
                            <th>Hari</th>
                            <th>Lab</th>
                            <th>Jam</th>
                            <th>Mata Kuliah</th>
                            <th>Dosen</th>
                            <th>Prodi</th>
                            <th>Tahun Ajaran</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($jadwalLabs->isEmpty())
                            <tr>
                                <td colspan="12" class="text-center">Belum Ada Data</td>
                            </tr>
                        @else
                            @foreach ($jadwalLabs as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->hari->nama_hari }}</td>
                                    <td>{{ $item->lab->nama_lab }}</td>
                                    <td>{{ $item->rentang_jam }}</td>                                  
                                    <td>{{ $item->mataKuliah->nama_mk }}</td>
                                    <td>{{ $item->dosen->nama_dosen }}</td>
                                    <td>{{ $item->prodi->kode_prodi }} ({{ $item->kelas->nama_kelas }})</td>
                                    <td>{{ $item->tahunAjaran->tahun_ajaran }} ({{ ucfirst($item->tahunAjaran->semester) }})</td>
                                    <td>
                                        <span class="badge-status {{ $item->status_jadwalLab === 'aktif' ? 'badge-success' : 'badge-danger' }}">
                                            {{ ucfirst($item->status_jadwalLab) }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('jadwal_lab.edit', $item->id_jadwalLab) }}" class="btn btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('jadwal_lab.destroy', $item->id_jadwalLab) }}" method="POST" style="display:inline-block;" class="form-delete">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-delete" type="button" data-id="{{ $item->id_jadwalLab }}" title="Hapus">
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
                text: "Data jadwal lab yang dihapus tidak bisa dikembalikan!",
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
