<!-- Modal Tambah Peralatan -->
<div class="modal fade" id="modalTambahPeralatan" tabindex="-1" aria-labelledby="modalTambahPeralatanLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTambahPeralatanLabel">Tambah Peralatan</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close" onclick="location.reload();">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('peralatan.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nama_peralatan" class="form-label">Nama Peralatan</label>
                        <input type="text" class="form-control @error('nama_peralatan') is-invalid @enderror" id="nama_peralatan" name="nama_peralatan" required>
                        @error('nama_peralatan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal" onclick="location.reload();">
                        <i class="fas fa-times-circle"></i> Batal</button>
                    <button type="submit"class="btn btn-success"><i class="fas fa-save"></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
