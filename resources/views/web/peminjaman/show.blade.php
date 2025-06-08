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
                                <td>{{ $peminjaman->user->mahasiswa->prodi->singkatan_prodi }}
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

                <ul>
                    @foreach ($peminjaman->peralatan as $alat)
                        @php
                            $unit = null;
                            if ($peminjaman->unitPeralatan instanceof \Illuminate\Support\Collection) {
                                // Cari unit yang punya id_peralatan sama dengan alat ini
                                $unit = $peminjaman->unitPeralatan->first(function ($u) use ($alat) {
                                    return $u->id_peralatan == $alat->id_peralatan;
                                });
                            }
                        @endphp

                        <li>
                            @if ($unit)
                                {{ $alat->nama_peralatan }} (Kode Unit: {{ $unit->kode_unit }})
                            @else
                                {{ $alat->nama_peralatan }}
                            @endif
                        </li>
                    @endforeach
                </ul>
                @auth
                    @if (Auth::user()->role === 'teknisi')
                        <div class="mt-4 d-flex justify-content-end gap-2">
                            @if ($peminjaman->status_peminjaman === 'pengajuan')
                                <div>
                                    <form action="{{ route('peminjaman.setujui', $peminjaman->id_peminjaman) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('PUT')
                                        {{-- <button type="submit" class="btn btn-primary">Setujui</button> --}}
                                        <button type="button" class="btn btn-primary"
                                            onclick="confirmSetujui({{ $peminjaman->id_peminjaman }})">
                                            Setujui
                                        </button>
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
                                        {{-- <button type="submit" class="btn btn-success">Selesai</button> --}}
                                        <button type="button" class="btn btn-success"
                                            onclick="confirmSelesai({{ $peminjaman->id_peminjaman }})">
                                            Selesai
                                        </button>
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
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
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

    {{-- Popup Alasan Peminjaman Bermasalah --}}
    <script>
        function showBermasalahModal(id) {
            Swal.fire({
                title: 'Alasan Peminjaman Bermasalah',
                input: 'textarea',
                inputLabel: 'Masukkan alasan masalah',
                inputPlaceholder: 'Contoh: proyektor yang dikembalikan tidak sesuai...',
                inputAttributes: {
                    'aria-label': 'Alasan masalah'
                },
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Simpan',
                cancelButtonText: 'Batal',
                inputValidator: (value) => {
                    if (!value) {
                        return 'Alasan tidak boleh kosong!';
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

                    const alasan_bermasalah = document.createElement('input');
                    alasan_bermasalah.type = 'hidden';
                    alasan_bermasalah.name = 'alasan_bermasalah';
                    alasan_bermasalah.value = result.value;
                    form.appendChild(alasan_bermasalah);

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

    <script>
        function confirmSetujui(id) {
            Swal.fire({
                title: 'Konfirmasi Persetujuan',
                text: "Yakin ingin menyetujui peminjaman ini?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Setujui!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Submit form dengan method PUT
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `{{ route('peminjaman.setujui', ':id') }}`.replace(':id', id);

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

                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }

        function confirmSelesai(id) {
            Swal.fire({
                title: 'Konfirmasi Penyelesaian',
                text: "Yakin peminjaman sudah selesai?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Selesai!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `{{ route('peminjaman.selesai', ':id') }}`.replace(':id', id);

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

                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }
    </script>
@endsection
