<div class="tab-pane fade {{ $active ? 'show active' : '' }}" id="manual" role="tabpanel">
    @if (
        $errors->has('jam_mulai') || $errors->has('jam_selesai') || $errors->has('id_lab') || old('_form_type') === 'manual'
    )
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->get('jam_mulai') as $error)
                    <li>{{ $error }}</li>
                @endforeach
                @foreach ($errors->get('jam_selesai') as $error)
                    <li>{{ $error }}</li>
                @endforeach
                @foreach ($errors->get('id_lab') as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    <form action="{{ route('peminjaman.storeManual') }}" method="POST">
        @csrf
        <input type="hidden" name="_form_type" value="manual">

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

        {{-- Lab --}}
        <div class="mb-3">
            <label>Lab</label>
            <select name="id_lab" class="form-control" required>
                <option value="">-- Pilih Lab --</option>
                @foreach ($labs as $lab)
                    <option value="{{ $lab->id_lab }}" {{ old('id_lab') == $lab->id_lab ? 'selected' : '' }}>
                        {{ $lab->nama_lab }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Keterangan --}}
        <div class="mb-3">
            <label>Keterangan</label>
            <textarea name="keterangan" class="form-control">{{ old('keterangan') }}</textarea>
        </div>

        {{-- Peralatan --}}
        <div class="mb-3">
            <label>Peralatan</label><br>
            @foreach ($peralatans as $alat)
                <label>
                    <input type="checkbox" name="peralatan[]" value="{{ $alat->id_peralatan }}"
                        {{ is_array(old('peralatan')) && in_array($alat->id_peralatan, old('peralatan')) ? 'checked' : '' }}>
                    {{ $alat->nama_peralatan }}
                </label><br>
            @endforeach
        </div>

        <button class="btn btn-success">Ajukan</button>
    </form>
</div>
