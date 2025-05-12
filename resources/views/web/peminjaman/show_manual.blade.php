<h5>Detail Peminjaman di Luar Jadwal</h5>

<table class="table table-striped table-bordered">
    <tr>
        <th>Tanggal Peminjaman</th>
        <td>{{ \Carbon\Carbon::parse($peminjaman->tgl_peminjaman)->translatedFormat('l') }},
            {{ \Carbon\Carbon::parse($peminjaman->tgl_peminjaman)->format('d-m-Y') }}
        </td>
    </tr>
    <tr>
        <th>Status Peminjaman</th>
        <td>
            @php
                $badgeClass = match ($peminjaman->status_peminjaman) {
                    'pengajuan' => 'badge-warning',
                    'ditolak' => 'badge-danger',
                    'dipinjam' => 'badge-primary',
                    'selesai' => 'badge-success',
                    default => 'badge-secondary',
                };
            @endphp
            <span class="badge-status {{ $badgeClass }}">
                {{ ucfirst($peminjaman->status_peminjaman) }}
            </span>
        </td>
    </tr>

    @if ($peminjaman->status_peminjaman === 'bermasalah')
        <tr>
            <th>Tanggal Pengembalian</th>
            <td>{{ \Carbon\Carbon::parse($peminjaman->peminjamanBermasalah->tgl_pengembalian)->format('d-m-Y') }}
                ({{ \Carbon\Carbon::parse($peminjaman->peminjamanBermasalah->jam_dikembalikan)->format('H:i') }})</td>
        </tr>
        <tr>
            <th>Catatan</th>
            <td>{{ $peminjaman->peminjamanBermasalah->catatan ?? '-' }}</td>
        </tr>
    @endif

    @if ($peminjaman->status_peminjaman === 'selesai')
        <tr>
            <th>Tanggal Pengembalian</th>
            <td>{{ \Carbon\Carbon::parse($peminjaman->peminjamanSelesai->tgl_pengembalian)->format('d-m-Y') }}
                ({{ \Carbon\Carbon::parse($peminjaman->peminjamanSelesai->jam_dikembalikan)->format('H:i') }})</td>
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
        <td>{{ $peminjaman->peminjamanManual->lab->nama_lab ?? '-' }}</td>
    </tr>
    <tr>
        <th>Prodi</th>
        <td>{{ $peminjaman->user->mahasiswa->prodi->kode_prodi ?? '-' }}
            ({{ $peminjaman->user->mahasiswa->kelas->nama_kelas ?? '-' }})</td>
    </tr>
    <tr>
        <th>Jam</th>
        <td>
            @if (
                $peminjaman->peminjamanManual &&
                    $peminjaman->peminjamanManual->jam_mulai &&
                    $peminjaman->peminjamanManual->jam_selesai)
                {{ \Carbon\Carbon::parse($peminjaman->peminjamanManual->jam_mulai)->format('H:i') ?? '-' }}
                -
                {{ \Carbon\Carbon::parse($peminjaman->peminjamanManual->jam_selesai)->format('H:i') ?? '-' }}
            @else
                -
            @endif
    </tr>
    <tr>
        <th>Keterangan</th>
        <td>{{ $peminjaman->peminjamanManual->keterangan ?? '-' }}</td>
    </tr>
</table>
