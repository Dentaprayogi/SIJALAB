@extends('web.layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between">
                <h1 class="h3 mb-0 text-gray-800">Detail Peminjaman</h1>
                <a href="{{ route('peminjaman.index') }}" class="btn btn-primary">Kembali</a>
            </div>
            <div class="card-body">
                <div class="row">
                    <!-- Kolom Kiri -->
                    <div class="col-md-6">
                        <h5>Informasi Mahasiswa</h5>
                        <table class="table table-striped table-bordered">
                            <tr>
                                <th>Nama Mahasiswa</th>
                                <td>{{ $peminjaman->user->name }}</td>
                            </tr>
                            <tr>
                                <th>NIM</th>
                                <td>{{ $peminjaman->user->mahasiswa->nim }}</td>
                            </tr>
                            <tr>
                                <th>Prodi</th>
                                <td>{{ $peminjaman->user->mahasiswa->prodi->kode_prodi }}
                                    ({{ $peminjaman->user->mahasiswa->kelas->nama_kelas }})</td>
                            </tr>
                            <tr>
                                <th>Telepon</th>
                                <td>{{ $peminjaman->user->mahasiswa->telepon }}</td>
                            </tr>
                        </table>
                    </div>

                    <!-- Kolom Kanan -->
                    <div class="col-md-6 text-center">
                        @if ($peminjaman->user->mahasiswa->foto_ktm)
                            <label class="font-weight-bold">Foto KTM</label>
                            <div class="mt-2">
                                <img src="{{ asset('storage/' . $peminjaman->user->mahasiswa->foto_ktm) }}" alt="Foto KTM"
                                    class="img-thumbnail" style="max-width: 300px;">
                            </div>
                        @else
                            <p class="text-danger">Foto KTM belum diunggah.</p>
                        @endif
                    </div>
                </div>

                <div class="mt-4">
                    @if ($peminjaman->jadwalLab)
                        @include('web.peminjaman.show_jadwal')
                    @else
                        @include('web.peminjaman.show_manual')
                    @endif
                </div>

                <div class="mt-4">
                    <h5>Peralatan yang Dipinjam</h5>
                    @if ($peminjaman->peralatan->count())
                        <ul>
                            @foreach ($peminjaman->peralatan as $alat)
                                <li>{{ $alat->nama_peralatan }}</li>
                            @endforeach
                        </ul>
                    @else
                        <p><em>Tidak ada peralatan yang dipinjam.</em></p>
                    @endif

                </div>
                @auth
                    @if (Auth::user()->role === 'teknisi')
                        <div class="mt-4 d-flex justify-content-end gap-2">
                            @if ($peminjaman->status_peminjaman === 'pengajuan')
                                <div>
                                    <form action="{{ route('peminjaman.setujui', $peminjaman->id_peminjaman) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-primary">Setujui</button>
                                    </form>

                                    <button type="button" class="btn btn-danger"
                                        onclick="showTolakModal({{ $peminjaman->id_peminjaman }})">Tolak</button>
                                </div>
                            @elseif ($peminjaman->status_peminjaman === 'dipinjam')
                                <div>
                                    <form action="javascript:void(0)" class="d-inline">
                                        <button type="button" class="btn btn-danger"
                                            onclick="showBermasalahModal({{ $peminjaman->id_peminjaman }})">
                                            Peminjaman Bermasalah
                                        </button>
                                    </form>
                                    <form action="{{ route('peminjaman.selesai', $peminjaman->id_peminjaman) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-success">Selesai</button>
                                    </form>
                                </div>
                            @elseif ($peminjaman->status_peminjaman === 'bermasalah')
                                <div>
                                    <form action="{{ route('peminjaman.selesai', $peminjaman->id_peminjaman) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-success">Selesai</button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    @endif
                @endauth
            </div>
        </div>
    </div>

    {{-- SweetAlert 2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    {{-- Popup Alasan Ditolak --}}
    <script>
        function showTolakModal(id) {
            Swal.fire({
                title: 'Tolak Peminjaman',
                input: 'textarea',
                inputLabel: 'Alasan Penolakan',
                inputPlaceholder: 'Tulis alasan penolakan di sini...',
                inputAttributes: {
                    'aria-label': 'Alasan penolakan'
                },
                showCancelButton: true,
                confirmButtonText: 'Tolak',
                cancelButtonText: 'Batal',
                inputValidator: (value) => {
                    if (!value) {
                        return 'Alasan wajib diisi!';
                    }
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Membuat form dengan metode PUT
                    const form = document.createElement('form');
                    form.method = 'POST';

                    // Menggunakan route untuk menyesuaikan URL dan mengganti :id
                    form.action = `{{ route('peminjaman.tolak', ':id') }}`.replace(':id', id);

                    // Membuat input _token untuk CSRF
                    const csrf = document.createElement('input');
                    csrf.type = 'hidden';
                    csrf.name = '_token';
                    csrf.value = '{{ csrf_token() }}';
                    form.appendChild(csrf);

                    // Membuat input _method untuk menentukan metode PUT
                    const method = document.createElement('input');
                    method.type = 'hidden';
                    method.name = '_method';
                    method.value = 'PUT'; // Ini akan memberi tahu Laravel untuk menggunakan metode PUT
                    form.appendChild(method);

                    // Menambahkan alasan penolakan
                    const alasan = document.createElement('input');
                    alasan.type = 'hidden';
                    alasan.name = 'alasan_ditolak';
                    alasan.value = result.value;
                    form.appendChild(alasan);

                    // Menambahkan form ke dalam body dan mengirimkannya
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }
    </script>

    {{-- Popup Catatan Peminjaman Bermasalah --}}
    <script>
        function showBermasalahModal(id) {
            Swal.fire({
                title: 'Catatan Peminjaman Bermasalah',
                input: 'textarea',
                inputLabel: 'Masukkan catatan masalah',
                inputPlaceholder: 'Contoh: Lab tidak dikembalikan tepat waktu...',
                inputAttributes: {
                    'aria-label': 'Catatan masalah'
                },
                showCancelButton: true,
                confirmButtonText: 'Simpan',
                cancelButtonText: 'Batal',
                inputValidator: (value) => {
                    if (!value) {
                        return 'Catatan tidak boleh kosong!';
                    }
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Buat form dan submit via POST/PUT
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `{{ route('peminjaman.bermasalah', ':id') }}`.replace(':id', id);

                    const csrf = document.createElement('input');
                    csrf.type = 'hidden';
                    csrf.name = '_token';
                    csrf.value = '{{ csrf_token() }}';
                    form.appendChild(csrf);

                    const method = document.createElement('input');
                    method.type = 'hidden';
                    method.name = '_method';
                    method.value = 'PUT';
                    form.appendChild(method);

                    const catatan = document.createElement('input');
                    catatan.type = 'hidden';
                    catatan.name = 'catatan';
                    catatan.value = result.value;
                    form.appendChild(catatan);

                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }
    </script>


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

    @if ($errors->any())
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Gagal menyimpan data!',
                html: `{!! implode('<br>', $errors->all()) !!}`,
                confirmButtonText: 'OK'
            });
        </script>
    @endif

@endsection
