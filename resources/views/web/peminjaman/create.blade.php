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

    <!-- library Flatpickr -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/id.js"></script>

    <script>
        flatpickr("#jam_mulai", {
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i", // format 24 jam
            time_24hr: true,
            locale: "id"
        });

        flatpickr("#jam_selesai", {
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i", // format 24 jam
            time_24hr: true,
            locale: "id"
        });
    </script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

    {{-- Script getAvailableLabs --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const jamMulaiInput = document.getElementById('jam_mulai');
            const jamSelesaiInput = document.getElementById('jam_selesai');
            const labSelect = document.getElementById('id_lab');

            const errorJamMulai = document.getElementById('error-jam_mulai');
            const errorJamSelesai = document.getElementById('error-jam_selesai');
            const errorLab = document.getElementById('error-lab');

            function fetchAvailableLabs() {
                const jamMulai = jamMulaiInput.value;
                const jamSelesai = jamSelesaiInput.value;

                // Reset error messages
                errorJamMulai.innerText = '';
                errorJamSelesai.innerText = '';
                errorLab.innerText = '';
                labSelect.innerHTML = '<option value="">-- Pilih Lab --</option>';

                if (!jamMulai || !jamSelesai) {
                    errorLab.innerText = 'Silakan isi jam mulai dan jam selesai terlebih dahulu.';
                    return;
                }

                // Validasi: jamMulai tidak boleh kurang dari waktu sekarang
                const now = new Date();
                const nowTime = now.toTimeString().slice(0, 5); // Format "HH:MM"

                if (jamMulai < nowTime) {
                    errorJamMulai.innerText = 'Jam mulai tidak boleh lebih kecil dari waktu saat ini (' + nowTime +
                        ').';
                    return;
                }

                if (jamSelesai <= jamMulai) {
                    errorJamSelesai.innerText = 'Jam selesai harus lebih besar dari jam mulai.';
                    return;
                }

                // Fetch data lab tersedia
                fetch("{{ route('labs.available') }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        },
                        body: JSON.stringify({
                            jam_mulai: jamMulai,
                            jam_selesai: jamSelesai
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.length === 0) {
                            errorLab.innerText = 'Tidak ada lab tersedia di waktu tersebut.';
                        } else {
                            data.forEach(lab => {
                                labSelect.innerHTML +=
                                    `<option value="${lab.id_lab}">${lab.nama_lab}</option>`;
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching labs:', error);
                        errorLab.innerText = 'Gagal mengambil data lab.';
                    });
            }

            jamMulaiInput.addEventListener('change', fetchAvailableLabs);
            jamSelesaiInput.addEventListener('change', fetchAvailableLabs);
        });
    </script>
@endsection
