<!-- Modal Edit Tahun Ajaran -->
@foreach ($tahunAjaran as $tahun)
<div class="modal fade" id="editTahunAjaranModal{{ $tahun->id_tahunAjaran }}" tabindex="-1" role="dialog" aria-labelledby="editTahunAjaranModalLabel{{ $tahun->id_tahunAjaran }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editTahunAjaranModalLabel{{ $tahun->id_tahunAjaran }}">Edit Tahun Ajaran</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('tahunajaran.update', $tahun->id_tahunAjaran) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id_tahunAjaran" value="{{ $tahun->id_tahunAjaran }}">
                    <div class="mb-3">
                        <label class="form-label">Tahun Ajaran</label>
                        <input type="text" name="tahun_ajaran" class="form-control" value="{{ $tahun->tahun_ajaran }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Semester</label>
                        <select name="semester" class="form-control" required>
                            <option value="ganjil" {{ $tahun->semester == 'ganjil' ? 'selected' : '' }}>Ganjil</option>
                            <option value="genap" {{ $tahun->semester == 'genap' ? 'selected' : '' }}>Genap</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status Tahun Ajaran</label>
                        <div class="form-switch-toggle">
                            <input type="hidden" name="status_tahunAjaran" id="status_tahunAjaran_hidden" value="{{ $tahun->status_tahunAjaran }}">
                            <input type="checkbox" id="status_tahunAjaran_switch" class="switch-toggle" {{ $tahun->status_tahunAjaran == 'aktif' ? 'checked' : '' }}>
                            <label for="status_tahunAjaran_switch" class="switch-label"></label>
                            <span id="status_text">{{ $tahun->status_tahunAjaran == 'aktif' ? 'Aktif' : 'Nonaktif' }}</span>
                        </div>
                    </div>                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i class="fas fa-times-circle"></i> Batal</button>
                        <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const statusSwitch = document.getElementById("status_tahunAjaran_switch");
        const statusHidden = document.getElementById("status_tahunAjaran_hidden");
        const statusText = document.getElementById("status_text");

        statusSwitch.addEventListener("change", function () {
            if (this.checked) {
                statusHidden.value = "aktif";
                statusText.innerText = "Aktif";
            } else {
                statusHidden.value = "nonaktif";
                statusText.innerText = "Nonaktif";
            }
        });
    });
</script>

@endforeach
