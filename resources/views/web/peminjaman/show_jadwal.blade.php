<h5>Detail Peminjaman Sesuai Jadwal</h5>
<table class="table table-striped table-bordered">
    <tr>
        <th>Tanggal Peminjaman</th>
        <td>{{ $peminjaman->jadwalLab->hari->nama_hari ?? '-' }},
            {{ \Carbon\Carbon::parse($peminjaman->tgl_peminjaman)->format('d-m-Y') }}</td>
    </tr>

    <tr>
        <th>Status Peminjaman</th>
        <td>
            @php
                $badgeClass = match ($peminjaman->status_peminjaman) {
                    'pengajuan' => 'badge-warning',
                    'ditolak' => 'badge-secondary',
                    'dipinjam' => 'badge-primary',
                    'selesai' => 'badge-success',
                    'bermasalah' => 'badge-danger',
                };
            @endphp
            <span class="badge-status {{ $badgeClass }}">
                {{ ucfirst($peminjaman->status_peminjaman) }}
            </span>
        </td>
    </tr>

    @if ($peminjaman->status_peminjaman === 'selesai')
        <tr>
            <th>Tanggal Pengembalian</th>
            <td>{{ \Carbon\Carbon::parse($peminjaman->peminjamanSelesai->tgl_pengembalian)->format('d-m-Y') }}
                ({{ \Carbon\Carbon::parse($peminjaman->peminjamanSelesai->jam_dikembalikan)->format('H:i') }})</td>
        </tr>
    @endif

    @if ($peminjaman->status_peminjaman === 'bermasalah')
        <tr>
            <th>Tanggal Pengembalian</th>
            <td>{{ \Carbon\Carbon::parse($peminjaman->peminjamanBermasalah->tgl_pengembalian)->format('d-m-Y') }}
                ({{ \Carbon\Carbon::parse($peminjaman->peminjamanBermasalah->jam_dikembalikan)->format('H:i') }})</td>
        </tr>
        <tr>
            <th>Alasan Bermasalah</th>
            <td style="color: #e74a3b !important;">{{ $peminjaman->peminjamanBermasalah->alasan_bermasalah ?? '-' }}</td>
        </tr>
    @endif

    @if ($peminjaman->status_peminjaman === 'ditolak')
        <tr>
            <th>Alasan Ditolak</th>
            <td>{{ $peminjaman->peminjamanDitolak->alasan_ditolak ?? '-' }}</td>
        </tr>
    @endif
    <tr>
        <th>Lab</th>
        <td>{{ $peminjaman->jadwalLab->lab->nama_lab ?? '-' }}</td>
    </tr>
    <tr>
        <th>Mata Kuliah</th>
        <td>{{ $peminjaman->jadwalLab->mataKuliah->nama_mk ?? '-' }}</td>
    </tr>
    <tr>
        <th>Dosen</th>
        <td>{{ $peminjaman->peminjamanJadwal->jadwalLab->dosen->nama_dosen ?? '-' }}</td>
    </tr>
    <tr>
        <th>Kelas</th>
        <td>{{ $peminjaman->jadwalLab->kelas->nama_kelas ?? '-' }}</td>
    </tr>
    <tr>
        <th>Jam</th>
        <td>
            @if ($pj = optional($peminjaman->peminjamanJadwal)->jadwalLab)
                @php
                    $firstSesi = $pj->sesiJam->sortBy('jam_mulai')->first();
                    $lastSesi = $pj->sesiJam->sortByDesc('jam_selesai')->first();
                @endphp

                {{ $firstSesi ? \Carbon\Carbon::parse($firstSesi->jam_mulai)->format('H:i') : '-' }}
                -
                {{ $lastSesi ? \Carbon\Carbon::parse($lastSesi->jam_selesai)->format('H:i') : '-' }}
            @else
                -
            @endif
        </td>
    </tr>
</table>
