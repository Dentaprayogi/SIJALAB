<!-- Modal Edit Peralatan -->
@foreach ($peralatan as $peralatans)
<div class="modal fade" id="modalEditPeralatan{{ $peralatans->id_peralatan }}" tabindex="-1" role="dialog" aria-labelledby="modalEditPeralatanLabel{{ $peralatans->id_peralatan }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEditPeralatanLabel{{ $peralatans->id_peralatan }}">Edit Peralatan</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close" onclick="location.reload();">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('peralatan.update', $peralatans->id_peralatan) }}" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="id_peralatan" value="{{ $peralatans->id_peralatan }}">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nama_peralatan{{ $peralatans->id_peralatan }}" class="form-label">Nama Peralatan</label>
                        <input type="text" class="form-control @error('nama_peralatan') is-invalid @enderror"
                                id="nama_peralatan{{ $peralatans->id_peralatan }}" name="nama_peralatan"
                                value="{{ $peralatans->nama_peralatan }}" required>
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
@endforeach
