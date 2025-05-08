<table class="table table-striped table-bordered" id="{{ $tableId }}" width="100%" cellspacing="0">
    <thead class="thead-primary">
        <tr>
            <th><input type="checkbox" id="select-all"></th>
            <th>No.</th>
            <th>Tanggal</th>
            <th>Lab</th>
            <th>Jam</th>
            <th>Nama Mahasiswa</th>
            <th>NIM</th>
            <th>Prodi</th>
            <th>Status</th>
            {{-- <th>Peralatan</th> --}}
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @if ($data->isEmpty())
            <tr>
                <td colspan="5" class="text-center">Belum Ada Data</td>
            </tr>
        @else
            @foreach ($data as $peminjaman)
                <tr>
                    <td><input type="checkbox" class="select-item" value="{{ $peminjaman->id_peminjaman }}"></td>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $peminjaman->tgl_peminjaman }}</td>
                    <td>
                        @if($peminjaman->peminjamanJadwal)
                            {{ $peminjaman->peminjamanJadwal->jadwalLab->lab->nama_lab ?? 'Lab kosong' }}
                        @else
                            {{ $peminjaman->peminjamanManual->lab->nama_lab ?? 'Lab manual kosong' }}
                        @endif
                    </td>
                    <td>
                        @if($peminjaman->peminjamanJadwal && $peminjaman->peminjamanJadwal->jadwalLab)
                            {{ \Carbon\Carbon::parse($peminjaman->peminjamanJadwal->jadwalLab->jam_mulai)->format('H:i') ?? '-' }} - 
                            {{ \Carbon\Carbon::parse($peminjaman->peminjamanJadwal->jadwalLab->jam_selesai)->format('H:i') ?? '-' }}
                        @else
                            {{ \Carbon\Carbon::parse($peminjaman->peminjamanManual->jam_mulai)->format('H:i') ?? '-' }} - 
                            {{ \Carbon\Carbon::parse($peminjaman->peminjamanManual->jam_selesai)->format('H:i') ?? '-' }}
                        @endif
                    </td>                    
                    <td>{{ $peminjaman->user->name }}</td>
                    <td>{{ $peminjaman->user->mahasiswa->nim }}</td>
                    <td>{{ $peminjaman->user->mahasiswa->prodi->kode_prodi }} ({{ $peminjaman->user->mahasiswa->kelas->nama_kelas }})</td>                             
                    <td>
                        @php
                            $badgeClass = match ($peminjaman->status_peminjaman) {
                                'pengajuan' => 'badge-warning',
                                'ditolak' => 'badge-danger',
                                'dipinjam' => 'badge-primary',
                                'selesai' => 'badge-success',
                                default => 'badge-secondary'
                            };
                        @endphp
                        <span class="badge-status {{ $badgeClass }}">
                            {{ ucfirst($peminjaman->status_peminjaman) }}
                        </span>
                    </td> 
                    {{-- <td>
                        <ul class="mb-0">
                            @foreach ($peminjaman->peralatan as $alat)
                                <li>{{ $alat->nama_peralatan }}</li>
                            @endforeach
                        </ul>
                    </td> --}}
                    <td>
                        <a href="{{ route('peminjaman.show', $peminjaman) }}" class="btn btn-info btn-sm">
                            <i class="fas fa-eye"></i>
                        </a>
                        <form action="{{ route('peminjaman.destroy', $peminjaman) }}" method="POST" style="display:inline-block">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm btn-delete">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>

