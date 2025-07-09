@extends('web.layouts.app')
@section('content')
    <div class="card-header py-3">
        <h3 class="h3 mb-2 text-gray-800">Form Peminjaman</h3>
        <h2 class="h6 mb-2">
            <span class="text-primary">
                <a href="{{ route('peminjaman.index') }}" class="text-primary">Riwayat Peminjaman</a> /
                <a href="{{ route('peminjaman.create') }}" class="text-primary">Tambah Peminjaman</a>
            </span>
        </h2>
    </div>
    <div class="container-fluid">
        <br>
        {{-- Menentukan tab aktif berdasarkan error --}}
        @php
            $activeTab = session()->getOldInput('_form_type', 'jadwal');
            function isActiveTab($tab)
            {
                return session('active_tab') === $tab ? 'show active' : '';
            }
        @endphp



        <ul class="nav nav-tabs mb-3" id="myTab" role="tablist">
            @php
                $tabs = ['jadwal' => 'Sesuai Jadwal', 'manual' => 'Di Luar Jadwal'];
            @endphp

            @foreach ($tabs as $key => $label)
                <li class="nav-item">
                    <a class="nav-link {{ $activeTab == $key ? 'active' : '' }}" id="{{ $key }}-tab"
                        data-toggle="tab" href="#{{ $key }}" role="tab">
                        {{ $label }}
                    </a>
                </li>
            @endforeach
        </ul>

        <div class="card shadow-lg mb-4">
            <div class="card-body">
                <div class="tab-content" id="myTabContent">
                    @include('web.peminjaman.form_jadwal', ['active' => $activeTab === 'jadwal'])
                    @include('web.peminjaman.form_manual', ['active' => $activeTab === 'manual'])
                </div>
            </div>
        </div>
    </div>

    <!-- SweetAlert2 -->
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

    {{-- Script getAvailableLabs --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {

            const ddlMulai = document.getElementById('id_sesi_mulai');
            const ddlSelesai = document.getElementById('id_sesi_selesai');
            const ddlLab = document.getElementById('id_lab');

            /* elemen pesan error */
            const errMulai = document.getElementById('error-id_sesi_mulai');
            const errSelesai = document.getElementById('error-id_sesi_selesai');
            const errLab = document.getElementById('error-lab');

            function resetErrors() {
                errMulai.textContent = '';
                errSelesai.textContent = '';
                errLab.textContent = '';
            }

            function fetchLabs() {
                resetErrors();
                ddlLab.innerHTML = '<option value="">-- Pilih Lab --</option>';

                const mulaiOpt = ddlMulai.options[ddlMulai.selectedIndex];
                const selesaiOpt = ddlSelesai.options[ddlSelesai.selectedIndex];

                /* pastikan keduanya sudah dipilih */
                if (!mulaiOpt.value || !selesaiOpt.value) {
                    errLab.textContent = 'Pilih sesi mulai & sesi selesai dahulu.';
                    return;
                }

                // validasi urutan sesi
                const startMulai = mulaiOpt.dataset.start;
                const startSelesai = selesaiOpt.dataset.start;

                if (startMulai > startSelesai) {
                    errSelesai.textContent = 'Sesi selesai tidak boleh sebelum sesi mulai.';
                    return;
                }

                /* kirim ke server */
                fetch("{{ route('labs.available') }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        },
                        body: JSON.stringify({
                            id_sesi_mulai: mulaiOpt.value,
                            id_sesi_selesai: selesaiOpt.value
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.length === 0) {
                            errLab.textContent = 'Tidak ada lab tersedia di rentang sesi tersebut.';
                            return;
                        }
                        data.forEach(lab => {
                            const opt = document.createElement('option');
                            opt.value = lab.id_lab;
                            opt.textContent = lab.nama_lab;
                            ddlLab.appendChild(opt);
                        });
                    })
                    .catch(() => errLab.textContent = 'Gagal mengambil data lab.');
            }

            /* trigger saat sesi mulai / selesai diubah */
            ddlMulai.addEventListener('change', fetchLabs);
            ddlSelesai.addEventListener('change', fetchLabs);
        });
    </script>
@endsection
