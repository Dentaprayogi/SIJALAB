<!-- Modal Tambah Unit -->
<div class="modal fade" id="modalTambahUnitPeralatan" tabindex="-1" aria-labelledby="modalTambahUnitLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('unit-peralatan.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTambahUnitLabel">Tambah Unit Peralatan</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"
                        onclick="location.reload();">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="mb-3">
                        <label for="id_peralatan" class="form-label">Nama Peralatan</label>
                        <select name="id_peralatan" id="id_peralatan"
                            class="form-control @error('id_peralatan') is-invalid @enderror" required>
                            <option value="">-- Pilih Peralatan --</option>
                            @foreach ($peralatans as $peralatan)
                                <option value="{{ $peralatan->id_peralatan }}"
                                    {{ old('id_peralatan') == $peralatan->id_peralatan ? 'selected' : '' }}>
                                    {{ $peralatan->nama_peralatan }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_peralatan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="kode_unit" class="form-label">Kode Unit</label>
                        <input type="text" name="kode_unit"
                            class="form-control @error('kode_unit') is-invalid @enderror" value="{{ old('kode_unit') }}"
                            required>
                        @error('kode_unit')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal"
                        onclick="location.reload();"><i class="fas fa-times-circle"></i> Batal</button>
                    <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
