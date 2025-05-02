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
                <ul class="nav nav-tabs mb-3" id="jadwalTabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="tab-semua" data-toggle="tab" href="#semua" role="tab">Semua</a>
                    </li>
                    @php
                        $hariList = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];
                    @endphp
                    @foreach ($hariList as $hari)
                        <li class="nav-item">
                            <a class="nav-link" id="tab-{{ strtolower($hari) }}" data-toggle="tab" href="#{{ strtolower($hari) }}" role="tab">{{ $hari }}</a>
                        </li>
                    @endforeach
                </ul>
                <div class="tab-content" id="jadwalTabContent">

                    {{-- Semua --}}
                    <div class="tab-pane fade show active" id="semua">
                        @include('web.jadwal_lab.partials.table', [
                            'data' => $jadwalLabs,
                            'tableId' => 'dataTableSemua'
                        ])
                    </div>
                
                    {{-- Per Hari --}}
                    @foreach(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'] as $hari)
                        <div class="tab-pane fade" id="{{ strtolower($hari) }}">
                            @php
                                $filtered = $jadwalLabs->filter(fn($item) => $item->hari->nama_hari === $hari);
                            @endphp
                            @include('web.jadwal_lab.partials.table', [
                                'data' => $filtered,
                                'tableId' => 'dataTable' . $hari
                            ])
                        </div>
                    @endforeach
                
                </div>                                              
                <form id="bulk-delete-form" method="POST" action="{{ route('jadwal_lab.bulkDelete') }}">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="selected_ids" id="selected-ids">
                    <button type="submit" class="btn btn-danger mb-3" id="bulk-delete-btn">
                        <i class="fas fa-trash"></i> Hapus Terpilih
                    </button>
                </form>                
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

{{-- Toggle switch status jadwal lab --}}
<script>
    const jadwalToggles = document.querySelectorAll('.jadwalLab-toggle');

    jadwalToggles.forEach(function (toggle) {
    toggle.addEventListener('change', function (e) {
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
                document.getElementById(`status_jadwalLab_text_${jadwalId}`).textContent = newStatus.charAt(0).toUpperCase() + newStatus.slice(1);

                fetch(`/jadwal-lab/${jadwalId}/toggle-status`, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: JSON.stringify({ status_jadwalLab: newStatus })
                })
                .then(response => response.json())
                .then(data => {
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
                    switchEl.checked = !isChecked;
                });
            } else {
                switchEl.checked = !isChecked;
            }
        });
    });
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
            cb.addEventListener('change', function () {
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
                selectAll.addEventListener('change', function () {
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
    document.getElementById('bulk-delete-form').addEventListener('submit', function (e) {
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
        tab.addEventListener('shown.bs.tab', function () {
            // Tunggu sedikit agar konten tab selesai dirender
            setTimeout(() => {
                syncCheckboxes();
                initCheckboxListeners();
                initSelectAllListeners();
            }, 100);
        });
    });

    // Inisialisasi awal
    document.addEventListener('DOMContentLoaded', function () {
        syncCheckboxes();
        initCheckboxListeners();
        initSelectAllListeners();
    });
</script>

@endsection
