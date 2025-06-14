@foreach ($dosens as $dosen)
    <div class="modal fade" id="modalEditDosen{{ $dosen->id_dosen }}" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Dosen</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"
                        onclick="location.reload();">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('dosen.update', $dosen->id_dosen) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id_dosen" value="{{ $dosen->id_dosen }}">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Nama Dosen</label>
                            <input type="text" class="form-control" name="nama_dosen"
                                value="{{ $dosen->nama_dosen }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Telepon</label>
                            <input type="text" class="form-control" name="telepon" value="{{ $dosen->telepon }}"
                                required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Prodi</label>
                            <select class="form-control" name="id_prodi" required>
                                @foreach ($prodi->sortBy('singkatani') as $p)
                                    <option value="{{ $p->id_prodi }}"
                                        {{ $dosen->id_prodi == $p->id_prodi ? 'selected' : '' }}>
                                        {{ $p->singkatan_prodi }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal"
                            onclick="location.reload();">
                            <i class="fas fa-times-circle"></i> Batal</button>
                        <button type="submit"class="btn btn-success"><i class="fas fa-save"></i> Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach
