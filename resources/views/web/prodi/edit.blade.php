<!-- Modal Edit Prodi -->
@foreach ($prodi as $prod)
    <div class="modal fade" id="modalEditProdi{{ $prod->id_prodi }}" tabindex="-1" role="dialog"
        aria-labelledby="modalEditProdiLabel{{ $prod->id_prodi }}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditProdiLabel{{ $prod->id_prodi }}">Edit Prodi</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"
                        onclick="location.reload();">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('prodi.update', $prod->id_prodi) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id_prodi" value="{{ $prod->id_prodi }}">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nama_prodi{{ $prod->id_prodi }}" class="form-label">Nama Prodi</label>
                            <input type="text" class="form-control @error('nama_prodi') is-invalid @enderror"
                                id="nama_prodi{{ $prod->id_prodi }}" name="nama_prodi" value="{{ $prod->nama_prodi }}"
                                required>
                            @error('nama_prodi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="singkatan_prodi{{ $prod->id_prodi }}" class="form-label">Singkatan Prodi</label>
                            <input type="text" class="form-control @error('singkatan_prodi') is-invalid @enderror"
                                id="singkatan_prodi{{ $prod->id_prodi }}" name="singkatan_prodi"
                                value="{{ $prod->singkatan_prodi }}" required>
                            @error('singkatan_prodi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal"
                            onclick="location.reload();">
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
@endforeach
