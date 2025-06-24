<!-- Modal Rentang Waktu Nonaktif -->
<div class="modal fade" id="modalRentangNonaktif" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="modalRentangNonaktifLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formRentangNonaktif">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalRentangNonaktifLabel">Setel Waktu Nonaktif</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"
                        onclick="location.reload();">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="jadwalIdInput" name="jadwal_id">
                    <div class="mb-3">
                        <label for="start_nonaktif" class="form-label">Mulai Nonaktif</label>
                        <input type="datetime-local" id="start_nonaktif" name="start_nonaktif" class="form-control"
                            required readonly>
                    </div>
                    <div class="mb-3">
                        <label for="end_nonaktif" class="form-label">Akhir Nonaktif</label>
                        <input type="datetime-local" id="end_nonaktif" name="end_nonaktif" class="form-control"
                            onfocus="this.showPicker()" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal"
                        onclick="location.reload();">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
