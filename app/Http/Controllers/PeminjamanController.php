<?php

namespace App\Http\Controllers;

use App\Models\Hari;
use App\Models\JadwalLab;
use App\Models\Lab;
use App\Models\Peminjaman;
use App\Models\PeminjamanBermasalah;
use App\Models\PeminjamanDitolak;
use App\Models\PeminjamanJadwal;
use App\Models\PeminjamanManual;
use App\Models\PeminjamanSelesai;
use App\Models\Peralatan;
use App\Models\SesiJam;
use App\Models\UnitPeralatan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PeminjamanController extends Controller
{
    public function index(Request $request)
    {
        // Mahasiswa hanya melihat miliknya
        $baseQuery = Peminjaman::with([
            'user',
            'peralatan',
            'peminjamanManual.lab',
            'peminjamanJadwal.jadwalLab.lab'
        ]);

        if (Auth::user()->role === 'mahasiswa') {
            $baseQuery->where('id', Auth::id());
        }

        $bulan = $request->input('bulan');
        $tahun = $request->input('tahun');

        if ($bulan) {
            $baseQuery->whereMonth('tgl_peminjaman', $bulan);
        }

        if ($tahun) {
            $baseQuery->whereYear('tgl_peminjaman', $tahun);
        }

        // Clone untuk pemisahan query
        $queryPengajuan = (clone $baseQuery)->where('status_peminjaman', 'pengajuan')->orderBy('id_peminjaman', 'asc');
        $queryLainnya   = (clone $baseQuery)->where('status_peminjaman', '!=', 'pengajuan')->orderBy('id_peminjaman', 'desc');

        // Gabungkan hasilnya
        $peminjamans = $queryPengajuan->get()->merge($queryLainnya->get());

        // Notifikasi peminjaman yang statusnya "pengajuan"
        $notifikasi = Peminjaman::with('user')
            ->where('status_peminjaman', 'pengajuan')
            ->latest()
            ->get();

        return view('web.peminjaman.index', compact('peminjamans', 'notifikasi'));
    }

    public function create()
    {
        $labs = Lab::orderBy('nama_lab', 'asc')->get();
        $peralatans = Peralatan::orderBy('nama_peralatan', 'asc')->get();
        $sesiJam = SesiJam::orderBy('jam_mulai')->get();
        $activeTab = session('active_tab', 'jadwal');

        $now = Carbon::now();
        $namaHari = ucfirst(strtolower($now->locale('id')->isoFormat('dddd')));
        $hari = Hari::where('nama_hari', $namaHari)->first();

        $user = Auth::user();
        $nowTime = Carbon::now()->format('H:i:s');
        $now = Carbon::createFromFormat('H:i:s', $nowTime);

        $jadwals = JadwalLab::with('sesiJam') // pastikan eager load
            ->where('status_jadwalLab', 'aktif')
            ->where('id_hari', $hari->id_hari ?? null)
            ->where('id_prodi', $user->mahasiswa->id_prodi)
            ->where('id_kelas', $user->mahasiswa->id_kelas)
            ->get()
            ->filter(function ($jadwal) use ($now) {
                // Ambil sesi pertama dan terakhir dari relasi
                $jamMulai = $jadwal->sesiJam->sortBy('jam_mulai')->first()?->jam_mulai;
                $jamSelesai = $jadwal->sesiJam->sortByDesc('jam_selesai')->first()?->jam_selesai;

                if (!$jamMulai || !$jamSelesai) return false;

                $carbonMulai = Carbon::createFromFormat('H:i:s', $jamMulai);
                $carbonSelesai = Carbon::createFromFormat('H:i:s', $jamSelesai);

                return $now->between(
                    $carbonMulai->copy()->subHour(),
                    $carbonSelesai->copy()->subSecond()
                );
            });

        return view('web.peminjaman.create', compact('labs', 'jadwals', 'peralatans', 'sesiJam'));
    }

    public function getAvailableLabs(Request $request)
    {
        $request->validate([
            'id_sesi_mulai'   => 'required|exists:sesi_jam,id_sesi_jam',
            'id_sesi_selesai' => 'required|exists:sesi_jam,id_sesi_jam|gt:id_sesi_mulai',
        ]);

        $hari = Hari::where('nama_hari', now()->locale('id')->isoFormat('dddd'))->first();
        $sesiMulai   = SesiJam::find($request->id_sesi_mulai);
        $sesiSelesai = SesiJam::find($request->id_sesi_selesai);

        // Ambil semua sesi dalam rentang
        $rentangSesi = SesiJam::whereBetween('id_sesi_jam', [
            $sesiMulai->id_sesi_jam,
            $sesiSelesai->id_sesi_jam,
        ])->pluck('id_sesi_jam');

        // Ambil semua lab aktif
        $labs = Lab::where('status_lab', 'aktif')->get();

        $availableLabs = $labs->filter(function ($lab) use ($hari, $sesiMulai, $sesiSelesai, $rentangSesi) {
            // Cek bentrok dengan jadwal_lab
            $jadwalBentrok = $lab->jadwalLab()
                ->where('status_jadwalLab', 'aktif')
                ->where('id_hari', $hari->id_hari)
                ->whereHas('sesiJam', function ($q) use ($rentangSesi) {
                    $q->whereIn('sesi_jam.id_sesi_jam', $rentangSesi);
                })
                ->exists();

            // Cek bentrok dengan peminjaman_manual
            $manualBentrok = PeminjamanManual::where('id_lab', $lab->id_lab)
                ->whereHas(
                    'peminjaman',
                    fn($q) =>
                    $q->whereIn('status_peminjaman', ['pengajuan', 'dipinjam'])
                )
                ->where(function ($q) use ($sesiMulai, $sesiSelesai) {
                    $q->where('id_sesi_mulai', '<=', $sesiSelesai->id_sesi_jam)
                        ->where('id_sesi_selesai', '>=', $sesiMulai->id_sesi_jam);
                })
                ->exists();

            return !$jadwalBentrok && !$manualBentrok;
        })->values();

        return response()->json($availableLabs);
    }

    public function getUnits($id_peralatan)
    {
        $units = UnitPeralatan::with(['peminjaman' => function ($query) {
            $query->select('peminjaman.id_peminjaman', 'status_peminjaman');
        }])
            ->where('id_peralatan', $id_peralatan)
            ->select('id_unit', 'kode_unit', 'status_unit', 'id_peralatan')
            ->orderBy('kode_unit', 'asc')
            ->get();

        return response()->json($units);
    }

    public function storeJadwal(Request $request)
    {
        $request->validate([
            'id_jadwalLab' => 'required|exists:jadwal_lab,id_jadwalLab',
            'peralatan' => 'array',
        ]);

        $jadwalLab = JadwalLab::findOrFail($request->id_jadwalLab);
        $idLab = $jadwalLab->id_lab;

        // Cek apakah user masih punya peminjaman aktif
        $hasActive = Peminjaman::where('id', Auth::id())
            ->whereNotIn('status_peminjaman', ['ditolak', 'selesai', 'bermasalah'])
            ->exists();

        if ($hasActive) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Anda sudah membuat pengajuan yang belum dikonfirmasi atau peminjaman yang anda lakukan belum selesai.')
                ->with('active_tab', 'manual');
        }

        // Cek apakah lab sedang dipinjam TANPA jadwal (dari tabel peminjaman_manual)
        $hasUnscheduledBooking = PeminjamanManual::whereHas('peminjaman', function ($query) {
            $query->whereIn('status_peminjaman', ['pengajuan', 'dipinjam']);
        })
            ->where('id_lab', $idLab)
            ->exists();

        // Cek apakah jadwal sudah dipinjam
        $isBooked = PeminjamanJadwal::where('id_jadwalLab', $request->id_jadwalLab)
            ->whereHas('peminjaman', function ($query) {
                $query->whereIn('status_peminjaman', ['pengajuan', 'dipinjam']);
            })
            ->exists();

        if ($isBooked) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Jadwal lab sudah dipinjam.')
                ->with('active_tab', 'jadwal');
        }

        DB::transaction(function () use ($request, $idLab) {
            $peminjaman = Peminjaman::create([
                'tgl_peminjaman' => now()->format('Y-m-d'),
                'status_peminjaman' => 'pengajuan',
                'id_lab' => $idLab,
                'id' => Auth::id(),
            ]);

            PeminjamanJadwal::create([
                'id_peminjaman' => $peminjaman->id_peminjaman,
                'id_jadwalLab' => $request->id_jadwalLab,
            ]);

            // Simpan peralatan ke pivot table peminjaman_peralatan
            $peminjaman->peralatan()->sync($request->peralatan);

            // Simpan unit-unit peralatan ke tabel pivot peminjaman_unit
            if ($request->has('unit_peralatan')) {
                foreach ($request->unit_peralatan as $unitList) {
                    foreach ($unitList as $id_unit) {
                        DB::table('peminjaman_unit')->insert([
                            'id_peminjaman' => $peminjaman->id_peminjaman,
                            'id_unit' => $id_unit,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                }
            }
        });

        return redirect()->route('peminjaman.index')->with('success', 'Peminjaman sesuai jadwal berhasil diajukan.');
    }

    public function storeManual(Request $request)
    {
        //VALIDASI INPUT
        $request->validate([
            'id_sesi_mulai'   => 'required|exists:sesi_jam,id_sesi_jam',
            'id_sesi_selesai' => 'required|exists:sesi_jam,id_sesi_jam',
            'id_lab'          => 'required|exists:lab,id_lab',
            'kegiatan'        => 'required|string',
            'peralatan'       => 'array',
        ]);

        //ambil object sesi
        $sesiMulai   = SesiJam::find($request->id_sesi_mulai);
        $sesiSelesai = SesiJam::find($request->id_sesi_selesai);

        /* pastikan urutan benar */
        if ($sesiMulai->jam_mulai >= $sesiSelesai->jam_mulai) {
            return back()->withInput()->withErrors([
                'id_sesi_selesai' => 'Sesi selesai harus setelah sesi mulai.',
            ])->with('active_tab', 'manual');
        }

        //CEK PINJAMAN AKTIF OLEH USER
        $hasActive = Peminjaman::where('id', Auth::id())
            ->whereNotIn('status_peminjaman', ['ditolak', 'selesai', 'bermasalah'])
            ->exists();

        if ($hasActive) {
            return back()->withInput()->withErrors([
                'kegiatan' => 'Anda masih memiliki pengajuan/peminjaman aktif.',
            ])->with('active_tab', 'manual');
        }

        //CEK BENTROK LAB PADA SESI YANG SAMA
        $conflict = PeminjamanManual::where('id_lab', $request->id_lab)
            ->whereHas(
                'peminjaman',
                fn($q) =>
                $q->whereNotIn('status_peminjaman', ['ditolak', 'selesai', 'bermasalah'])
            )
            ->where(function ($q) use ($sesiMulai, $sesiSelesai) {
                $q->whereBetween('id_sesi_mulai', [$sesiMulai->id_sesi_jam, $sesiSelesai->id_sesi_jam])
                    ->orWhereBetween('id_sesi_selesai', [$sesiMulai->id_sesi_jam, $sesiSelesai->id_sesi_jam])
                    ->orWhere(function ($sub) use ($sesiMulai, $sesiSelesai) {
                        $sub->where('id_sesi_mulai', '<=', $sesiMulai->id_sesi_jam)
                            ->where('id_sesi_selesai', '>=', $sesiSelesai->id_sesi_jam);
                    });
            })
            ->exists();

        if ($conflict) {
            return back()->withInput()->withErrors([
                'id_lab' => 'Lab sudah dipinjam pada rentang sesi tersebut.',
            ])->with('active_tab', 'manual');
        }

        //TRANSAKSI SIMPAN 
        DB::transaction(function () use ($request, $sesiMulai, $sesiSelesai) {

            $peminjaman = Peminjaman::create([
                'tgl_peminjaman'    => now()->format('Y-m-d'),
                'status_peminjaman' => 'pengajuan',
                'id'                => Auth::id(),
            ]);

            PeminjamanManual::create([
                'id_peminjaman'  => $peminjaman->id_peminjaman,
                'id_sesi_mulai'  => $sesiMulai->id_sesi_jam,
                'id_sesi_selesai' => $sesiSelesai->id_sesi_jam,
                'id_lab'         => $request->id_lab,
                'kegiatan'       => $request->kegiatan,
            ]);

            // Simpan peralatan
            $peminjaman->peralatan()->sync($request->peralatan ?? []);

            // Simpan unit‑peralatan (jika ada)
            if ($request->filled('unit_peralatan')) {
                foreach ($request->unit_peralatan as $unitList) {
                    foreach ($unitList as $id_unit) {
                        DB::table('peminjaman_unit')->insert([
                            'id_peminjaman' => $peminjaman->id_peminjaman,
                            'id_unit'       => $id_unit,
                            'created_at'    => now(),
                            'updated_at'    => now(),
                        ]);
                    }
                }
            }
        });

        return redirect()->route('peminjaman.index')
            ->with('success', 'Peminjaman manual berhasil diajukan.');
    }

    public function show($id)
    {
        $peminjaman = Peminjaman::with([
            'user',
            'peralatan',
            'unitPeralatan',
            'jadwalLab.hari',
            'jadwalLab.lab',
            'jadwalLab.mataKuliah',
            'jadwalLab.kelas',
        ])->findOrFail($id);

        return view('web.peminjaman.show', compact('peminjaman'));
    }

    public function setujui($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $peminjaman->status_peminjaman = 'dipinjam';
        $peminjaman->save();

        return redirect()->route('peminjaman.show', $id)->with('success', 'Peminjaman disetujui.');
    }

    public function bermasalah(Request $request, $id)
    {
        $request->validate([

            'alasan_bermasalah' => 'required|string|max:255',
        ]);

        $peminjaman = Peminjaman::findOrFail($id);


        // Update status peminjaman
        $peminjaman->status_peminjaman = 'bermasalah';
        $peminjaman->save();

        // Simpan ke tabel peminjaman_bermasalah
        PeminjamanBermasalah::create([
            'id_peminjaman' => $peminjaman->id_peminjaman,
            'jam_dikembalikan' => now()->format('H:i:s'),
            'tgl_pengembalian' => now()->format('Y-m-d'),
            'alasan_bermasalah' => $request->alasan_bermasalah,
        ]);

        return redirect()->route('peminjaman.show', $id)->with('success', 'Peminjaman ditandai sebagai bermasalah.');
    }


    public function selesai($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $peminjaman->status_peminjaman = 'selesai';
        $peminjaman->save();

        // Simpan ke tabel peminjaman_selesai
        PeminjamanSelesai::create([
            'id_peminjaman' => $peminjaman->id_peminjaman,
            'tgl_pengembalian' => now()->format('Y-m-d'),
            'jam_dikembalikan' => now()->format('H:i:s'),
        ]);

        return redirect()->route('peminjaman.show', $id)->with('success', 'Peminjaman diselesaikan.');
    }


    public function tolak(Request $request, $id)
    {
        $request->validate([
            'alasan_ditolak' => 'required|string|max:255'
        ]);

        $peminjaman = Peminjaman::findOrFail($id);
        $peminjaman->status_peminjaman = 'ditolak';
        $peminjaman->save();

        // Simpan alasan penolakan ke tabel peminjaman_ditolak
        PeminjamanDitolak::create([
            'id_peminjaman' => $peminjaman->id_peminjaman,
            'alasan_ditolak' => $request->alasan_ditolak,
        ]);

        return redirect()->route('peminjaman.show', $id)->with('success', 'Peminjaman ditolak.');
    }


    public function destroy(Peminjaman $peminjaman)
    {
        // Mengecek apakah user yang login adalah mahasiswa
        if (Auth::user()->role === 'mahasiswa') {
            // Mahasiswa hanya bisa menghapus peminjaman dengan status pengajuan
            if ($peminjaman->status_peminjaman !== 'pengajuan') {
                return back()->with('error', 'Peminjaman hanya bisa dihapus jika statusnya pengajuan.');
            }
        }

        // Mengecek apakah user yang login adalah teknisi
        if (Auth::user()->role === 'teknisi') {
            // Teknisi bisa menghapus peminjaman dengan status pengajuan, ditolak, atau selesai
            if (!in_array($peminjaman->status_peminjaman, ['ditolak', 'bermasalah', 'selesai'])) {
                return back()->with('error', 'Peminjaman hanya bisa dihapus jika statusnya ditolak, bermasalah, atau selesai.');
            }
        }

        // Jika semua kondisi terpenuhi, lakukan penghapusan peminjaman
        $peminjaman->delete();

        // Mengarahkan kembali dengan pesan sukses
        return back()->with('success', 'Peminjaman berhasil dihapus.');
    }

    public function bulkDelete(Request $request)
    {
        $ids = explode(',', $request->selected_ids);

        if (empty($ids) || !is_array($ids)) {
            return redirect()->back()->with('error', 'Tidak ada data yang dipilih untuk dihapus.');
        }

        // Filter hanya peminjaman yang statusnya diizinkan untuk dihapus
        $deletable = Peminjaman::whereIn('id_peminjaman', $ids)
            ->whereIn('status_peminjaman', ['ditolak', 'bermasalah', 'selesai'])
            ->pluck('id_peminjaman');

        if ($deletable->isEmpty()) {
            return redirect()->back()->with('error', 'Peminjaman tidak dapat dihapus karena sedang dipinjam.');
        }

        Peminjaman::whereIn('id_peminjaman', $deletable)->delete();

        return redirect()->route('peminjaman.index')->with('success', 'Beberapa riwayat peminjaman berhasil dihapus.');
    }
}
