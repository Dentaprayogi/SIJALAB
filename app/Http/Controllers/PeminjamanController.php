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
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PeminjamanController extends Controller
{
    public function index(Request $request)
    {
        $query = Peminjaman::with([
            'user',
            'peralatan',
            'peminjamanManual.lab',
            'peminjamanJadwal.jadwalLab.lab'
        ]);

        // Cek apakah user adalah mahasiswa
        if (Auth::user()->role === 'mahasiswa') {
            $query->where('id', auth::id());
        }

        // Ambil input filter
        $bulan = $request->input('bulan');
        $tahun = $request->input('tahun');

        // Terapkan filter jika ada
        if ($bulan) {
            $query->whereMonth('tgl_peminjaman', $bulan);
        }

        if ($tahun) {
            $query->whereYear('tgl_peminjaman', $tahun);
        }

        $peminjamans = $query->latest()->get();

        return view('web.peminjaman.index', compact('peminjamans'));
    }


    public function create()
    {
        $labs = Lab::all();
        $peralatans = Peralatan::all();
        $activeTab = session('active_tab', 'jadwal');

        $now = Carbon::now();

        // Ambil nama hari sekarang, sesuaikan format kapitalisasi jika perlu
        $namaHari = ucfirst(strtolower($now->locale('id')->isoFormat('dddd'))); // e.g. 'Senin'

        // Cari id_hari berdasarkan nama hari
        $hari = Hari::where('nama_hari', $namaHari)->first();

        // Ambil user login
        $user = Auth::user();

        $jadwals = JadwalLab::where('status_jadwalLab', 'aktif')
            ->where('id_hari', $hari->id_hari ?? null)
            ->where('id_prodi', $user->mahasiswa->id_prodi)
            ->where('id_kelas', $user->mahasiswa->id_kelas)
            ->get()
            ->filter(function ($jadwal) use ($now) {
                $jamMulai = Carbon::createFromFormat('H:i:s', $jadwal->jam_mulai);
                $jamSelesai = Carbon::createFromFormat('H:i:s', $jadwal->jam_selesai);

                return $now->greaterThanOrEqualTo($jamMulai->subMinutes(30)) &&
                    $now->lessThan($jamSelesai);
            });

        return view('web.peminjaman.create', compact('labs', 'jadwals', 'peralatans'));
    }

    public function getAvailableLabs(Request $request)
    {
        $request->validate([
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
        ]);

        $user = Auth::user();
        $now = Carbon::now();
        $namaHari = ucfirst(strtolower($now->locale('id')->isoFormat('dddd')));
        $hari = Hari::where('nama_hari', $namaHari)->first();

        $jamMulai = Carbon::createFromFormat('H:i', $request->jam_mulai)->format('H:i:s');
        $jamSelesai = Carbon::createFromFormat('H:i', $request->jam_selesai)->format('H:i:s');

        // Ambil semua lab yang aktif
        $labs = Lab::where('status_lab', 'aktif')->get();

        // Filter lab yang tidak bentrok dengan jadwal
        $availableLabs = $labs->filter(function ($lab) use ($hari, $jamMulai, $jamSelesai, $user) {
            // Cek apakah bentrok dengan jadwal yang sudah ada
            $bentrok = JadwalLab::where('id_hari', $hari->id_hari ?? null)
                ->where('status_jadwalLab', 'aktif')
                ->where('id_lab', $lab->id_lab)
                ->where(function ($q) use ($jamMulai, $jamSelesai) {
                    $q->where(function ($query) use ($jamMulai, $jamSelesai) {
                        $query->where('jam_mulai', '<', $jamSelesai)
                            ->where('jam_selesai', '>', $jamMulai);
                    });
                })
                ->exists();

            // Cek apakah lab sedang dipinjam atau diajukan tanpa jadwal (peminjaman_manual)
            $sedangDipinjamManual = PeminjamanManual::where('id_lab', $lab->id_lab)
                ->whereHas('peminjaman', function ($query) {
                    $query->whereIn('status_peminjaman', ['pengajuan', 'dipinjam']);
                })
                ->exists();

            return !$bentrok && !$sedangDipinjamManual;
        })->values();

        return response()->json($availableLabs);
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

        if ($hasUnscheduledBooking) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Lab sedang dalam peminjaman tanpa jadwal.')
                ->with('active_tab', 'jadwal');
        }

        if ($hasUnscheduledBooking) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Lab sedang dalam peminjaman tanpa jadwal.')
                ->with('active_tab', 'jadwal');
        }

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

            $peminjaman->peralatan()->sync($request->peralatan);
        });

        return redirect()->route('peminjaman.index')->with('success', 'Peminjaman sesuai jadwal berhasil diajukan.');
    }

    public function storeManual(Request $request)
    {
        $request->validate([
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|after:jam_mulai|date_format:H:i',
            'id_lab' => 'required|exists:lab,id_lab',
            'peralatan' => 'array',
        ]);

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

        // Cek apakah ada jadwal tumpang tindih
        $conflict = PeminjamanManual::where('id_lab', $request->id_lab)
            ->whereHas('peminjaman', function ($query) {
                $query->whereNotIn('status_peminjaman', ['ditolak', 'selesai', 'bermasalah']);
            })
            ->where(function ($query) use ($request) {
                $query->whereBetween('jam_mulai', [$request->jam_mulai, $request->jam_selesai])
                    ->orWhereBetween('jam_selesai', [$request->jam_mulai, $request->jam_selesai])
                    ->orWhere(function ($q) use ($request) {
                        $q->where('jam_mulai', '<=', $request->jam_mulai)
                            ->where('jam_selesai', '>=', $request->jam_selesai);
                    });
            })
            ->exists();

        // Set session untuk menentukan tab aktif
        session(['active_tab' => 'manual']);

        if ($conflict) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Lab sudah dipinjam pada rentang waktu tersebut.')
                ->with('active_tab', 'manual');
        }

        DB::transaction(function () use ($request) {
            $peminjaman = Peminjaman::create([
                'tgl_peminjaman' => now()->format('Y-m-d'),
                'status_peminjaman' => 'pengajuan',
                'id' => Auth::id(),
            ]);

            PeminjamanManual::create([
                'id_peminjaman' => $peminjaman->id_peminjaman,
                'jam_mulai' => $request->jam_mulai,
                'jam_selesai' => $request->jam_selesai,
                'id_lab' => $request->id_lab,
                'keterangan' => $request->keterangan,
            ]);

            $peminjaman->peralatan()->sync($request->peralatan);
        });

        return redirect()->route('peminjaman.index')->with('success', 'Peminjaman manual berhasil diajukan.');
    }

    public function show($id)
    {
        $peminjaman = Peminjaman::with([
            'user',
            'peralatan',
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
            'catatan' => 'required|string|max:255',
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
            'catatan' => $request->catatan,
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
            if (!in_array($peminjaman->status_peminjaman, ['ditolak', 'selesai'])) {
                return back()->with('error', 'Peminjaman hanya bisa dihapus jika statusnya ditolak, atau selesai.');
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
            ->whereIn('status_peminjaman', ['pengajuan', 'ditolak', 'selesai'])
            ->pluck('id_peminjaman');

        if ($deletable->isEmpty()) {
            return redirect()->back()->with('error', 'Peminjaman tidak dapat dihapus karena sedang dipinjam.');
        }

        Peminjaman::whereIn('id_peminjaman', $deletable)->delete();

        return redirect()->route('peminjaman.index')->with('success', 'Beberapa riwayat peminjaman berhasil dihapus.');
    }
}
