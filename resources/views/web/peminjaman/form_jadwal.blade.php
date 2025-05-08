<div class="tab-pane fade {{ $active ? 'show active' : '' }}" id="jadwal" role="tabpanel">
    @if ($errors->has('id_jadwal') || $errors->has('tgl_peminjaman') || old('_form_type') === 'jadwal')
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('peminjaman.storeJadwal') }}" method="POST">
        @csrf
        <input type="hidden" name="_form_type" value="jadwal">

        <div class="mb-3">
            <label>Jadwal Lab</label>
            <select name="id_jadwalLab" class="form-control" required>
                <option value="">-- Pilih Jadwal --</option>
                @foreach ($jadwals as $jadwal)
                    <option value="{{ $jadwal->id_jadwalLab }}" {{ old('id_jadwalLab') == $jadwal->id_jadwalLab ? 'selected' : '' }}>
                        {{ $jadwal->hari->nama_hari }} / Lab.
                        {{ $jadwal->lab->nama_lab }} / 
                        {{ $jadwal->prodi->kode_prodi }} ({{ $jadwal->kelas->nama_kelas }}) / 
                        {{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }} - 
                        {{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Peralatan</label><br>
            @foreach ($peralatans as $alat)
                <label>
                    <input type="checkbox" name="peralatan[]" value="{{ $alat->id_peralatan }}"
                        {{ is_array(old('peralatan')) && in_array($alat->id_peralatan, old('peralatan')) ? 'checked' : '' }}>
                    {{ $alat->nama_peralatan }}
                </label><br>
            @endforeach
        </div>

        <button class="btn btn-success">Ajukan</button>
    </form>
</div>
