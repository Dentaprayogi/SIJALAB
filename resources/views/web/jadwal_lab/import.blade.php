<!-- Modal Import -->
<div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="importModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{{ route('jadwal_lab.import') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="importModalLabel">Import Jadwal Lab</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="file">Pilih File Excel (.xlsx)</label>
                        <input type="file" name="file" class="form-control-file" accept=".xlsx" required>
                    </div>
                    <div class="mt-3">
                        <a href="{{ route('jadwal_lab.template') }}" class="btn btn-link">
                            <i class="fas fa-download"></i> Download Template
                        </a>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Import</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </form>
    </div>
</div>
