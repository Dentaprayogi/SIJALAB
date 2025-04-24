@extends('web.layouts.app')

@section('content')
<div class="card-header py-3">
    <h1 class="h3 mb-2 text-gray-800">Tambah Lab</h1>
    <h2 class="h6 mb-2">
        <span class="text-primary">
            <a href="{{ route('lab.index') }}" class="text-primary">Manajemen Lab</a> /
            <a href="{{ route('lab.create') }}" class="text-primary">Tambah Lab</a>
        </span>
    </h2>
</div>

<div class="container-fluid">
    <br>
    <div class="card shadow-lg mb-4">
        <div class="card-body">
            <form action="{{ route('lab.store') }}" method="POST" class="needs-validation" novalidate>
                @csrf

                <div class="mb-3">
                    <label for="nama_lab" class="form-label">Nama Lab</label>
                    <div class="input-group">
                        <span class="input-group-text bg-primary text-white"><i class="fas fa-building"></i></span>
                        <input type="text" name="nama_lab" class="form-control" value="{{ old('nama_lab') }}" required>
                    </div>
                    <div class="invalid-feedback">Nama Lab tidak boleh kosong.</div>
                </div>

                <div class="mb-3">
                    <label for="fasilitas_lab" class="form-label">Fasilitas</label>
                    <div class="input-group">
                        <span class="input-group-text bg-primary text-white"><i class="fas fa-tools"></i></span>
                        <textarea name="fasilitas_lab" class="form-control" required>{{ old('fasilitas_lab') }}</textarea>
                    </div>
                    <div class="invalid-feedback">Fasilitas tidak boleh kosong.</div>
                </div>

                <div class="mb-3">
                    <label for="kapasitas_lab" class="form-label">Kapasitas</label>
                    <div class="input-group">
                        <span class="input-group-text bg-primary text-white"><i class="fas fa-users"></i></span>
                        <input type="number" name="kapasitas_lab" class="form-control" value="{{ old('kapasitas_lab') }}" required>
                    </div>
                    <div class="invalid-feedback">Kapasitas tidak boleh kosong.</div>
                </div>

                <div class="d-flex justify-content-end">
                    <div>
                        <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Simpan</button>
                        <a href="{{ route('lab.index') }}" class="btn btn-danger ms-3"><i class="fas fa-times-circle"></i> Batal</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if ($errors->any())
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Gagal',
            text: '{{ $errors->first() }}',
            timer: 3000,
            showConfirmButton: false
        });
    </script>
@endif
@endsection
