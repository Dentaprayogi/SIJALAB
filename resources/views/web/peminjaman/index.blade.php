@extends('web.layouts.app')
@section('content')

<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between">
            <h1 class="h3 mb-2 text-gray-800">Riwayat Peminjaman</h1>
            <a href="{{ route('peminjaman.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Peminjaman
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <ul class="nav nav-tabs mb-3" id="statusTabs" role="tablist">
                    @php
                        $statusList = ['semua' => 'Semua', 'pengajuan' => 'Pengajuan', 'dipinjam' => 'Dipinjam', 'selesai' => 'Selesai', 'ditolak' => 'Ditolak'];
                    @endphp
                    @foreach ($statusList as $key => $label)
                        <li class="nav-item">
                            <a class="nav-link {{ $loop->first ? 'active' : '' }}" id="tab-{{ $key }}" data-toggle="tab" href="#{{ $key }}" role="tab">
                                {{ $label }}
                            </a>
                        </li>
                    @endforeach
                </ul>

                <div class="tab-content" id="statusTabContent">
                    @foreach ($statusList as $key => $label)
                        <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="{{ $key }}">
                            @php
                                $filtered = $key === 'semua' ? $peminjamans : $peminjamans->where('status_peminjaman', $key);
                            @endphp
                            @include('web.peminjaman.partials.table', [
                                'data' => $filtered,
                                'tableId' => 'dataTable' . ucfirst($key)
                            ])
                        </div>
                    @endforeach
                </div>
                <form id="bulk-delete-form" method="POST" action="{{ route('peminjaman.bulkDelete') }}">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="selected_ids" id="selected-ids">
                    <button type="submit" class="btn btn-danger btn-sm">
                        <i class="fas fa-trash"></i> Hapus Terpilih
                    </button>
                </form>                
            </div>
        </div>
    </div>
</div>

{{-- SweetAlert2 --}}
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
        button.addEventListener('click', function (e) {
            e.preventDefault();
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data peminjaman akan dihapus secara permanen.",
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
            });
        });
    });
</script>

{{-- Bulk Delete --}}
<script>
    const selectedIds = new Set();

    function syncCheckboxes() {
        document.querySelectorAll('.select-item').forEach(cb => {
            cb.checked = selectedIds.has(cb.value);
        });

        document.querySelectorAll('table').forEach(table => {
            const checkboxes = table.querySelectorAll('.select-item');
            const selectAll = table.querySelector('#select-all');
            if (!selectAll || checkboxes.length === 0) return;
            selectAll.checked = Array.from(checkboxes).every(cb => cb.checked);
        });
    }

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

    document.getElementById('bulk-delete-form').addEventListener('submit', function (e) {
        e.preventDefault();

        if (selectedIds.size === 0) {
            Swal.fire('Peringatan', 'Pilih minimal satu data untuk dihapus.', 'warning');
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

    document.querySelectorAll('a[data-toggle="tab"]').forEach(tab => {
        tab.addEventListener('shown.bs.tab', function () {
            setTimeout(() => {
                syncCheckboxes();
                initCheckboxListeners();
                initSelectAllListeners();
            }, 100);
        });
    });

    document.addEventListener('DOMContentLoaded', function () {
        syncCheckboxes();
        initCheckboxListeners();
        initSelectAllListeners();
    });
</script>

@endsection
