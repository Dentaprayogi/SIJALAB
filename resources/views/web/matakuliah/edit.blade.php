@foreach ($matakuliah as $mk)
<div class="modal fade" id="modalEditMatakuliah{{ $mk->id_mk }}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Matakuliah</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close" onclick="location.reload();">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('matakuliah.update', $mk->id_mk) }}" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="id_mk" value="{{ $mk->id_mk }}">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label"">Prodi</label>
                        <select class="form-control" name="id_prodi" required>
                            @foreach ($prodi->sortBy('kode_prodi') as $p )
                            <option value="{{ $p->id_prodi }}" {{ $mk->id_prodi == $p->id_prodi ? 'selected' : '' }}>
                                {{ $p->kode_prodi }}
                            </option>                                
                            @endforeach
                        </select>
                   </div>
                   <div class="mb-3">
                        <label class="form-label">Nama Mata Kuliah</label>
                        <input type="text" name="nama_mk" class="form-control" value="{{ $mk->nama_mk }}">
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
@endforeach
