@extends('web.layouts.app')

@section('content')
<div class="card-header py-3">
    <h1 class="h3 mb-2 text-gray-800">Edit Jadwal Lab</h1>
    <h2 class="h6 mb-2">
        <span class="text-primary">
            <a href="{{ route('jadwal_lab.index') }}" class="text-primary">Jadwal Lab</a> /
            <a href="{{ route('jadwal_lab.edit', $jadwalLab->id_jadwalLab) }}" class="text-primary">Edit Jadwal Lab</a>
        </span>
    </h2>
</div>

<div class="container-fluid mt-3">
    <div class="card shadow-lg mb-4">
        <div class="card-body">
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('jadwal_lab.update', $jadwalLab->id_jadwalLab) }}" method="POST" class="needs-validation" novalidate>
                @csrf
                @method('PUT')

                <div class="row">
                    <!-- Kolom Kiri -->
                    <div class="col-md-6">
                        {{-- Tahun Ajaran --}}
                        <div class="mb-3">
                            <label for="id_tahunAjaran" class="form-label">Tahun Ajaran</label>
                            <div class="input-group">
                                <span class="input-group-text bg-primary text-white">
                                    <i class="fas fa-calendar-alt"></i>
                                </span>
                                <select name="id_tahunAjaran" id="id_tahunAjaran" class="form-control" required>
                                    <option value="">-- Pilih Tahun Ajaran --</option>
                                    @foreach($tahunAjaranList as $tahun)
                                        <option value="{{ $tahun->id_tahunAjaran }}" {{ $jadwalLab->id_tahunAjaran == $tahun->id_tahunAjaran ? 'selected' : '' }}>{{ $tahun->tahun_ajaran }} ({{ ucfirst($tahun->semester) }})</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">Tahun ajaran wajib dipilih.</div>
                            </div>
                        </div>

                        {{-- Hari --}}
                        <div class="mb-3">
                            <label for="id_hari" class="form-label">Hari</label>
                            <div class="input-group">
                                <span class="input-group-text bg-primary text-white">
                                    <i class="fas fa-calendar-day"></i>
                                </span>
                                <select name="id_hari" id="id_hari" class="form-control" required>
                                    <option value="">-- Pilih Hari --</option>
                                    @foreach($hariList as $hari)
                                        <option value="{{ $hari->id_hari }}" {{ $jadwalLab->id_hari == $hari->id_hari ? 'selected' : '' }}>{{ $hari->nama_hari }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">Hari wajib dipilih.</div>
                            </div>
                        </div>

                        {{-- Laboratorium --}}
                        <div class="mb-3">
                            <label for="id_lab" class="form-label">Laboratorium</label>
                            <div class="input-group">
                                <span class="input-group-text bg-primary text-white">
                                    <i class="fas fa-desktop"></i>
                                </span>
                                <select name="id_lab" id="id_lab" class="form-control" required>
                                    <option value="">-- Pilih Lab --</option>
                                    @foreach($labList as $lab)
                                        <option value="{{ $lab->id_lab }}" {{ $jadwalLab->id_lab == $lab->id_lab ? 'selected' : '' }}>{{ $lab->nama_lab }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">Lab wajib dipilih.</div>
                            </div>
                        </div>

                        {{-- Jam Mulai --}}
                        <div class="mb-3">
                            <label for="jam_mulai" class="form-label">Jam Mulai</label>
                            <div class="input-group">
                                <span class="input-group-text bg-primary text-white">
                                    <i class="fas fa-clock"></i>
                                </span>
                                <input type="text" name="jam_mulai" id="jam_mulai" class="form-control" value="{{ $jadwalLab->jam_mulai }}" required>
                                <div class="invalid-feedback">Jam mulai wajib diisi.</div>
                            </div>
                        </div>

                         {{-- Jam Selesai --}}
                         <div class="mb-3">
                            <label for="jam_selesai" class="form-label">Jam Selesai</label>
                            <div class="input-group">
                                <span class="input-group-text bg-primary text-white">
                                    <i class="fas fa-clock"></i>
                                </span>
                                <input type="text" name="jam_selesai" id="jam_selesai" class="form-control" value="{{ $jadwalLab->jam_selesai }}" required>
                                <div class="invalid-feedback">Jam selesai wajib diisi.</div>
                            </div>
                        </div>
                    </div>

                    <!-- Kolom Kanan -->
                    <div class="col-md-6">
                        {{-- Program Studi --}}
                        <div class="mb-3">
                            <label for="id_prodi" class="form-label">Program Studi</label>
                            <div class="input-group">
                                <span class="input-group-text bg-primary text-white">
                                    <i class="fas fa-graduation-cap"></i>
                                </span>
                                <select name="id_prodi" id="id_prodi" class="form-control select2" required>
                                    <option value="">-- Pilih Prodi --</option>
                                    @foreach($prodiList as $prodi)
                                        <option value="{{ $prodi->id_prodi }}" {{ $jadwalLab->id_prodi == $prodi->id_prodi ? 'selected' : '' }}>{{ $prodi->kode_prodi }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">Prodi wajib dipilih.</div>
                            </div>
                        </div>

                        {{-- Kelas --}}
                        <div class="mb-3">
                            <label for="id_kelas" class="form-label">Kelas</label>
                            <div class="input-group">
                                <span class="input-group-text bg-primary text-white">
                                    <i class="fas fa-users"></i>
                                </span>
                                <select name="id_kelas" id="id_kelas" class="form-control select2 dynamic-select" required>
                                    <option value="{{ $jadwalLab->kelas->id_kelas }}">{{ $jadwalLab->kelas->nama_kelas }}</option>
                                </select>
                                <div class="invalid-feedback">Kelas wajib dipilih.</div>
                            </div>
                        </div>

                        {{-- Mata Kuliah --}}
                        <div class="mb-3">
                            <label for="id_mk" class="form-label">Mata Kuliah</label>
                            <div class="input-group">
                                <span class="input-group-text bg-primary text-white">
                                    <i class="fas fa-book"></i>
                                </span>
                                <select name="id_mk" id="id_mk" class="form-control select2 dynamic-select" required>
                                    <option value="{{ $jadwalLab->matakuliah->id_mk }}">{{ $jadwalLab->matakuliah->nama_mk }}</option>
                                </select>
                                <div class="invalid-feedback">Mata kuliah wajib dipilih.</div>
                            </div>
                        </div>

                        {{-- Dosen --}}
                        <div class="mb-3">
                            <label for="id_dosen" class="form-label">Dosen</label>
                            <div class="input-group">
                                <span class="input-group-text bg-primary text-white">
                                    <i class="fas fa-chalkboard-teacher"></i>
                                </span>
                                <select name="id_dosen" id="id_dosen" class="form-control select2 dynamic-select" required>
                                    <option value="{{ $jadwalLab->dosen->id_dosen }}">{{ $jadwalLab->dosen->nama_dosen }}</option>
                                </select>
                                <div class="invalid-feedback">Dosen wajib dipilih.</div>
                            </div>
                        </div>

                        {{-- Status Jadwal --}}
                        <div class="mb-3">
                            <label for="status_jadwalLab" class="form-label">Status Jadwal</label>
                            <div class="form-switch-toggle">
                                <input type="hidden" name="status_jadwalLab" id="status_jadwalLab_hidden" value="{{ old('status_jadwalLab', $jadwalLab->status_jadwalLab) }}">
                                <input type="checkbox" id="status_jadwalLab_switch" class="switch-toggle" {{ old('status_jadwalLab', $jadwalLab->status_jadwalLab) == 'aktif' ? 'checked' : '' }}>
                                <label for="status_jadwalLab_switch" class="switch-label"></label>
                                <span id="status_jadwalLab_text">{{ old('status_jadwalLab', $jadwalLab->status_jadwalLab) == 'aktif' ? 'Aktif' : 'Nonaktif' }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end">
                    <div>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save"></i> Update
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- SweetAlert error --}}
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

<!-- library Flatpickr -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/id.js"></script>
<script>
    flatpickr("#jam_mulai", {
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i",
        time_24hr: true,
        locale: "id"
    });

    flatpickr("#jam_selesai", {
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i",
        time_24hr: true,
        locale: "id"
    });
</script>

{{-- Dynamic dependent selects --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        // Aktifkan select2
        $('.select2').select2();

        $('#id_prodi').on('change', function () {
            let prodiId = $(this).val();

            if (prodiId) {
                $.ajax({
                    url: `/get-dependent-data/${prodiId}`,
                    type: 'GET',
                    dataType: 'json',
                    success: function (data) {
                        // Kosongkan opsi lama
                        $('#id_kelas').empty().append('<option value="">-- Pilih Kelas --</option>');
                        $('#id_mk').empty().append('<option value="">-- Pilih Mata Kuliah --</option>');
                        $('#id_dosen').empty().append('<option value="">-- Pilih Dosen --</option>');

                        // Tambahkan data kelas
                        $.each(data.kelas, function (key, item) {
                            $('#id_kelas').append(`<option value="${item.id_kelas}">${item.nama_kelas}</option>`);
                        });

                        // Tambahkan data mata kuliah
                        $.each(data.mk, function (key, item) {
                            $('#id_mk').append(`<option value="${item.id_mk}">${item.nama_mk}</option>`);
                        });

                        // Tambahkan data dosen
                        $.each(data.dosen, function (key, item) {
                            $('#id_dosen').append(`<option value="${item.id_dosen}">${item.nama_dosen}</option>`);
                        });

                        // Refresh select2 setelah update
                        $('#id_kelas').trigger('change.select2');
                        $('#id_mk').trigger('change.select2');
                        $('#id_dosen').trigger('change.select2');
                    }
                });
            }
        });
    });
</script>

{{-- Script untuk toggle status --}}
<script>
    document.getElementById('status_jadwalLab_switch').addEventListener('change', function () {
        var statusText = document.getElementById('status_jadwalLab_text');
        var hiddenInput = document.getElementById('status_jadwalLab_hidden');
    
        if (this.checked) {
            statusText.innerText = 'Aktif';
            hiddenInput.value = 'aktif';
        } else {
            statusText.innerText = 'Nonaktif';
            hiddenInput.value = 'nonaktif';
        }
    });
    </script>
@endsection
