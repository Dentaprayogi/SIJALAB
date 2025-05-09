<div class="tab-pane fade {{ isActiveTab('manual') }}" id="manual" role="tabpanel">
    <form action="{{ route('peminjaman.storeManual') }}" method="POST">
        @csrf
        <input type="hidden" name="_form_type" value="manual">

        <div class="row">
            {{-- Jam Mulai --}}
            <div class="col-md-6 mb-3">
                <label for="jam_mulai" class="form-label">Jam Mulai</label>
                <div class="input-group">
                    <span class="input-group-text bg-primary text-white">
                        <i class="fas fa-clock"></i>
                    </span>
                    <input type="text" name="jam_mulai" id="jam_mulai" class="form-control" value="{{ old('jam_mulai') }}" required>
                    <div class="invalid-feedback">Jam mulai wajib diisi.</div>
                </div>
            </div>

            {{-- Jam Selesai --}}
            <div class="col-md-6 mb-3">
                <label for="jam_selesai" class="form-label">Jam Selesai</label>
                <div class="input-group">
                    <span class="input-group-text bg-primary text-white">
                        <i class="fas fa-clock"></i>
                    </span>
                    <input type="text" name="jam_selesai" id="jam_selesai" class="form-control" value="{{ old('jam_selesai') }}" required>
                    <div class="invalid-feedback">Jam selesai wajib diisi.</div>
                </div>
            </div>
        </div>

        {{-- Lab --}}
        <div class="mb-3">
            <label for="id_lab" class="form-label">Lab</label>
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

        {{-- Keterangan --}}
        <div class="mb-3">
            <label for="keterangan" class="form-label">Keterangan</label>
            <textarea name="keterangan" id="keterangan" class="form-control">{{ old('keterangan') }}</textarea>
        </div>

        {{-- Peralatan --}}
        <div class="mb-3">
            <label class="form-label">Peralatan</label><br>
            @foreach ($peralatans as $alat)
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="peralatan[]" id="alat_manual{{ $alat->id_peralatan }}" value="{{ $alat->id_peralatan }}"
                        {{ is_array(old('peralatan')) && in_array($alat->id_peralatan, old('peralatan')) ? 'checked' : '' }}>
                    <label class="form-check-label" for="alat_manual{{ $alat->id_peralatan }}">
                        {{ $alat->nama_peralatan }}
                    </label>
                </div>
            @endforeach
        </div>

        <div class="d-flex justify-content-end">
            <button type="submit" class="btn btn-success">
                <i class="fas fa-paper-plane"></i> Ajukan
            </button>
        </div>
    </form>
</div>
