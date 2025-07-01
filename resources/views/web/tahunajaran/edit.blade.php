<!-- Modal Edit Tahun Ajaran -->
@foreach ($tahunAjaran as $tahun)
    <div class="modal fade" id="editTahunAjaranModal{{ $tahun->id_tahunAjaran }}" tabindex="-1" role="dialog"
        aria-labelledby="editTahunAjaranModalLabel{{ $tahun->id_tahunAjaran }}" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editTahunAjaranModalLabel{{ $tahun->id_tahunAjaran }}">Edit Tahun Ajaran
                    </h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"
                        onclick="location.reload();">
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
                            <select name="tahun_ajaran" class="form-control" required>
                                <option value="" disabled>Pilih Tahun Ajaran</option>

                                @php
                                    $tahunSekarang = date('Y');
                                    $tahunAwal = $tahunSekarang - 2; // dua tahun terakhir
                                    $tahunAkhir = $tahunSekarang + 2; // dua tahun ke depan
                                    $terpilih = old('tahun_ajaran', $tahun->tahun_ajaran ?? null);
                                @endphp

                                @for ($t = $tahunAkhir; $t >= $tahunAwal; $t--)
                                    @php
                                        $opsi = $t . '/' . ($t + 1);
                                    @endphp
                                    <option value="{{ $opsi }}" {{ $terpilih === $opsi ? 'selected' : '' }}>
                                        {{ $opsi }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Semester</label>
                            <select name="semester" class="form-control" required>
                                <option value="ganjil" {{ $tahun->semester == 'ganjil' ? 'selected' : '' }}>Ganjil
                                </option>
                                <option value="genap" {{ $tahun->semester == 'genap' ? 'selected' : '' }}>Genap
                                </option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Status Tahun Ajaran</label>
                            <div class="form-switch-toggle">
                                @php $id = $tahun->id_tahunAjaran; @endphp
                                <input type="hidden" name="status_tahunAjaran"
                                    id="status_tahunAjaran_hidden_{{ $id }}"
                                    value="{{ $tahun->status_tahunAjaran }}">
                                <input type="checkbox" id="status_tahunAjaran_switch_{{ $id }}"
                                    class="switch-toggle" {{ $tahun->status_tahunAjaran == 'aktif' ? 'checked' : '' }}>
                                <label for="status_tahunAjaran_switch_{{ $id }}"
                                    class="switch-label"></label>
                                <span
                                    id="status_text_{{ $id }}">{{ $tahun->status_tahunAjaran == 'aktif' ? 'Aktif' : 'Nonaktif' }}</span>
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
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const switch_{{ $id }} = document.getElementById(
                "status_tahunAjaran_switch_{{ $id }}");
            const hidden_{{ $id }} = document.getElementById(
                "status_tahunAjaran_hidden_{{ $id }}");
            const text_{{ $id }} = document.getElementById("status_text_{{ $id }}");

            if (switch_{{ $id }}) {
                switch_{{ $id }}.addEventListener("change", function() {
                    if (this.checked) {
                        hidden_{{ $id }}.value = "aktif";
                        text_{{ $id }}.innerText = "Aktif";
                    } else {
                        hidden_{{ $id }}.value = "nonaktif";
                        text_{{ $id }}.innerText = "Nonaktif";
                    }
                });
            }
        });
    </script>
@endforeach
