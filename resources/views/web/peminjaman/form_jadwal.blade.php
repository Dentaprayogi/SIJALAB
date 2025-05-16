{{-- <div class="tab-pane fade {{ $active ? 'show active' : '' }}" id="jadwal" role="tabpanel">
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

        <div class="mb-3">
            <label class="form-label">Peralatan</label><br>
            @foreach ($peralatans as $alat)
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="peralatan[]"
                        id="alat{{ $alat->id_peralatan }}" value="{{ $alat->id_peralatan }}"
                        {{ is_array(old('peralatan')) && in_array($alat->id_peralatan, old('peralatan')) ? 'checked' : '' }}>
                    <label class="form-check-label" for="alat{{ $alat->id_peralatan }}">
                        {{ $alat->nama_peralatan }}
                    </label>
                </div>
            @endforeach
        </div>

        <div class="d-flex justify-content-end">
            <button type="submit" class="btn btn-success">
                <i class="fas fa-paper-plane"></i> Ajukan
            </button>
        </div>
    </form>
</div> --}}
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

    <div class="mb-3">
        <label class="form-label">Peralatan</label><br>
        @foreach ($peralatans as $alat)
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="peralatan[]" id="alat{{ $alat->id_peralatan }}"
                    value="{{ $alat->id_peralatan }}"
                    {{ is_array(old('peralatan')) && in_array($alat->id_peralatan, old('peralatan')) ? 'checked' : '' }}>
                <label class="form-check-label" for="alat{{ $alat->id_peralatan }}">
                    {{ $alat->nama_peralatan }}
                </label>
            </div>
        @endforeach
    </div>

    <div class="d-flex justify-content-end">
        <button type="submit" class="btn btn-success">
            <i class="fas fa-paper-plane"></i> Ajukan
        </button>
    </div>
</form>
</div>
