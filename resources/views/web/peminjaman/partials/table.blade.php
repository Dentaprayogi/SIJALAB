<table class="table table-striped table-bordered" id="{{ $tableId }}" width="100%" cellspacing="0">
    <thead class="thead-primary">
        <tr>
            @auth
                @if (Auth::user()->role === 'teknisi')
                    <th><input type="checkbox" id="select-all"></th>
                @endif
            @endauth
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
                <td colspan="12" class="text-center">Belum Ada Data</td>
            </tr>
        @else
            @foreach ($data as $peminjaman)
                <tr>
                    @auth
                        @if (Auth::user()->role === 'teknisi')
                            <td><input type="checkbox" class="select-item" value="{{ $peminjaman->id_peminjaman }}"></td>
                        @endif
                    @endauth
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $peminjaman->tgl_peminjaman }}</td>
                    <td>
                        @if ($peminjaman->peminjamanJadwal)
                            {{ $peminjaman->peminjamanJadwal->jadwalLab->lab->nama_lab ?? 'Lab kosong' }}
                        @else
                            {{ $peminjaman->peminjamanManual->lab->nama_lab ?? 'Lab manual kosong' }}
                        @endif
                    </td>
                    <td>
                        {{-- Peminjaman berdasarkan JADWAL --}}
                        @if ($pj = optional($peminjaman->peminjamanJadwal)->jadwalLab)
                            @php
                                // ambil sesi terawal & terlambat
                                $firstSesi = $pj->sesiJam->sortBy('jam_mulai')->first();
                                $lastSesi = $pj->sesiJam->sortByDesc('jam_selesai')->first();
                            @endphp

                            {{ $firstSesi ? \Carbon\Carbon::parse($firstSesi->jam_mulai)->format('H:i') : '-' }}
                            -
                            {{ $lastSesi ? \Carbon\Carbon::parse($lastSesi->jam_selesai)->format('H:i') : '-' }}

                            {{-- Peminjaman MANUAL --}}
                        @elseif ($pm = $peminjaman->peminjamanManual)
                            @if ($pm->sesiMulai && $pm->sesiSelesai)
                                {{ \Carbon\Carbon::parse($pm->sesiMulai->jam_mulai)->format('H:i') }}
                                -
                                {{ \Carbon\Carbon::parse($pm->sesiSelesai->jam_selesai)->format('H:i') }}
                            @else
                                -
                            @endif

                            {{-- Tidak ada data --}}
                        @else
                            -
                        @endif
                    </td>
                    <td>{{ $peminjaman->user->name }}</td>
                    <td>{{ $peminjaman->user->mahasiswa->nim }}</td>
                    <td>{{ $peminjaman->user->mahasiswa->prodi->singkatan_prodi }}
                        ({{ $peminjaman->user->mahasiswa->kelas->nama_kelas }})
                    </td>
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
                        @auth
                            @if (Auth::user()->role === 'teknisi')
                                <form action="{{ route('peminjaman.destroy', $peminjaman) }}" method="POST"
                                    style="display:inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm btn-delete"
                                        @if (in_array($peminjaman->status_peminjaman, ['pengajuan', 'dipinjam'])) disabled 
                style="cursor: not-allowed;" @endif>
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            @elseif (Auth::user()->role === 'mahasiswa' && $peminjaman->status_peminjaman === 'pengajuan')
                                <form action="{{ route('peminjaman.destroy', $peminjaman) }}" method="POST"
                                    style="display:inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm btn-delete">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            @else
                                <form action="{{ route('peminjaman.destroy', $peminjaman) }}" method="POST"
                                    style="display:inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm btn-delete" disabled style="cursor: not-allowed;">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            @endif
                        @endauth
                    </td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>
