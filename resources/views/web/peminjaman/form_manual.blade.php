@if ($active)
    <div class="tab-pane fade show active" id="manual" role="tabpanel">
    @else
        <div class="tab-pane fade" id="manual" role="tabpanel">
@endif
<form action="{{ route('peminjaman.storeManual') }}" method="POST">
    @csrf
    <input type="hidden" name="_form_type" value="manual">

    @php
        $oldMulai = old('id_sesi_mulai');
        $oldSelesai = old('id_sesi_selesai');
    @endphp

    <div class="row">
        {{-- Sesi Mulai --}}
        <div class="col-md-6 mb-3">
            <label for="id_sesi_mulai" class="form-label">
                Jam Mulai
                <span id="error-id_sesi_mulai" class="text-danger small ms-2"></span>
            </label>
            <div class="input-group">
                <span class="input-group-text bg-primary text-white">
                    <i class="fas fa-clock"></i>
                </span>
                <select name="id_sesi_mulai" id="id_sesi_mulai" class="form-control" required>
                    <option value="">-- Pilih Jam Mulai --</option>
                    @foreach ($sesiJam as $sesi)
                        <option value="{{ $sesi->id_sesi_jam }}"
                            data-start="{{ \Carbon\Carbon::parse($sesi->jam_mulai)->format('H:i') }}"
                            {{ $oldMulai == $sesi->id_sesi_jam ? 'selected' : '' }}>
                            {{ $sesi->nama_sesi }} ({{ \Carbon\Carbon::parse($sesi->jam_mulai)->format('H:i') }})
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        {{-- Sesi Selesai --}}
        <div class="col-md-6 mb-3">
            <label for="id_sesi_selesai" class="form-label">
                Jam Selesai
                <span id="error-id_sesi_selesai" class="text-danger small ms-2"></span>
            </label>
            <div class="input-group">
                <span class="input-group-text bg-primary text-white">
                    <i class="fas fa-clock"></i>
                </span>
                <select name="id_sesi_selesai" id="id_sesi_selesai" class="form-control" required>
                    <option value="">-- Pilih Jam Selesai --</option>
                    @foreach ($sesiJam as $sesi)
                        <option value="{{ $sesi->id_sesi_jam }}"
                            data-start="{{ \Carbon\Carbon::parse($sesi->jam_mulai)->format('H:i') }}"
                            {{ $oldSelesai == $sesi->id_sesi_jam ? 'selected' : '' }}>
                            {{ $sesi->nama_sesi }} ({{ \Carbon\Carbon::parse($sesi->jam_selesai)->format('H:i') }})
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    {{-- Lab --}}
    <div class="mb-3">
        <label for="id_lab" class="form-label">
            Lab
            <span id="error-lab" class="text-danger small ms-2"></span>
        </label>
        <div class="input-group">
            <span class="input-group-text bg-primary text-white">
                <i class="fas fa-desktop"></i>
            </span>
            <select name="id_lab" id="id_lab" class="form-control" required>
                <option value="">-- Pilih Lab --</option>
                @foreach ($labs as $lab)
                    <option value="{{ $lab->id_lab }}" {{ old('id_lab') == $lab->id_lab ? 'selected' : '' }}>
                        {{ $lab->nama_lab }}
                    </option>
                @endforeach
            </select>
            <div class="invalid-feedback">Lab wajib dipilih.</div>
        </div>
    </div>

    {{-- Kegiatan --}}
    <div class="mb-3">
        <label for="kegiatan" class="form-label">Kegiatan</label>
        <div class="input-group">
            <span class="input-group-text bg-primary text-white">
                <i class="fas fa-tasks"></i> {{-- atau ganti dengan fas fa-book, fas fa-briefcase sesuai konteks --}}
            </span>
            <textarea name="kegiatan" id="kegiatan" class="form-control">{{ old('kegiatan') }}</textarea>
        </div>
    </div>

    {{-- Peralatan --}}
    <div class="mb-3" data-id-peralatan="${id_peralatan}">
        <label for="peralatan" class="form-label">Peralatan</label>
        <div class="d-flex align-items-center border rounded overflow-hidden">
            <span class="bg-primary text-white px-3 py-2 d-flex align-items-center">
                <i class="fas fa-tools"></i>
            </span>
            <select name="peralatan[]" id="peralatan_manual" class="form-select border-0" multiple required
                style="width: 100%;">
                @foreach ($peralatans as $alat)
                    <option value="{{ $alat->id_peralatan }}">{{ $alat->nama_peralatan }}</option>
                @endforeach
            </select>
        </div>
        <div class="invalid-feedback">Peralatan wajib dipilih.</div>
    </div>

    {{-- Dynamic unit peralatan --}}
    <div id="unit-peralatan-container-manual"></div>

    <div class="d-flex justify-content-end">
        <button type="submit" class="btn btn-success">
            <i class="fas fa-paper-plane"></i> Ajukan
        </button>
    </div>
</form>
</div>
