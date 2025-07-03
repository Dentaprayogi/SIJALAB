@extends('web.layouts.app')

@section('content')
    <div class="card-header py-3">
        <h1 class="h3 mb-2 text-gray-800">Tambah Jadwal Lab</h1>
        <h2 class="h6 mb-2">
            <span class="text-primary">
                <a href="{{ route('jadwal_lab.index') }}" class="text-primary">Jadwal Lab</a> /
                <a href="{{ route('jadwal_lab.create') }}" class="text-primary">Tambah Jadwal Lab</a>
            </span>
        </h2>
    </div>

    <div class="container-fluid mt-3">
        <div class="card shadow-lg mb-4">
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form id="form-jadwal" action="{{ route('jadwal_lab.store') }}" method="POST" class="needs-validation"
                    novalidate>
                    @csrf
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
                                        @foreach ($tahunAjaranList as $tahun)
                                            <option value="{{ $tahun->id_tahunAjaran }}"
                                                {{ old('id_tahunAjaran') == $tahun->id_tahunAjaran ? 'selected' : '' }}>
                                                {{ $tahun->tahun_ajaran }} ({{ ucfirst($tahun->semester) }})
                                            </option>
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
                                        @foreach ($hariList as $hari)
                                            <option value="{{ $hari->id_hari }}"
                                                {{ old('id_hari') == $hari->id_hari ? 'selected' : '' }}>
                                                {{ $hari->nama_hari }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">Hari wajib dipilih.</div>
                                </div>
                            </div>

                            <div class="row">
                                {{-- Jam Mulai --}}
                                <div class="col-md-6 mb-3">
                                    <label for="jam_mulai" class="form-label">Sesi Mulai</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-primary text-white">
                                            <i class="fas fa-clock"></i>
                                        </span>
                                        <select name="id_sesi_mulai" id="id_sesi_mulai" class="form-control" required>
                                            <option value="">-- Pilih Sesi Mulai --</option>
                                            @foreach ($sesiJamList as $sesi)
                                                <option value="{{ $sesi->id_sesi_jam }}"
                                                    {{ old('id_sesi_mulai') == $sesi->id_sesi_jam ? 'selected' : '' }}>
                                                    {{ $sesi->nama_sesi }}
                                                    ({{ \Carbon\Carbon::parse($sesi->jam_mulai)->format('H:i') }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                {{-- Jam Selesai --}}
                                <div class="col-md-6 mb-3">
                                    <label for="jam_selesai" class="form-label">Sesi Selesai</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-primary text-white">
                                            <i class="fas fa-clock"></i>
                                        </span>
                                        <select name="id_sesi_selesai" id="id_sesi_selesai" class="form-control" required>
                                            <option value="">-- Pilih Sesi Selesai --</option>
                                            @foreach ($sesiJamList as $sesi)
                                                <option value="{{ $sesi->id_sesi_jam }}"
                                                    {{ old('id_sesi_selesai') == $sesi->id_sesi_jam ? 'selected' : '' }}>
                                                    {{ $sesi->nama_sesi }}
                                                    ({{ \Carbon\Carbon::parse($sesi->jam_selesai)->format('H:i') }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
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
                                        @foreach ($labList as $lab)
                                            <option value="{{ $lab->id_lab }}"
                                                {{ old('id_lab') == $lab->id_lab ? 'selected' : '' }}>
                                                {{ $lab->nama_lab }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback bentrok-error" style="display: none;"></div>
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
                                    <select name="id_prodi" id="id_prodi" class="form-control" required>
                                        <option value="">-- Pilih Prodi --</option>
                                        @foreach ($prodiList as $prodi)
                                            <option value="{{ $prodi->id_prodi }}"
                                                {{ old('id_prodi') == $prodi->id_prodi ? 'selected' : '' }}>
                                                {{ $prodi->singkatan_prodi }}
                                            </option>
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
                                    <select name="id_kelas" id="id_kelas" class="form-control" required>
                                        <option value="">-- Pilih Kelas --</option>
                                        @if (old('id_prodi'))
                                            @foreach ($kelasList as $kelas)
                                                @if ($kelas->id_prodi == old('id_prodi'))
                                                    <option value="{{ $kelas->id_kelas }}"
                                                        {{ old('id_kelas') == $kelas->id_kelas ? 'selected' : '' }}>
                                                        {{ $kelas->nama_kelas }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        @endif
                                    </select>
                                    <div class="invalid-feedback bentrok-error" style="display: none;"></div>
                                </div>
                            </div>

                            {{-- Mata Kuliah --}}
                            <div class="mb-3">
                                <label for="id_mk" class="form-label">Mata Kuliah</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-primary text-white">
                                        <i class="fas fa-book"></i>
                                    </span>
                                    <select name="id_mk" id="id_mk" class="form-control" required>
                                        <option value="">-- Pilih Mata Kuliah --</option>
                                        @if (old('id_prodi'))
                                            @foreach ($mkList as $mk)
                                                @if ($mk->id_prodi == old('id_prodi'))
                                                    <option value="{{ $mk->id_mk }}"
                                                        {{ old('id_mk') == $mk->id_mk ? 'selected' : '' }}>
                                                        {{ $mk->nama_mk }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        @endif
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
                                    <select name="id_dosen" id="id_dosen" class="form-control" required>
                                        <option value="">-- Pilih Dosen --</option>
                                        @if (old('id_prodi'))
                                            @foreach ($dosenList as $dosen)
                                                @if ($dosen->id_prodi == old('id_prodi'))
                                                    <option value="{{ $dosen->id_dosen }}"
                                                        {{ old('id_dosen') == $dosen->id_dosen ? 'selected' : '' }}>
                                                        {{ $dosen->nama_dosen }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        @endif
                                    </select>
                                    <div class="invalid-feedback bentrok-error" style="display: none;"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end">
                        <div>
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save"></i> Simpan
                            </button>
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
                title: 'Gagal menyimpan data!',
                html: `{!! implode('<br>', $errors->all()) !!}`,
                confirmButtonText: 'OK'
            });
        </script>
    @endif

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    {{-- Load data kelas, mata kuliah, dan dosen secara dinamis sesuai prodi --}}
    <script>
        $(document).ready(function() {
            $('#id_prodi').on('change', function() {
                var prodiId = $(this).val();

                if (prodiId) {
                    $.ajax({
                        url: '/get-dependent-data/' + prodiId,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            // Kosongkan semua dulu
                            $('#id_kelas').empty().append(
                                '<option value="">-- Pilih Kelas --</option>');
                            $('#id_mk').empty().append(
                                '<option value="">-- Pilih Mata Kuliah --</option>');
                            $('#id_dosen').empty().append(
                                '<option value="">-- Pilih Dosen --</option>');

                            // Isi dengan data baru
                            $.each(data.kelas, function(index, value) {
                                $('#id_kelas').append('<option value="' + value
                                    .id_kelas + '">' + value.nama_kelas +
                                    '</option>');
                            });

                            $.each(data.mk, function(index, value) {
                                $('#id_mk').append('<option value="' + value.id_mk +
                                    '">' + value.nama_mk + '</option>');
                            });

                            $.each(data.dosen, function(index, value) {
                                $('#id_dosen').append('<option value="' + value
                                    .id_dosen + '">' + value.nama_dosen +
                                    '</option>');
                            });

                            // Setelah isi, refresh Select2
                            $('#id_kelas').select2({
                                placeholder: "-- Pilih Kelas --",
                                allowClear: true
                            });
                            $('#id_mk').select2({
                                placeholder: "-- Pilih Mata Kuliah --",
                                allowClear: true
                            });
                            $('#id_dosen').select2({
                                placeholder: "-- Pilih Dosen --",
                                allowClear: true
                            });
                        },
                        error: function() {
                            alert('Terjadi kesalahan saat mengambil data. Coba lagi nanti.');
                        }
                    });
                } else {
                    // Kalau Prodi kosong, kosongkan semua dropdown juga
                    $('#id_kelas').empty().append('<option value="">-- Pilih Kelas --</option>').trigger(
                        'change');
                    $('#id_mk').empty().append('<option value="">-- Pilih Mata Kuliah --</option>').trigger(
                        'change');
                    $('#id_dosen').empty().append('<option value="">-- Pilih Dosen --</option>').trigger(
                        'change');
                }
            });

            // Awal: aktifkan select2
            $('#id_kelas').select2({
                placeholder: "-- Pilih Kelas --",
                allowClear: true
            });
            $('#id_mk').select2({
                placeholder: "-- Pilih Mata Kuliah --",
                allowClear: true
            });
            $('#id_dosen').select2({
                placeholder: "-- Pilih Dosen --",
                allowClear: true
            });
        });
    </script>

    {{-- Cek bentrok lab, dosen, kelas, sesi --}}
    <script>
        $(document).ready(function() {
            /** 1. Bersihkan error **/
            function clearBentrok() {
                $('.bentrok-error').hide().text('');
                $('.is-invalid').removeClass('is-invalid');
                $('.select2-selection').removeClass('is-invalid');
            }

            /** 2. Tampilkan error **/
            function showError(fieldName, message) {
                const $input = $(`[name="${fieldName}"]`);
                const $wrapper = $input.closest('.input-group');

                $input.addClass('is-invalid');

                // Jika pakai Select2
                if ($input.hasClass('select2-hidden-accessible')) {
                    $input.next('.select2-container')
                        .find('.select2-selection')
                        .addClass('is-invalid');
                }

                $wrapper.find('.bentrok-error').text(message).show();
            }

            /** 3. Cek bentrok via AJAX **/
            function checkBentrok() {
                clearBentrok();

                const data = {
                    id_hari: $('#id_hari').val(),
                    id_lab: $('#id_lab').val(),
                    id_dosen: $('#id_dosen').val(),
                    id_kelas: $('#id_kelas').val(),
                    id_tahunAjaran: $('#id_tahunAjaran').val(),
                    id_sesi_mulai: $('#id_sesi_mulai').val(),
                    id_sesi_selesai: $('#id_sesi_selesai').val(),
                };

                if (!data.id_hari || !data.id_lab || !data.id_tahunAjaran || !data.id_sesi_mulai || !data
                    .id_sesi_selesai) {
                    return; // tidak cukup data untuk validasi
                }

                $.ajax({
                    url: "{{ url('/jadwal-lab/check-bentrok') }}",
                    method: "GET",
                    data: data,
                    success: function() {
                        // Tidak bentrok, tidak perlu tindakan
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            const errs = xhr.responseJSON.errors;
                            for (let field in errs) {
                                showError(field, errs[field][0]);
                            }
                        }
                    }
                });
            }

            /** 4. Cek bentrok ketika field penting berubah **/
            $('#id_hari, #id_lab, #id_dosen, #id_kelas, #id_tahunAjaran, #id_sesi_mulai, #id_sesi_selesai')
                .on('change', checkBentrok);

            /** 5. Ketika prodi berubah, ambil ulang data terkait dan re-init Select2 **/
            $('#id_prodi').on('change', function() {
                const prodiId = $(this).val();

                if (!prodiId) {
                    $('#id_kelas, #id_mk, #id_dosen').val(null).trigger('change');
                    return;
                }

                $.getJSON('/get-dependent-data/' + prodiId, function(data) {
                    // Utility untuk update & reinit Select2
                    function reloadSelect($el, items, idField, textField, label) {
                        $el.off('change.select2'); // cegah event duplikat
                        $el.select2('destroy');
                        $el.empty().append(`<option value="">-- Pilih ${label} --</option>`);
                        $.each(items, function(_, item) {
                            $el.append(
                                `<option value="${item[idField]}">${item[textField]}</option>`
                            );
                        });
                        $el.select2({
                            placeholder: `-- Pilih ${label} --`,
                            allowClear: true
                        });
                    }

                    reloadSelect($('#id_kelas'), data.kelas, 'id_kelas', 'nama_kelas', 'Kelas');
                    reloadSelect($('#id_mk'), data.mk, 'id_mk', 'nama_mk', 'Mata Kuliah');
                    reloadSelect($('#id_dosen'), data.dosen, 'id_dosen', 'nama_dosen', 'Dosen');

                    checkBentrok(); // trigger ulang pengecekan setelah isi berubah
                });
            });

            /** 6. Inisialisasi awal Select2 **/
            $('#id_kelas, #id_mk, #id_dosen').select2({
                placeholder: "-- Pilih --",
                allowClear: true
            });
        });
    </script>

@endsection
