<div class="mb-3">
    <label for="peralatan" class="form-label">Peralatan</label>
    <div class="d-flex align-items-center border rounded overflow-hidden">
        <span class="bg-primary text-white px-3 py-2 d-flex align-items-center">
            <i class="fas fa-tools"></i>
        </span>
        <select name="peralatan[]" id="peralatan" class="form-select border-0" multiple required style="width: 100%;">
            @foreach ($peralatans as $alat)
                <option value="{{ $alat->id_peralatan }}"
                    {{ is_array(old('peralatan')) && in_array($alat->id_peralatan, old('peralatan')) ? 'selected' : '' }}>
                    {{ $alat->nama_peralatan }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="invalid-feedback">Peralatan wajib dipilih.</div>
</div>
