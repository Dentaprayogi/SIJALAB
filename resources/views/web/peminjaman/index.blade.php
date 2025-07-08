@extends('web.layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h1 class="h3 mb-0 text-gray-800">Riwayat Peminjaman</h1>
                </div>
                <form method="GET" action="{{ route('peminjaman.index') }}" class="form-inline">
                    <div class="form-group mr-2">
                        <label for="bulan" class="mr-2">Pilih Bulan</label>
                        <select name="bulan" id="bulan" class="form-control">
                            <option value="">Semua</option>
                            @foreach (range(1, 12) as $b)
                                <option value="{{ $b }}" {{ request('bulan') == $b ? 'selected' : '' }}>
                                    {{ \Carbon\Carbon::create()->month($b)->translatedFormat('F') }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mr-2">
                        <label for="tahun" class="mr-2">Pilih Tahun</label>
                        <select name="tahun" id="tahun" class="form-control">
                            <option value="">Semua</option>
                            @for ($year = now()->year; $year >= 2020; $year--)
                                <option value="{{ $year }}" {{ request('tahun') == $year ? 'selected' : '' }}>
                                    {{ $year }}
                                </option>
                            @endfor
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-filter"></i> Filter
                    </button>
                    <a href="{{ route('peminjaman.export', request()->query()) }}" class="btn btn-success ml-2">
                        <i class="fas fa-file-excel"></i> Export Excel
                    </a>
                    @auth
                        @if (Auth::user()->role === 'mahasiswa')
                            <a href="{{ route('peminjaman.create') }}" class="btn btn-primary ml-2">
                                <i class="fas fa-plus"></i> Tambah Peminjaman
                            </a>
                        @endif
                    @endauth
                </form>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <ul class="nav nav-tabs mb-3" id="statusTabs" role="tablist">
                        @php
                            $statusList = [
                                'semua' => 'Semua',
                                'pengajuan' => 'Pengajuan',
                                'dipinjam' => 'Dipinjam',
                                'selesai' => 'Selesai',
                                'ditolak' => 'Ditolak',
                                'bermasalah' => 'Bermasalah',
                            ];
                        @endphp
                        @foreach ($statusList as $key => $label)
                            <li class="nav-item">
                                <a class="nav-link {{ $loop->first ? 'active' : '' }}" id="tab-{{ $key }}"
                                    data-toggle="tab" href="#{{ $key }}" role="tab">
                                    {{ $label }}
                                </a>
                            </li>
                        @endforeach
                    </ul>

                    <div class="tab-content" id="statusTabContent">
                        @foreach ($statusList as $key => $label)
                            <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="{{ $key }}">
                                @php
                                    $filtered =
                                        $key === 'semua'
                                            ? $peminjamans
                                            : $peminjamans->where('status_peminjaman', $key);
                                @endphp
                                @include('web.peminjaman.partials.table', [
                                    'data' => $filtered,
                                    'tableId' => 'dataTable' . ucfirst($key),
                                ])
                            </div>
                        @endforeach
                    </div>
                    @auth
                        @if (Auth::user()->role === 'teknisi')
                            <form id="bulk-delete-form" method="POST" action="{{ route('peminjaman.bulkDelete') }}">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="selected_ids" id="selected-ids">
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash"></i> Hapus Terpilih
                                </button>
                            </form>
                        @endif
                    @endauth
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
                showConfirmButton: "Ok"
            });
        </script>
    @endif

    <script>
        document.querySelectorAll('.btn-delete').forEach(button => {
            button.addEventListener('click', function(e) {
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

        document.getElementById('bulk-delete-form').addEventListener('submit', function(e) {
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

        document.querySelectorAll('a[data-toggle="tab"]').forEach(tab => {
            tab.addEventListener('shown.bs.tab', function() {
                setTimeout(() => {
                    syncCheckboxes();
                    initCheckboxListeners();
                    initSelectAllListeners();
                }, 100);
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            syncCheckboxes();
            initCheckboxListeners();
            initSelectAllListeners();
        });
    </script>
@endsection
