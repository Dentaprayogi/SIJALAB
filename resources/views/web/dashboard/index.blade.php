@extends('web.layouts.app')
@section('content')
    <div class="card-header py-3">
        <h3 class="h3 mb-2 text-gray-800">
            Selamat Datang <b>{{ Auth::user()->name }}!</b>
        </h3>
        <h2 class="h6 mb-2">
            Berikut ini informasi mengenai ketersediaan ruangan laboratorium komputer yang dimiliki jurusan Bisnis dan
            Informatika!
        </h2>
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
