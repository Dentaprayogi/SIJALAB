@extends('web.layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h1 class="h3 mb-2 text-gray-800">Manajemen Jadwal Lab</h1>
                @auth
                    @if (Auth::user()->role === 'teknisi')
                        <div>
                            <a href="{{ route('jadwal_lab.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Tambah Jadwal
                            </a>
                            <button class="btn btn-success" data-toggle="modal" data-target="#importModal">
                                <i class="fas fa-file-import"></i> Import Jadwal
                            </button>
                        </div>
                    @endif
                @endauth
            </div>
            @include('web.jadwal_lab.import')
            <div class="card-body">
                <div class="table-responsive">
                    <ul class="nav nav-tabs mb-3" id="jadwalTabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="tab-semua" data-toggle="tab" href="#semua"
                                role="tab">Semua</a>
                        </li>
                        @php
                            $hariList = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];
                        @endphp
                        @foreach ($hariList as $hari)
                            <li class="nav-item">
                                <a class="nav-link" id="tab-{{ strtolower($hari) }}" data-toggle="tab"
                                    href="#{{ strtolower($hari) }}" role="tab">{{ $hari }}</a>
                            </li>
                        @endforeach
                    </ul>
                    <div class="tab-content" id="jadwalTabContent">

                        {{-- Semua --}}
                        <div class="tab-pane fade show active" id="semua">
                            @include('web.jadwal_lab.partials.table', [
                                'data' => $jadwalLabs,
                                'tableId' => 'dataTableSemua',
                            ])
                        </div>

                        {{-- Per Hari --}}
                        @foreach (['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'] as $hari)
                            <div class="tab-pane fade" id="{{ strtolower($hari) }}">
                                @php
                                    $filtered = $jadwalLabs->filter(fn($item) => $item->hari->nama_hari === $hari);
                                @endphp
                                @include('web.jadwal_lab.partials.table', [
                                    'data' => $filtered,
                                    'tableId' => 'dataTable' . $hari,
                                ])
                            </div>
                        @endforeach
                    </div>
                    @auth
                        @if (Auth::user()->role === 'teknisi')
                            <form id="bulk-delete-form" method="POST" action="{{ route('jadwal_lab.bulkDelete') }}">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="selected_ids" id="selected-ids">
                                <button type="submit" class="btn btn-danger mb-3" id="bulk-delete-btn">
                                    <i class="fas fa-trash"></i> Hapus Terpilih
                                </button>
                            </form>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
    </div>
    @include('web.jadwal_lab.input_waktu')

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
        document.querySelectorAll('.btn-delete').forEach(button => {
            button.addEventListener('click', function() {
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

    {{-- Toggle switch status jadwal lab --}}
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const jadwalToggles = document.querySelectorAll('.jadwalLab-toggle');
            let pendingToggle = null; // Simpan elemen toggle yang terakhir diklik

            jadwalToggles.forEach(function(toggle) {
                toggle.addEventListener('change', function() {
                    const jadwalId = this.dataset.id;
                    const isChecked = this.checked;
                    const newStatus = isChecked ? 'aktif' : 'nonaktif';
                    const switchEl = this;

                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: `Status jadwal lab akan diubah menjadi ${newStatus.toUpperCase()}`,
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Ya, ubah!',
                        cancelButtonColor: '#d33',
                        cancelButtonText: 'Batal',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            if (newStatus === 'nonaktif') {
                                // Simpan elemen toggle dan ID
                                pendingToggle = switchEl;
                                document.getElementById('jadwalIdInput').value = jadwalId;

                                // Tampilkan modal input waktu
                                var modal = new bootstrap.Modal(document.getElementById(
                                    'modalRentangNonaktif'));
                                modal.show();
                            } else {
                                // Jika aktif, langsung kirim tanpa waktu
                                updateStatusJadwal(jadwalId, 'aktif');
                            }
                        } else {
                            switchEl.checked = !isChecked;
                        }
                    });
                });
            });

            // Submit form modal rentang waktu
            const formRentang = document.getElementById('formRentangNonaktif');
            formRentang.addEventListener('submit', function(e) {
                e.preventDefault();
                const jadwalId = document.getElementById('jadwalIdInput').value;
                const waktuMulai = document.getElementById('start_nonaktif').value;
                const waktuAkhir = document.getElementById('end_nonaktif').value;

                if (new Date(waktuMulai) >= new Date(waktuAkhir)) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: 'Waktu akhir harus lebih besar dari waktu mulai!'
                    });
                    return;
                }

                updateStatusJadwal(jadwalId, 'nonaktif', waktuMulai, waktuAkhir);
                var modal = bootstrap.Modal.getInstance(document.getElementById('modalRentangNonaktif'));
                modal.hide();
            });

            // Fungsi kirim data ke server
            function updateStatusJadwal(jadwalId, status, mulai = null, akhir = null) {
                fetch(`/jadwal_lab/${jadwalId}/toggle-status`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        },
                        body: JSON.stringify({
                            _method: 'PATCH',
                            status_jadwalLab: status,
                            waktu_mulai_nonaktif: mulai,
                            waktu_akhir_nonaktif: akhir,
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById(`status_jadwalLab_text_${jadwalId}`).textContent =
                            status.charAt(0).toUpperCase() + status.slice(1);
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

                        // Kembalikan toggle ke status sebelumnya
                        if (pendingToggle) {
                            pendingToggle.checked = (status === 'aktif') ? false : true;
                        }
                    });
            }
        });
    </script>

    {{-- set input mulai nonaktif menggunakan waktu yang berlaku --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modalEl = document.getElementById('modalRentangNonaktif');
            const startInput = document.getElementById('start_nonaktif');

            modalEl.addEventListener('show.bs.modal', function() {
                const now = new Date();
                const year = now.getFullYear();
                const month = String(now.getMonth() + 1).padStart(2, '0');
                const day = String(now.getDate()).padStart(2, '0');
                const hour = String(now.getHours()).padStart(2, '0');
                const minute = String(now.getMinutes()).padStart(2, '0');

                // Format value untuk input datetime-local: "YYYY-MM-DDTHH:MM"
                const formatted = `${year}-${month}-${day}T${hour}:${minute}`;
                startInput.value = formatted;
            });
        });
    </script>

    {{-- set batas minimumn tanggal dan waktu ke waktu sekarang --}}
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const endInput = document.getElementById('end_nonaktif');

            function setMinEndTime() {
                const now = new Date();
                const year = now.getFullYear();
                const month = String(now.getMonth() + 1).padStart(2, '0');
                const day = String(now.getDate()).padStart(2, '0');
                const hours = String(now.getHours()).padStart(2, '0');
                const minutes = String(now.getMinutes()).padStart(2, '0');

                const minDateTime = `${year}-${month}-${day}T${hours}:${minutes}`;
                endInput.min = minDateTime;
            }

            // Set saat halaman dimuat
            setMinEndTime();

            // Optionally, perbarui setiap kali modal dibuka
            const modalElement = document.getElementById('modalRentangNonaktif');
            modalElement.addEventListener('show.bs.modal', setMinEndTime);
        });
    </script>


    {{-- Bulk Delete --}}
    <script>
        // Simpan ID yang terpilih secara global
        const selectedIds = new Set();

        // Fungsi untuk sync checkbox dari selectedIds
        function syncCheckboxes() {
            document.querySelectorAll('.select-item').forEach(cb => {
                cb.checked = selectedIds.has(cb.value);
            });

            // Cek apakah semua checkbox di dalam satu tabel tercentang
            document.querySelectorAll('table').forEach(table => {
                const checkboxes = table.querySelectorAll('.select-item');
                const selectAll = table.querySelector('#select-all');
                if (!selectAll || checkboxes.length === 0) return;
                selectAll.checked = Array.from(checkboxes).every(cb => cb.checked);
            });
        }

        // Event listener untuk setiap checkbox individu
        function initCheckboxListeners() {
            document.querySelectorAll('.select-item').forEach(cb => {
                cb.addEventListener('change', function() {
                    if (this.checked) {
                        selectedIds.add(this.value);
                    } else {
                        selectedIds.delete(this.value);
                    }
                    syncCheckboxes();
                });
            });
        }

        // Event listener untuk select-all per tabel
        function initSelectAllListeners() {
            document.querySelectorAll('table').forEach(table => {
                const selectAll = table.querySelector('#select-all');
                if (selectAll) {
                    selectAll.addEventListener('change', function() {
                        const checkboxes = table.querySelectorAll('.select-item');
                        checkboxes.forEach(cb => {
                            cb.checked = this.checked;
                            if (this.checked) {
                                selectedIds.add(cb.value);
                            } else {
                                selectedIds.delete(cb.value);
                            }
                        });
                        syncCheckboxes();
                    });
                }
            });
        }

        // Event untuk bulk delete form
        document.getElementById('bulk-delete-form').addEventListener('submit', function(e) {
            e.preventDefault();

            if (selectedIds.size === 0) {
                Swal.fire('Peringatan', 'Pilih minimal satu jadwal untuk dihapus.', 'warning');
                return;
            }

            Swal.fire({
                title: 'Yakin ingin menghapus?',
                text: 'Data yang dihapus tidak dapat dikembalikan!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('selected-ids').value = Array.from(selectedIds).join(',');
                    e.target.submit();
                }
            });
        });

        // Inisialisasi saat tab diganti
        document.querySelectorAll('a[data-toggle="tab"]').forEach(tab => {
            tab.addEventListener('shown.bs.tab', function() {
                // Tunggu sedikit agar konten tab selesai dirender
                setTimeout(() => {
                    syncCheckboxes();
                    initCheckboxListeners();
                    initSelectAllListeners();
                }, 100);
            });
        });

        // Inisialisasi awal
        document.addEventListener('DOMContentLoaded', function() {
            syncCheckboxes();
            initCheckboxListeners();
            initSelectAllListeners();
        });
    </script>
@endsection
