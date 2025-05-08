@extends('web.layouts.app')
@section('content')
<div class="container">
    <h1>Form Peminjaman</h1>

    {{-- Menentukan tab aktif berdasarkan error --}}
    @php
        $activeTab = old('_form_type') === 'manual' ? 'manual' : 'jadwal';
    @endphp

    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link {{ $activeTab == 'jadwal' ? 'active' : '' }}" id="jadwal-tab" data-bs-toggle="tab" data-bs-target="#jadwal" type="button" role="tab">Sesuai Jadwal</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link {{ $activeTab == 'manual' ? 'active' : '' }}" id="manual-tab" data-bs-toggle="tab" data-bs-target="#manual" type="button" role="tab">Di Luar Jadwal</button>
        </li>
    </ul>

    <div class="tab-content mt-3" id="myTabContent">
        @include('web.peminjaman.form_jadwal', ['active' => $activeTab === 'jadwal'])
        @include('web.peminjaman.form_manual', ['active' => $activeTab === 'manual'])
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
