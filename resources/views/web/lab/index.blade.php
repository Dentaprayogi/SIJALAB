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
                                @foreach ($lab as $labs)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $labs->nama_lab }}</td>
                                        <td>
                                            <div class="form-switch-toggle">
                                                @php
                                                    $labId = $labs->id_lab;
                                                @endphp

                                                <input type="hidden" name="status_lab"
                                                    id="status_lab_hidden_{{ $labId }}"
                                                    value="{{ $labs->status_lab }}">

                                                <input type="checkbox" id="status_lab_switch_{{ $labId }}"
                                                    class="switch-toggle lab-toggle" data-id="{{ $labId }}"
                                                    {{ $labs->status_lab == 'aktif' ? 'checked' : '' }}>

                                                <label for="status_lab_switch_{{ $labId }}"
                                                    class="switch-label"></label>
                                                <span
                                                    id="status_lab_text_{{ $labId }}">{{ ucfirst($labs->status_lab) }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <a href="{{ route('lab.edit', $labs->id_lab) }}" class="btn btn-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('lab.destroy', $labs->id_lab) }}" method="POST"
                                                style="display:inline-block;" class="form-delete">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger btn-delete" type="button"
                                                    data-id="{{ $labs->id_lab }}" title="Hapus">
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
                showConfirmButton: 'Ok'
            });
        </script>
    @endif

    <script>
        document.querySelectorAll('.btn-delete').forEach(button => {
            button.addEventListener('click', function() {
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

    {{-- Script Toggle Switch Status Lab --}}
    <script>
        const labToggles = document.querySelectorAll('.lab-toggle');

        labToggles.forEach(function(toggle) {
            toggle.addEventListener('change', function() {
                const labId = this.dataset.id;
                const isChecked = this.checked;
                const newStatus = isChecked ? 'aktif' : 'nonaktif';
                const switchEl = this;

                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: `Status lab akan diubah menjadi ${newStatus.toUpperCase()}`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, ubah!',
                    cancelButtonColor: '#d33',
                    cancelButtonText: 'Batal',
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById(`status_lab_text_${labId}`).textContent = newStatus
                            .charAt(0).toUpperCase() + newStatus.slice(1);

                        fetch(`/lab/${labId}/toggle-status`, {
                                method: 'PATCH',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                },
                                body: JSON.stringify({
                                    status_lab: newStatus
                                })
                            })
                            .then(async response => {
                                const data = await response.json();

                                if (response.ok) {
                                    // ✅ Jika status 200 (berhasil)
                                    document.getElementById(`status_lab_text_${labId}`)
                                        .textContent = newStatus
                                        .charAt(0).toUpperCase() + newStatus.slice(1);

                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Berhasil',
                                        text: data.message
                                    });
                                } else {
                                    // ❌ Jika status bukan 2xx, berarti gagal (contoh: 422 dari validasi Laravel)
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Gagal',
                                        text: data.message ||
                                            'Terjadi kesalahan saat mengubah status.'
                                    });
                                    // Kembalikan toggle switch ke posisi semula
                                    switchEl.checked = !isChecked;
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal',
                                    text: 'Terjadi kesalahan koneksi.'
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
