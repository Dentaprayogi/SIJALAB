@foreach ($units as $unit)
    <div class="modal fade" id="modalEditUnit{{ $unit->id_unit }}" tabindex="-1"
        aria-labelledby="modalEditUnitLabel{{ $unit->id_unit }}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditUnitLabel{{ $unit->id_unit }}">Edit Unit Peralatan</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"
                        onclick="location.reload();">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('unit-peralatan.update', $unit->id_unit) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id_unit" value="{{ $unit->id_unit }}">

                    <div class="modal-body">

                        <div class="mb-3">
                            <label for="id_peralatan_{{ $unit->id_unit }}" class="form-label">Nama Peralatan</label>
                            <select name="id_peralatan" id="id_peralatan_{{ $unit->id_unit }}"
                                class="form-control  @error('id_peralatan') is-invalid @enderror" required>
                                <option value="">-- Pilih Peralatan --</option>
                                @foreach ($peralatans as $peralatan)
                                    <option value="{{ $peralatan->id_peralatan }}"
                                        {{ old('id_peralatan', $unit->id_peralatan) == $peralatan->id_peralatan ? 'selected' : '' }}>
                                        {{ $peralatan->nama_peralatan }}
                                    </option>
                                @endforeach
                            </select>
                            @if (old('id_unit') == $unit->id_unit)
                                @error('id_peralatan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            @endif
                        </div>

                        <div class="mb-3">
                            <label for="kode_unit_{{ $unit->id_unit }}" class="form-label">Kode Unit</label>
                            <input type="text" name="kode_unit" id="kode_unit_{{ $unit->id_unit }}"
                                class="form-control @error('kode_unit') is-invalid @enderror"
                                value="{{ old('kode_unit', $unit->kode_unit) }}" required>
                            @if (old('id_unit') == $unit->id_unit)
                                @error('kode_unit')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            @endif
                        </div>

                        <div class="mb-3">
                            <label for="status_unit_{{ $unit->id_unit }}" class="form-label">Status Unit</label>
                            <select name="status_unit" id="status_unit_{{ $unit->id_unit }}"
                                class="form-control @error('status_unit') is-invalid @enderror" required>
                                <option value="tersedia"
                                    {{ old('status_unit', $unit->status_unit) == 'tersedia' ? 'selected' : '' }}>
                                    Tersedia</option>
                                {{-- <option value="dipinjam"
                                    {{ old('status_unit', $unit->status_unit) == 'dipinjam' ? 'selected' : '' }}>
                                    Dipinjam</option> --}}
                                <option value="rusak"
                                    {{ old('status_unit', $unit->status_unit) == 'rusak' ? 'selected' : '' }}>
                                    Rusak</option>
                            </select>
                            @if (old('id_unit') == $unit->id_unit)
                                @error('status_unit')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            @endif
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal"
                            onclick="location.reload();">
                            <i class="fas fa-times-circle"></i> Batal</button>
                        <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach
