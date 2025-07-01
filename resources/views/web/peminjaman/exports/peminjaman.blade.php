<table>
    <thead>
        <tr>
            <th>No.</th>
            <th>Tanggal Peminjaman</th>
            <th>Lab</th>
            <th>Jam Peminjaman</th>
            <th>Nama Mahasiswa</th>
            <th>NIM</th>
            <th>Prodi</th>
            <th>Mata Kuliah</th>
            <th>Dosen</th>
            <th>Kegiatan</th>
            <th>Peralatan</th>
            <th>Tanggal Pengembalian</th>
            <th>Jam Dikembalikan</th>
            <th>Alasan Ditolak</th>
            <th>Alasan Bermasalah</th>
            <th>Status</th>

        </tr>
    </thead>
    <tbody>
        @foreach ($peminjamans as $p)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $p->tgl_peminjaman ?? '-' }}</td>
                <td>
                    @if ($p->peminjamanJadwal)
                        {{ $p->peminjamanJadwal->jadwalLab->lab->nama_lab ?? '-' }}
                    @else
                        {{ $p->peminjamanManual->lab->nama_lab ?? '-' }}
                    @endif
                </td>
                <td>
                    @if ($p->peminjamanJadwal && $p->peminjamanJadwal->jadwalLab)
                        @php
                            $sesiJam = $p->peminjamanJadwal->jadwalLab->sesiJam ?? collect();
                            $jamMulai = optional($sesiJam->sortBy('jam_mulai')->first())->jam_mulai;
                            $jamSelesai = optional($sesiJam->sortByDesc('jam_selesai')->first())->jam_selesai;
                        @endphp
                        {{ $jamMulai ? \Carbon\Carbon::parse($jamMulai)->format('H:i') : '-' }} -
                        {{ $jamSelesai ? \Carbon\Carbon::parse($jamSelesai)->format('H:i') : '-' }}
                    @elseif ($p->peminjamanManual)
                        @php
                            $jamMulaiManual = optional($p->peminjamanManual->sesiMulai)->jam_mulai;
                            $jamSelesaiManual = optional($p->peminjamanManual->sesiSelesai)->jam_selesai;
                        @endphp
                        {{ $jamMulaiManual ? \Carbon\Carbon::parse($jamMulaiManual)->format('H:i') : '-' }} -
                        {{ $jamSelesaiManual ? \Carbon\Carbon::parse($jamSelesaiManual)->format('H:i') : '-' }}
                    @else
                        -
                    @endif
                </td>
                <td>{{ $p->user->name ?? '-' }}</td>
                <td>{{ $p->user->mahasiswa->nim ?? '-' }}</td>
                <td>{{ $p->user->mahasiswa->prodi->singkatan_prodi ?? '-' }}
                    ({{ $p->user->mahasiswa->kelas->nama_kelas ?? '-' }})</td>
                <td>{{ $p->peminjamanJadwal->jadwalLab->mataKuliah->nama_mk ?? '-' }}</td>
                <td>{{ $p->peminjamanJadwal->jadwalLab->dosen->nama_dosen ?? '-' }}</td>
                <td>{{ $p->peminjamanManual->kegiatan ?? '-' }}</td>
                <td>
                    <ul>
                        @foreach ($p->peralatan as $alat)
                            @php
                                $unit = null;
                                if ($p->unitPeralatan instanceof \Illuminate\Support\Collection) {
                                    // Cari unit yang memiliki id_peralatan sama
                                    $unit = $p->unitPeralatan->first(function ($u) use ($alat) {
                                        return $u->id_peralatan == $alat->id_peralatan;
                                    });
                                }
                            @endphp

                            <li>
                                {{ $alat->nama_peralatan }}
                                @if ($unit)
                                    (Kode Unit: {{ $unit->kode_unit }})
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </td>
                <td>
                    @if ($p->peminjamanSelesai && $p->peminjamanSelesai->tgl_pengembalian)
                        {{ \Carbon\Carbon::parse($p->peminjamanSelesai->tgl_pengembalian)->format('d-m-Y') }}
                    @else
                        -
                    @endif
                </td>
                <td>
                    @if ($p->peminjamanSelesai && $p->peminjamanSelesai->jam_dikembalikan)
                        {{ \Carbon\Carbon::parse($p->peminjamanSelesai->jam_dikembalikan)->format('H:i') }}
                    @else
                        -
                    @endif
                </td>
                <td>
                    @if ($p->peminjamanDitolak && $p->peminjamanDitolak->alasan_ditolak)
                        {{ $p->peminjamanDitolak->alasan_ditolak }}
                    @else
                        -
                    @endif
                </td>
                <td>
                    @if ($p->peminjamanBermasalah && $p->peminjamanBermasalah->alasan_bermasalah)
                        {{ $p->peminjamanBermasalah->alasan_bermasalah }}
                    @else
                        -
                    @endif
                </td>
                <td>{{ ucfirst($p->status_peminjaman) ?? '-' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
