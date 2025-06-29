@extends('web.layouts.app')
@section('content')
    <div class="card-header py-3">
        <h3 class="h3 mb-2 text-gray-800">
            Selamat Datang <b>{{ Auth::user()->name }}!</b>
        </h3>
        <h2 class="h6 mb-3">
            Berikut ini informasi mengenai ketersediaan ruangan laboratorium komputer yang dimiliki jurusan Bisnis dan
            Informatika!
        </h2>

        <div class="bg-light p-3 rounded border mb-0">
            <h5 class="text-dark mb-3">
                <i class="fas fa-info-circle me-1 text-primary"></i> Keterangan Status Laboratorium:
            </h5>
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3">
                <div class="col mb-3">
                    <div class="d-flex align-items-start">
                        <span class="badge badge-success fs-6 py-2 px-3 rounded-pill">Tersedia</span>
                        <span class="text-muted fs-6" style="margin-left: 10px;">Sudah terjadwal, belum dipinjam</span>
                    </div>
                </div>
                <div class="col mb-3">
                    <div class="d-flex align-items-start">
                        <span class="badge badge-warning text-dark fs-6 py-2 px-3 rounded-pill">Pengajuan</span>
                        <span class="text-muted fs-6" style="margin-left: 10px;">Menunggu persetujuan</span>
                    </div>
                </div>
                <div class="col mb-3">
                    <div class="d-flex align-items-start">
                        <span class="badge badge-nonaktif fs-6 py-2 px-3 rounded-pill">Nonaktif</span>
                        <span class="text-muted fs-6" style="margin-left: 10px;">Dialihfungsikan</span>
                    </div>
                </div>
                <div class="col mb-3">
                    <div class="d-flex align-items-start">
                        <span class="badge badge-secondary fs-6 py-2 px-3 rounded-pill">Kosong</span>
                        <span class="text-muted fs-6" style="margin-left: 10px;">Belum memiliki jadwal atau pengajuan</span>
                    </div>
                </div>
                <div class="col mb-3">
                    <div class="d-flex align-items-start">
                        <span class="badge badge-primary fs-6 py-2 px-3 rounded-pill">Dipinjam</span>
                        <span class="text-muted fs-6" style="margin-left: 10px;">Sedang digunakan</span>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="container-fluid mt-4">
        <div class="row">
            @foreach ($labs as $lab)
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm text-center" data-toggle="modal" data-target="#modalLab{{ $lab->id_lab }}"
                        style="cursor: pointer;">
                        <img src="{{ asset('assets/img/lab.jpg') }}" class="mx-auto d-block" style="max-width: 300px;"
                            alt="Foto Lab">
                        <div class="card-body">
                            <h5 class="card-title">Lab. {{ $lab->nama_lab }}</h5>
                            @php
                                $statusClass = match ($lab->status) {
                                    'Tersedia' => 'badge-success',
                                    'Dipinjam' => 'badge-primary',
                                    'Kosong' => 'badge-secondary',
                                    'Pengajuan' => 'badge-warning',
                                    'Nonaktif' => 'badge-nonaktif',
                                    default => 'light',
                                };
                            @endphp
                            <span class="badge-status {{ $statusClass }}">{{ $lab->status }}</span>
                        </div>
                    </div>
                </div>
                @include('web.dashboard.informasi_peminjam')
            @endforeach
        </div>
    </div>
@endsection
