<!-- Modal Tambah Tahun Ajaran -->
<div class="modal fade" id="tambahTahunAjaranModal" tabindex="-1" role="dialog" aria-labelledby="tambahTahunAjaranModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahTahunAjaranModalLabel">Tambah Tahun Ajaran</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close" onclick="location.reload();">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('tahunajaran.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Tahun Ajaran</label>
                        <input type="text" name="tahun_ajaran" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Semester</label>
                        <select name="semester" class="form-control" required>
                            <option value="">Pilih Semester</option>
                            <option value="ganjil">Ganjil</option>
                            <option value="genap">Genap</option>
                        </select>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal" onclick="location.reload();"><i class="fas fa-times-circle"></i> Batal</button>
                <button type="submit"class="btn btn-success"><i class="fas fa-save"></i> Simpan</button>
            </div>
                </form>
        </div>
    </div>
</div>