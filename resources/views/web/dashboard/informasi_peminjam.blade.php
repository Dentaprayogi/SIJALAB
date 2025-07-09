<div class="modal fade" id="modalLab{{ $lab->id_lab }}" tabindex="-1" role="dialog"
    aria-labelledby="modalLabel{{ $lab->id_lab }}" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Peminjaman Lab. {{ $lab->nama_lab }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @if (($lab->peminjamanAktif ?? collect())->isEmpty() && ($lab->peminjamanManualAktif ?? collect())->isEmpty())
                    <p class="text-center">Tidak ada peminjaman aktif.</p>
                @else
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Nama Mahasiswa</th>
                                    <th>NIM</th>
                                    <th>Prodi</th>
                                    <th>Kelas</th>
                                    <th>Telepon</th>
                                    <th>Kegiatan/Matkul</th>
                                    <th>Jam</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($lab->peminjamanAktif ?? [] as $pj)
                                    <tr>
                                        <td>{{ $pj->peminjaman->user->name }}</td>
                                        <td>{{ $pj->peminjaman->user->mahasiswa->nim ?? '-' }}</td>
                                        <td>{{ $pj->peminjaman->user->mahasiswa->prodi->singkatan_prodi ?? '-' }}</td>
                                        <td>{{ $pj->peminjaman->user->mahasiswa->kelas->nama_kelas ?? '-' }}</td>
                                        <td>{{ $pj->peminjaman->user->mahasiswa->telepon ?? '-' }}</td>
                                        <td>{{ $pj->peminjaman->peminjamanJadwal->jadwalLab->matakuliah->nama_mk ?? '-' }}
                                        </td>
                                        <td>
                                            @php
                                                $sesiJam =
                                                    $pj->peminjaman->peminjamanJadwal->jadwalLab->sesiJam ?? collect();
                                                $jamMulai = optional($sesiJam->sortBy('jam_mulai')->first())->jam_mulai;
                                                $jamSelesai = optional($sesiJam->sortByDesc('jam_selesai')->first())
                                                    ->jam_selesai;
                                            @endphp

                                            {{ $jamMulai ? \Carbon\Carbon::parse($jamMulai)->format('H:i') : '-' }}
                                            -
                                            {{ $jamSelesai ? \Carbon\Carbon::parse($jamSelesai)->format('H:i') : '-' }}
                                        </td>
                                        @php
                                            $status = strtolower(trim($pj->peminjaman->status_peminjaman));
                                            $statusClass = match ($status) {
                                                'dipinjam' => 'badge-primary',
                                                'pengajuan' => 'badge-warning',
                                                default => 'badge-light',
                                            };
                                        @endphp
                                        <td><span
                                                class="badge badge-status {{ $statusClass }}">{{ ucfirst($status) }}</span>
                                        </td>
                                    </tr>
                                @endforeach
                                @foreach ($lab->peminjamanManualAktif ?? [] as $pm)
                                    <tr>
                                        <td>{{ $pm->peminjaman->user->name }}</td>
                                        <td>{{ $pm->peminjaman->user->mahasiswa->nim ?? '-' }}</td>
                                        <td>{{ $pm->peminjaman->user->mahasiswa->prodi->singkatan_prodi ?? '-' }}</td>
                                        <td>{{ $pm->peminjaman->user->mahasiswa->kelas->nama_kelas ?? '-' }}</td>
                                        <td>{{ $pm->peminjaman->user->mahasiswa->telepon ?? '-' }}</td>
                                        <td>{{ $pm->peminjaman->peminjamanManual->kegiatan ?? '-' }}</td>
                                        <td>
                                            {{ $pm->sesiMulai?->jam_mulai ? \Carbon\Carbon::parse($pm->sesiMulai->jam_mulai)->format('H:i') : '-' }}
                                            -
                                            {{ $pm->sesiSelesai?->jam_selesai ? \Carbon\Carbon::parse($pm->sesiSelesai->jam_selesai)->format('H:i') : '-' }}
                                        </td>
                                        @php
                                            $status = strtolower($pm->peminjaman->status_peminjaman); // Normalize
                                            $statusClass = match ($status) {
                                                'dipinjam' => 'badge-primary',
                                                'pengajuan' => 'badge-warning',
                                                default => 'badge-light',
                                            };
                                        @endphp

                                        <td>
                                            <span
                                                class="badge-status {{ $statusClass }}">{{ ucfirst($status) }}</span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
