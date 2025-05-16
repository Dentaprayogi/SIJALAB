<div class="modal fade" id="modalTambahMatakuliah" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Matakuliah</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"
                    onclick="location.reload();">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('matakuliah.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Matakuliah</label>
                        <input type="text" class="form-control @error('nama_mk') is-invalid @enderror" name="nama_mk"
                            value="{{ old('nama_mk') }}" required>
                        @error('nama_mk')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Prodi</label>
                        <select class="form-control @error('id_prodi') is-invalid @enderror" name="id_prodi" required>
                            <option value="" selected disabled>Pilih Prodi</option>
                            @foreach ($prodi->sortBy('singkatan_prodi') as $item)
                                <option value="{{ $item->id_prodi }}"
                                    {{ old('id_prodi') == $item->id_prodi ? 'selected' : '' }}>
                                    {{ $item->singkatan_prodi }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_prodi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal" onclick="location.reload();">
                        <i class="fas fa-times-circle"></i> Batal
                    </button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
