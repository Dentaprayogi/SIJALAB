@if ($active)
    <div class="tab-pane fade show active" id="jadwal" role="tabpanel">
    @else
        <div class="tab-pane fade" id="jadwal" role="tabpanel">
@endif
<form action="{{ route('peminjaman.storeJadwal') }}" method="POST">
    @csrf
    <input type="hidden" name="_form_type" value="jadwal">

    <div class="mb-3">
        <label for="id_jadwalLab" class="form-label">Jadwal Lab</label>
        <div class="input-group">
            <span class="input-group-text bg-primary text-white">
                <i class="fas fa-calendar-check"></i>
            </span>
            <select name="id_jadwalLab" class="form-control" required>
                <option value="">-- Pilih Jadwal --</option>
                @foreach ($jadwals as $jadwal)
                    <option value="{{ $jadwal->id_jadwalLab }}"
                        {{ old('id_jadwalLab') == $jadwal->id_jadwalLab ? 'selected' : '' }}>
                        {{ $jadwal->hari->nama_hari }} / Lab.
                        {{ $jadwal->lab->nama_lab }} /
                        {{ $jadwal->prodi->singkatan_prodi }} ({{ $jadwal->kelas->nama_kelas }}) /
                        {{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }} -
                        {{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}
                    </option>
                @endforeach
            </select>
            <div class="invalid-feedback">Jadwal wajib dipilih.</div>
        </div>
    </div>

    {{-- Peralatan --}}
    <div class="mb-3" data-id-peralatan="${id_peralatan}">
        <label for="peralatan" class="form-label">Peralatan</label>
        <div class="d-flex align-items-center border rounded overflow-hidden">
            <span class="bg-primary text-white px-3 py-2 d-flex align-items-center">
                <i class="fas fa-tools"></i>
            </span>
            <select name="peralatan[]" id="peralatan_jadwal" class="form-select border-0" multiple required
                style="width: 100%;">
                @foreach ($peralatans as $alat)
                    <option value="{{ $alat->id_peralatan }}">{{ $alat->nama_peralatan }}</option>
                @endforeach
            </select>
        </div>
        <div class="invalid-feedback">Peralatan wajib dipilih.</div>
    </div>

    {{-- Dynamic unit peralatan --}}
    <div id="unit-peralatan-container-jadwal"></div>

    <div class="d-flex justify-content-end">
        <button type="submit" class="btn btn-success">
            <i class="fas fa-paper-plane"></i> Ajukan
        </button>
    </div>
</form>
</div>
