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
        const jamMulaiInput = document.getElementById('jam_mulai');
        const now = new Date();
        const pad = num => String(num).padStart(2, '0');
        const currentTime = `${pad(now.getHours())}:${pad(now.getMinutes())}`;
        jamMulaiInput.value = currentTime;

        flatpickr("#jam_mulai", {
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            time_24hr: true,
            locale: "id",
            clickOpens: false // ⛔ Mencegah user membuka time picker
        });

        flatpickr("#jam_selesai", {
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
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
        document.addEventListener('DOMContentLoaded', function() {
            const jamMulaiInput = document.getElementById('jam_mulai');
            const jamSelesaiInput = document.getElementById('jam_selesai');
            const labSelect = document.getElementById('id_lab');

            const errorJamMulai = document.getElementById('error-jam_mulai');
            const errorJamSelesai = document.getElementById('error-jam_selesai');
            const errorLab = document.getElementById('error-lab');

            // 🕒 Atur jam mulai otomatis sesuai waktu saat ini
            const now = new Date();
            const pad = num => String(num).padStart(2, '0');
            const currentTime = `${pad(now.getHours())}:${pad(now.getMinutes())}`;
            jamMulaiInput.value = currentTime;

            function resetErrorMessages() {
                errorJamMulai.innerText = '';
                errorJamSelesai.innerText = '';
                errorLab.innerText = '';
            }

            function fetchAvailableLabs() {
                resetErrorMessages();
                labSelect.innerHTML = '<option value="">-- Pilih Lab --</option>';

                const jamMulai = jamMulaiInput.value;
                const jamSelesai = jamSelesaiInput.value;

                if (!jamMulai || !jamSelesai) {
                    errorLab.innerText = 'Silakan isi jam selesai terlebih dahulu.';
                    return;
                }

                if (jamSelesai <= jamMulai) {
                    errorJamSelesai.innerText = 'Jam selesai harus lebih besar dari jam mulai.';
                    return;
                }

                // Kirim permintaan ke server
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
                            return;
                        }

                        data.forEach(lab => {
                            const option = document.createElement('option');
                            option.value = lab.id_lab;
                            option.textContent = lab.nama_lab;
                            labSelect.appendChild(option);
                        });
                    })
                    .catch(error => {
                        console.error('Error fetching labs:', error);
                        errorLab.innerText = 'Gagal mengambil data lab.';
                    });
            }

            jamSelesaiInput.addEventListener('change', fetchAvailableLabs);
        });
    </script>
@endsection
