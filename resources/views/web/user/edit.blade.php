<!-- Modal Edit Mahasiswa -->
<div class="modal fade" id="editMahasiswaModal" tabindex="-1" aria-labelledby="editMahasiswaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="editMahasiswaForm" method="POST" action="{{ route('mahasiswa.update.fromAdmin') }}">
            @csrf
            @method('PUT')
            <input type="hidden" name="id" id="editUserId">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Mahasiswa</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="editNim" class="form-label">NIM</label>
                        <input type="text" class="form-control" id="editNim" name="nim" required>
                    </div>
                    <div class="mb-3">
                        <label for="editProdi" class="form-label">Prodi</label>
                        <select class="form-control" id="editProdi" name="id_prodi" required>
                            <option value="">-- Pilih Prodi --</option>
                            @foreach ($prodiList as $prodi)
                                <option value="{{ $prodi->id_prodi }}">{{ $prodi->singkatan_prodi }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="editKelas" class="form-label">Kelas</label>
                        <select class="form-control" id="editKelas" name="id_kelas" required>
                            <option value="">-- Pilih Kelas --</option>
                            {{-- Data kelas akan di-load via JavaScript --}}
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                        <i class="fas fa-times-circle"></i> Batal
                    </button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i> Simpan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
