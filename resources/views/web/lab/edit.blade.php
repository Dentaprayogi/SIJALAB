@extends('web.layouts.app')

@section('content')
    <div class="card-header py-3">
        <h1 class="h3 mb-2 text-gray-800">Edit Lab</h1>
        <h2 class="h6 mb-2">
            <span class="text-primary">
                <a href="{{ route('lab.index') }}" class="text-primary">Manajemen Lab</a> /
                <a href="{{ route('lab.edit', $lab->id_lab) }}" class="text-primary">Edit Lab</a>
            </span>
        </h2>
    </div>

    <div class="container-fluid mt-3">
        <div class="card shadow-lg mb-4">
            <div class="card-body">
                <form action="{{ route('lab.update', $lab->id_lab) }}" method="POST" class="needs-validation" novalidate>
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="nama_lab" class="form-label">Nama Lab</label>
                        <div class="input-group">
                            <span class="input-group-text bg-primary text-white"><i class="fas fa-building"></i></span>
                            <input type="text" name="nama_lab" class="form-control"
                                value="{{ old('nama_lab', $lab->nama_lab) }}" required>
                        </div>
                        <div class="invalid-feedback">Nama Lab tidak boleh kosong.</div>
                    </div>

                    <div class="mb-3">
                        <label for="status_lab" class="form-label">Status Lab</label>
                        <div class="form-switch-toggle">
                            <input type="hidden" name="status_lab" id="status_lab_hidden"
                                value="{{ old('status_lab', isset($lab) ? $lab->status_lab : 'nonaktif') }}">
                            <input type="checkbox" id="status_lab_switch" class="switch-toggle"
                                {{ old('status_lab', isset($lab) ? $lab->status_lab : 'nonaktif') == 'aktif' ? 'checked' : '' }}>
                            <label for="status_lab_switch" class="switch-label"></label>
                            <span
                                id="status_lab_text">{{ old('status_lab', isset($lab) ? $lab->status_lab : 'nonaktif') == 'aktif' ? 'Aktif' : 'Nonaktif' }}</span>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end">
                        <div>
                            <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Update</button>
                            <a href="{{ route('lab.index') }}" class="btn btn-danger ms-3"><i
                                    class="fas fa-times-circle"></i> Batal</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- SweetAlert Error --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if ($errors->any())
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: '{{ $errors->first() }}',
                showConfirmButton: 'Ok'
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

    {{-- Script toggle switch status lab --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const statusSwitch = document.getElementById('status_lab_switch');
            const statusHidden = document.getElementById('status_lab_hidden');
            const statusText = document.getElementById('status_lab_text');

            statusSwitch.addEventListener('change', function() {
                if (this.checked) {
                    statusHidden.value = 'aktif';
                    statusText.textContent = 'Aktif';
                } else {
                    statusHidden.value = 'nonaktif';
                    statusText.textContent = 'Nonaktif';
                }
            });
        });
    </script>
@endsection
