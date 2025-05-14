<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\Hari;
use App\Models\JadwalLab;
use App\Models\Kelas;
use App\Models\Lab;
use App\Models\Matakuliah;
use App\Models\Prodi;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class JadwalLabController extends Controller
{
    public function index()
    {
        $jadwalLabs = JadwalLab::whereHas('tahunAjaran', function ($query) {
            $query->where('status_tahunAjaran', 'aktif');
        })
            ->orderBy('id_hari', 'asc')
            ->orderBy('id_lab', 'asc')
            ->orderBy('jam_mulai', 'asc')
            ->get();

        return view('web.jadwal_lab.index', compact('jadwalLabs'));
    }

    public function create()
    {
        return view('web.jadwal_lab.create', [
            'hariList' => Hari::all(),
            'labList' => Lab::where('status_lab', 'aktif')->orderBy('nama_lab', 'asc')->get(),
            'mkList' => Matakuliah::orderBy('nama_mk', 'asc')->get(),
            'dosenList' => Dosen::orderBy('nama_dosen', 'asc')->get(),
            'prodiList' => Prodi::orderBy('kode_prodi', 'asc')->get(),
            'kelasList' => Kelas::orderBy('nama_kelas', 'asc')->get(),
            'tahunAjaranList' => TahunAjaran::where('status_tahunAjaran', 'aktif')->orderBy('tahun_ajaran', 'desc')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_hari'          => 'required',
            'id_lab'           => 'required',
            'jam_mulai'        => 'required|date_format:H:i',
            'jam_selesai'      => 'required|date_format:H:i|after:jam_mulai',
            'id_mk'            => 'required',
            'id_dosen'         => 'required',
            'id_prodi'         => 'required',
            'id_kelas'         => 'required',
            'id_tahunAjaran'   => 'required',
        ]);

        $year = $request->id_tahunAjaran;
        $day  = $request->id_hari;
        $lab  = $request->id_lab;
        $start = $request->jam_mulai;
        $end   = $request->jam_selesai;

        // Fungsi bantu untuk cek overlap
        $overlap = function ($query) use ($start, $end) {
            $query->whereBetween('jam_mulai', [$start, $end])
                ->orWhereBetween('jam_selesai', [$start, $end])
                ->orWhere(function ($q) use ($start, $end) {
                    $q->where('jam_mulai', '<=', $start)
                        ->where('jam_selesai', '>=', $end);
                });
        };

        // 1) Cek bentrok Lab
        if (JadwalLab::where('id_hari', $day)
            ->where('id_lab', $lab)
            ->where('id_tahunAjaran', $year)
            ->where($overlap)
            ->exists()
        ) {
            throw ValidationException::withMessages([
                'jam_mulai' => ['Jadwal untuk lab ini sudah ada di rentang waktu tersebut (tahun ajaran sama).'],
            ]);
        }

        // 2) Cek bentrok Dosen
        if (JadwalLab::where('id_hari', $day)
            ->where('id_dosen', $request->id_dosen)
            ->where('id_tahunAjaran', $year)
            ->where($overlap)
            ->exists()
        ) {
            throw ValidationException::withMessages([
                'id_dosen' => ['Dosen sudah memiliki jadwal mengajar di rentang waktu tersebut (tahun ajaran sama).'],
            ]);
        }

        //  3) Cek bentrok Kelas
        if (JadwalLab::where('id_hari', $day)
            ->where('id_kelas', $request->id_kelas)
            ->where('id_tahunAjaran', $year)
            ->where($overlap)
            ->exists()
        ) {
            throw ValidationException::withMessages([
                'id_kelas' => ['Kelas sudah terjadwal di rentang waktu tersebut (tahun ajaran sama).'],
            ]);
        }

        // Jika semua lolos, simpan
        JadwalLab::create([
            'id_hari'         => $day,
            'id_lab'          => $lab,
            'jam_mulai'       => $start,
            'jam_selesai'     => $end,
            'id_mk'           => $request->id_mk,
            'id_dosen'        => $request->id_dosen,
            'id_prodi'        => $request->id_prodi,
            'id_kelas'        => $request->id_kelas,
            'id_tahunAjaran'  => $year,
            'status_jadwalLab' => 'aktif',
        ]);

        return redirect()->route('jadwal_lab.index')
            ->with('success', 'Jadwal Lab berhasil ditambahkan.');
    }

    public function show($id)
    {
        $jadwalLab = JadwalLab::findOrFail($id);
        return view('web.jadwal_lab.show', compact('jadwalLab'));
    }

    public function edit($id)
    {
        $jadwalLab = JadwalLab::findOrFail($id);
        $prodiId = $jadwalLab->id_prodi;

        return view('web.jadwal_lab.edit', [
            'hariList' => Hari::all(),
            'labList' => Lab::where('status_lab', 'aktif')->orderBy('nama_lab', 'asc')->get(),
            'mkList' => Matakuliah::where('id_prodi', $prodiId)->orderBy('nama_mk', 'asc')->get(),
            'dosenList' => Dosen::where('id_prodi', $prodiId)->orderBy('nama_dosen', 'asc')->get(),
            'prodiList' => Prodi::orderBy('kode_prodi', 'asc')->get(),
            'kelasList' => Kelas::where('id_prodi', $prodiId)->orderBy('nama_kelas', 'asc')->get(),
            'tahunAjaranList' => TahunAjaran::where('status_tahunAjaran', 'aktif')->orderBy('tahun_ajaran', 'desc')->get(),
            'jadwalLab' => $jadwalLab,
        ]);
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'id_hari'          => 'required',
            'id_lab'           => 'required',
            'jam_mulai'        => 'required|date_format:H:i',
            'jam_selesai'      => 'required|date_format:H:i|after:jam_mulai',
            'id_mk'            => 'required',
            'id_dosen'         => 'required',
            'id_prodi'         => 'required',
            'id_kelas'         => 'required',
            'id_tahunAjaran'   => 'required',
            'status_jadwalLab' => 'required',
        ]);

        $jadwalLab = JadwalLab::findOrFail($id);

        // Ambil input
        $year  = $request->id_tahunAjaran;
        $day   = $request->id_hari;
        $lab   = $request->id_lab;
        $start = $request->jam_mulai;
        $end   = $request->jam_selesai;

        // Closure untuk cek overlap
        $overlap = function ($query) use ($start, $end) {
            $query->whereBetween('jam_mulai', [$start, $end])
                ->orWhereBetween('jam_selesai', [$start, $end])
                ->orWhere(function ($q) use ($start, $end) {
                    $q->where('jam_mulai', '<=', $start)
                        ->where('jam_selesai', '>=', $end);
                });
        };

        // 1) Lab bentrok?
        if (JadwalLab::where('id_hari', $day)
            ->where('id_lab', $lab)
            ->where('id_tahunAjaran', $year)
            ->where($overlap)
            ->where('id_jadwalLab', '!=', $jadwalLab->id_jadwalLab)
            ->exists()
        ) {
            throw ValidationException::withMessages([
                'jam_mulai' => ['Jadwal untuk lab ini sudah ada di rentang waktu tersebut.'],
            ]);
        }

        // 2) Dosen bentrok?
        if (JadwalLab::where('id_hari', $day)
            ->where('id_dosen', $request->id_dosen)
            ->where('id_tahunAjaran', $year)
            ->where($overlap)
            ->where('id_jadwalLab', '!=', $jadwalLab->id_jadwalLab)
            ->exists()
        ) {
            throw ValidationException::withMessages([
                'id_dosen' => ['Dosen sudah memiliki jadwal di rentang waktu tersebut.'],
            ]);
        }

        // 3) Kelas bentrok?
        if (JadwalLab::where('id_hari', $day)
            ->where('id_kelas', $request->id_kelas)
            ->where('id_tahunAjaran', $year)
            ->where($overlap)
            ->where('id_jadwalLab', '!=', $jadwalLab->id_jadwalLab)
            ->exists()
        ) {
            throw ValidationException::withMessages([
                'id_kelas' => ['Kelas sudah terjadwal di rentang waktu tersebut.'],
            ]);
        }

        // Semua aman, update data
        $jadwalLab->update([
            'id_hari'         => $day,
            'id_lab'          => $lab,
            'jam_mulai'       => $start,
            'jam_selesai'     => $end,
            'id_mk'           => $request->id_mk,
            'id_dosen'        => $request->id_dosen,
            'id_prodi'        => $request->id_prodi,
            'id_kelas'        => $request->id_kelas,
            'id_tahunAjaran'  => $year,
            'status_jadwalLab' => $request->status_jadwalLab,
        ]);

        return redirect()->route('jadwal_lab.index')
            ->with('success', 'Jadwal Lab berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $jadwalLab = JadwalLab::findOrFail($id);

        // Cek apakah jadwal lab ini masih digunakan oleh peminjaman aktif
        $digunakan = DB::table('peminjaman_jadwal')
            ->join('peminjaman', 'peminjaman_jadwal.id_peminjaman', '=', 'peminjaman.id_peminjaman')
            ->where('peminjaman_jadwal.id_jadwalLab', $id)
            ->whereIn('peminjaman.status_peminjaman', ['pengajuan', 'dipinjam', 'bermasalah'])
            ->exists();

        if ($digunakan) {
            return redirect()->back()
                ->with('error', 'Jadwal Lab tidak dapat dihapus karena masih terhubung oleh peminjaman aktif.');
        }

        $jadwalLab->delete();

        return redirect()->route('jadwal_lab.index')
            ->with('success', 'Jadwal Lab berhasil dihapus.');
    }


    public function getDependentData($prodiId)
    {
        $kelas = Kelas::where('id_prodi', $prodiId)->get();
        $mk = MataKuliah::where('id_prodi', $prodiId)->get();
        $dosen = Dosen::where('id_prodi', $prodiId)->get();

        return response()->json([
            'kelas' => $kelas,
            'mk' => $mk,
            'dosen' => $dosen
        ]);
    }

    public function toggleStatus(Request $request, $id_jadwalLab)
    {
        $jadwal = JadwalLab::where('id_jadwalLab', $id_jadwalLab)->firstOrFail();

        $status = $request->status_jadwalLab;
        if (!in_array($status, ['aktif', 'nonaktif'])) {
            return response()->json(['message' => 'Status tidak valid.'], 422);
        }

        $jadwal->status_jadwalLab = $status;
        $jadwal->save();

        return response()->json(['message' => 'Status jadwal lab berhasil diubah']);
    }

    public function getData($id_prodi)
    {
        // Ambil data dari database berdasarkan id_prodi
        $kelas = Kelas::where('id_prodi', $id_prodi)->get();
        $mk = MataKuliah::where('id_prodi', $id_prodi)->get();
        $dosen = Dosen::where('id_prodi', $id_prodi)->get();

        // Return dalam bentuk JSON
        return response()->json([
            'kelas' => $kelas,
            'mk' => $mk,
            'dosen' => $dosen,
        ]);
    }

    public function bulkDelete(Request $request)
    {
        $ids = explode(',', $request->selected_ids);

        if (empty($ids) || !is_array($ids)) {
            return redirect()->back()->with('error', 'Tidak ada data yang dipilih untuk dihapus.');
        }

        // Ambil ID jadwal yang sedang digunakan dalam peminjaman aktif
        $jadwalTerpakai = DB::table('peminjaman_jadwal')
            ->join('peminjaman', 'peminjaman_jadwal.id_peminjaman', '=', 'peminjaman.id_peminjaman')
            ->whereIn('peminjaman_jadwal.id_jadwalLab', $ids)
            ->whereIn('peminjaman.status_peminjaman', ['pengajuan', 'dipinjam', 'bermasalah'])
            ->pluck('peminjaman_jadwal.id_jadwalLab')
            ->toArray();

        // Jika ada yang terpakai, batalkan penghapusan dan beri tahu user
        if (!empty($jadwalTerpakai)) {
            return redirect()->back()
                ->with('error', 'Beberapa jadwal lab tidak bisa dihapus karena masih terhubung dengan peminjaman aktif (pengajuan, dipinjam, atau bermasalah).');
        }

        // Jika aman, lakukan penghapusan
        JadwalLab::whereIn('id_jadwalLab', $ids)->delete();

        return redirect()->route('jadwal_lab.index')
            ->with('success', 'Beberapa jadwal lab berhasil dihapus.');
    }
}
