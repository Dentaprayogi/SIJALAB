<!-- Modal Tambah Prodi -->
<div class="modal fade" id="modalTambahProdi" tabindex="-1" aria-labelledby="modalTambahProdiLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTambahProdiLabel">Tambah Prodi</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"
                    onclick="location.reload();">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('prodi.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nama_prodi" class="form-label">Nama Prodi</label>
                        <input type="text" class="form-control @error('nama_prodi') is-invalid @enderror"
                            id="nama_prodi" name="nama_prodi" required>
                        @error('nama_prodi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="singkatan_prodi" class="form-label">Singkatan Prodi</label>
                        <input type="text" class="form-control @error('singkatan_prodi') is-invalid @enderror"
                            id="singkatan_prodi" name="singkatan_prodi" required>
                        @error('singkatan_prodi')
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
