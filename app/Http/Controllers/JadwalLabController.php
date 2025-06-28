<?php

namespace App\Http\Controllers;

use App\Imports\JadwalLabImport;
use App\Models\Dosen;
use App\Models\Hari;
use App\Models\JadwalLab;
use App\Models\Kelas;
use App\Models\Lab;
use App\Models\Matakuliah;
use App\Models\Prodi;
use App\Models\SesiJam;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use PhpOffice\PhpSpreadsheet\NamedRange;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx as WriterXlsx;

class JadwalLabController extends Controller
{
    public function index()
    {
        // Auto aktifkan kembali jadwal yang sudah melewati waktu nonaktif
        \App\Models\JadwalLab::where('status_jadwalLab', 'nonaktif')
            ->whereNotNull('waktu_akhir_nonaktif')
            ->where('waktu_akhir_nonaktif', '<=', now())
            ->update([
                'status_jadwalLab' => 'aktif',
                'waktu_mulai_nonaktif' => null,
                'waktu_akhir_nonaktif' => null,
            ]);

        // Ambil semua jadwal aktif berdasarkan tahun ajaran aktif
        $jadwalLabs = JadwalLab::select('jadwal_lab.*')
            ->join('lab', 'jadwal_lab.id_lab', '=', 'lab.id_lab')
            ->whereHas('tahunAjaran', function ($query) {
                $query->where('status_tahunAjaran', 'aktif');
            })
            ->orderBy('id_hari', 'asc')
            ->orderBy('lab.nama_lab', 'asc')
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
            'prodiList' => Prodi::orderBy('singkatan_prodi', 'asc')->get(),
            'kelasList' => Kelas::orderBy('nama_kelas', 'asc')->get(),
            'tahunAjaranList' => TahunAjaran::where('status_tahunAjaran', 'aktif')->orderBy('tahun_ajaran', 'desc')->get(),
            'sesiJamList' => SesiJam::orderBy('jam_mulai')->get(),
        ]);
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx'
        ]);

        try {
            Excel::import(new JadwalLabImport, $request->file('file'));
            return redirect()->route('jadwal_lab.index')->with('success', 'Import berhasil!');
        } catch (ValidationException $e) {
            return redirect()->route('jadwal_lab.index')
                ->withErrors($e->errors())
                ->withInput();
        } catch (\Throwable $e) {
            return redirect()->route('jadwal_lab.index')
                ->with('error', 'Import gagal! ' . $e->getMessage());
        }
    }

    public function downloadTemplate()
    {
        $spreadsheet = new Spreadsheet();
        $templateSheet = $spreadsheet->getActiveSheet();
        $templateSheet->setTitle('Template');

        // Header kolom
        $headers = [
            'hari',
            'tahun ajaran',
            'lab',
            'jam mulai',
            'jam selesai',
            'prodi',
            'kelas',
            'mata kuliah',
            'dosen'
        ];
        $templateSheet->fromArray($headers, null, 'A1');

        // Data referensi dan logika pengisian
        $references = [
            'Hari' => [Hari::all(['id_hari', 'nama_hari']), 'id_hari', 'nama_hari'],

            'Tahun Ajaran' => [
                TahunAjaran::where('status_tahunAjaran', 'aktif')
                    ->orderBy('tahun_ajaran')->orderBy('semester')
                    ->get(['id_tahunAjaran', 'tahun_ajaran', 'semester']),
                'id_tahunAjaran',
                fn($item) => "{$item->tahun_ajaran} ({$item->semester})"
            ],

            'Lab' => [
                Lab::where('status_lab', 'aktif')
                    ->orderBy('nama_lab')->get(['id_lab', 'nama_lab']),
                'id_lab',
                fn($item) => $item->nama_lab
            ],

            'Jam Mulai' => [
                SesiJam::orderBy('jam_mulai')->pluck('jam_mulai')->unique()->map(fn($val) => ['value' => $val]),
                'value',
                fn($item) => $item['value']
            ],

            'Jam Selesai' => [
                SesiJam::orderBy('jam_selesai')->pluck('jam_selesai')->unique()->map(fn($val) => ['value' => $val]),
                'value',
                fn($item) => $item['value']
            ],

            'Prodi' => [
                Prodi::orderBy('singkatan_prodi')->get(['id_prodi', 'singkatan_prodi']),
                'id_prodi',
                fn($item) => $item->singkatan_prodi
            ],

            'Kelas' => [
                Kelas::with('prodi:id_prodi,singkatan_prodi')
                    ->join('prodi', 'kelas.id_prodi', '=', 'prodi.id_prodi')
                    ->orderBy('prodi.singkatan_prodi')
                    ->orderBy('kelas.nama_kelas')
                    ->select('kelas.*')->get(),
                'id_kelas',
                fn($item) => "{$item->nama_kelas} ({$item->prodi->singkatan_prodi})"
            ],

            'Mata Kuliah' => [
                MataKuliah::with('prodi:id_prodi,singkatan_prodi')
                    ->join('prodi', 'matakuliah.id_prodi', '=', 'prodi.id_prodi')
                    ->orderBy('prodi.singkatan_prodi')
                    ->orderBy('matakuliah.nama_mk')
                    ->select('matakuliah.*')->get(),
                'id_mk',
                fn($item) => "{$item->nama_mk} ({$item->prodi->singkatan_prodi})"
            ],

            'Dosen' => [
                Dosen::with('prodi:id_prodi,singkatan_prodi')
                    ->join('prodi', 'dosen.id_prodi', '=', 'prodi.id_prodi')
                    ->orderBy('prodi.singkatan_prodi')
                    ->orderBy('dosen.nama_dosen')
                    ->select('dosen.*')->get(),
                'id_dosen',
                fn($item) => "{$item->nama_dosen} ({$item->prodi->singkatan_prodi})"
            ],
        ];

        // Mapping kolom di template (A1 sampai I1)
        $colIndex = [
            'Hari'          => 'A',
            'Tahun Ajaran'  => 'B',
            'Lab'           => 'C',
            'Jam Mulai'     => 'D',
            'Jam Selesai'   => 'E',
            'Prodi'         => 'F',
            'Kelas'         => 'G',
            'Mata Kuliah'   => 'H',
            'Dosen'         => 'I',
        ];

        // Named range map
        $namedRangesMap = [
            'Hari'          => 'HariList',
            'Tahun Ajaran'  => 'TahunAjaranList',
            'Lab'           => 'LabList',
            'Jam Mulai'     => 'JamMulaiList',
            'Jam Selesai'   => 'JamSelesaiList',
            'Prodi'         => 'ProdiList',
            'Kelas'         => 'KelasList',
            'Mata Kuliah'   => 'MKList',
            'Dosen'         => 'DosenList',
        ];

        // Buat semua sheet referensi
        $sheetIndex = 1;
        foreach ($references as $sheetName => [$data, $idField, $nameFieldFn]) {
            $sheet = $spreadsheet->createSheet($sheetIndex++);
            $sheet->setTitle("Ref $sheetName");
            $sheet->setCellValue('A1', $idField);
            $sheet->setCellValue('B1', 'Label');

            $row = 2;
            foreach ($data as $item) {
                $idVal = is_array($item) ? $item[$idField] : $item->$idField;
                $label = is_callable($nameFieldFn) ? $nameFieldFn($item) : $item->$nameFieldFn;

                $sheet->setCellValue("A$row", $idVal);
                $sheet->setCellValue("B$row", $label);
                $row++;
            }

            $spreadsheet->addNamedRange(
                new NamedRange(
                    $namedRangesMap[$sheetName],
                    $sheet,
                    '$B$2:$B$' . ($row - 1)
                )
            );
        }

        // Tambahkan validasi dropdown ke baris 2-100 di sheet Template
        for ($i = 2; $i <= 100; $i++) {
            foreach ($colIndex as $refKey => $colLetter) {
                $validation = $templateSheet->getCell("{$colLetter}{$i}")->getDataValidation();
                $validation->setType(DataValidation::TYPE_LIST)
                    ->setErrorStyle(DataValidation::STYLE_STOP)
                    ->setAllowBlank(true)
                    ->setShowInputMessage(true)
                    ->setShowErrorMessage(true)
                    ->setShowDropDown(true)
                    ->setFormula1("={$namedRangesMap[$refKey]}");
            }
        }

        $spreadsheet->setActiveSheetIndex(0);

        $writer = new WriterXlsx($spreadsheet);
        $filename = 'template_jadwal_lab.xlsx';
        $tempPath = tempnam(sys_get_temp_dir(), $filename);
        $writer->save($tempPath);

        return response()->download($tempPath, $filename)->deleteFileAfterSend(true);
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_hari'          => 'required|exists:hari,id_hari',
            'id_lab'           => 'required|exists:lab,id_lab',
            'id_sesi_mulai'    => 'required|exists:sesi_jam,id_sesi_jam',
            'id_sesi_selesai'  => 'required|exists:sesi_jam,id_sesi_jam',
            'id_mk'            => 'required|exists:matakuliah,id_mk',
            'id_dosen'         => 'required|exists:dosen,id_dosen',
            'id_prodi'         => 'required|exists:prodi,id_prodi',
            'id_kelas'         => 'required|exists:kelas,id_kelas',
            'id_tahunAjaran'   => 'required|exists:tahun_ajaran,id_tahunAjaran',
        ]);

        // Ambil data sesi mulai dan selesai
        $sesiMulai = SesiJam::findOrFail($request->id_sesi_mulai);
        $sesiSelesai = SesiJam::findOrFail($request->id_sesi_selesai);

        // Validasi manual bahwa jam mulai harus lebih awal dari jam selesai
        if ($sesiMulai->jam_mulai >= $sesiSelesai->jam_mulai) {
            return redirect()->back()->withInput()->withErrors([
                'id_sesi_mulai' => 'Jam mulai harus lebih awal dari jam selesai.',
            ]);
        }

        // Rentang sesi jam
        $jamMulai = $sesiMulai->jam_mulai;
        $jamSelesai = $sesiSelesai->jam_selesai;

        // Ambil data request
        $year = $request->id_tahunAjaran;
        $day  = $request->id_hari;
        $lab  = $request->id_lab;

        // Fungsi bantu untuk cek overlap
        $overlap = function ($q) use ($jamMulai, $jamSelesai) {
            $q->where('jam_mulai', '<',  $jamSelesai)   // existing start  < new end
                ->where('jam_selesai', '>', $jamMulai);   // existing end    > new start
        };

        // 1) Lab bentrok?
        if (JadwalLab::where('id_hari', $day)
            ->where('id_lab', $lab)
            ->where('id_tahunAjaran', $year)
            ->where($overlap)           // ← pakai definisi baru
            ->exists()
        ) {
            throw ValidationException::withMessages([
                'id_lab' => ['Jadwal lab bentrok dengan rentang sesi yang dipilih.'],
            ]);
        }

        // 2) Dosen bentrok?
        if (JadwalLab::where('id_hari', $day)
            ->where('id_dosen', $request->id_dosen)
            ->where('id_tahunAjaran', $year)
            ->where($overlap)
            ->exists()
        ) {
            throw ValidationException::withMessages([
                'id_dosen' => ['Dosen sudah mengajar pada rentang sesi tersebut.'],
            ]);
        }

        // 3) Kelas bentrok?
        if (JadwalLab::where('id_hari', $day)
            ->where('id_kelas', $request->id_kelas)
            ->where('id_tahunAjaran', $year)
            ->where($overlap)
            ->exists()
        ) {
            throw ValidationException::withMessages([
                'id_kelas' => ['Kelas telah terjadwal pada rentang sesi tersebut.'],
            ]);
        }

        // Simpan jadwal lab
        $jadwal = JadwalLab::create([
            'id_hari'         => $day,
            'id_lab'          => $lab,
            'jam_mulai'       => $jamMulai,
            'jam_selesai'     => $jamSelesai,
            'id_mk'           => $request->id_mk,
            'id_dosen'        => $request->id_dosen,
            'id_prodi'        => $request->id_prodi,
            'id_kelas'        => $request->id_kelas,
            'id_tahunAjaran'  => $year,
            'status_jadwalLab' => 'aktif',
        ]);

        // Ambil semua sesi yang berada dalam rentang sesi mulai dan selesai
        $sesiDipilih = SesiJam::where('jam_mulai', '>=', $jamMulai)
            ->where('jam_selesai', '<=', $jamSelesai)
            ->pluck('id_sesi_jam');

        // Simpan relasi many-to-many ke pivot
        $jadwal->sesiJam()->attach($sesiDipilih);

        return redirect()->route('jadwal_lab.index')->with('success', 'Jadwal Lab berhasil ditambahkan.');
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
            'prodiList' => Prodi::orderBy('singkatan_prodi', 'asc')->get(),
            'kelasList' => Kelas::where('id_prodi', $prodiId)->orderBy('nama_kelas', 'asc')->get(),
            'tahunAjaranList' => TahunAjaran::where('status_tahunAjaran', 'aktif')->orderBy('tahun_ajaran', 'desc')->get(),
            'jadwalLab' => $jadwalLab,
            'sesiJamList' => SesiJam::orderBy('jam_mulai')->get(),
        ]);
    }

    public function update(Request $request, $id)
    {
        // VALIDASI DASAR
        $request->validate([
            'id_hari'          => 'required|exists:hari,id_hari',
            'id_lab'           => 'required|exists:lab,id_lab',
            'id_sesi_mulai'    => 'required|exists:sesi_jam,id_sesi_jam',
            'id_sesi_selesai'  => 'required|exists:sesi_jam,id_sesi_jam|gt:id_sesi_mulai',
            'id_mk'            => 'required|exists:matakuliah,id_mk',
            'id_dosen'         => 'required|exists:dosen,id_dosen',
            'id_prodi'         => 'required|exists:prodi,id_prodi',
            'id_kelas'         => 'required|exists:kelas,id_kelas',
            'id_tahunAjaran'   => 'required|exists:tahun_ajaran,id_tahunAjaran',
            'status_jadwalLab' => 'required',
        ]);

        // DAPATKAN SESI & CEK URUTAN
        $sesiMulai   = SesiJam::find($request->id_sesi_mulai);
        $sesiSelesai = SesiJam::find($request->id_sesi_selesai);

        if (!$sesiMulai || !$sesiSelesai || $sesiMulai->jam_mulai >= $sesiSelesai->jam_mulai) {
            return back()->withInput()->withErrors([
                'id_sesi_selesai' => 'Jam mulai harus lebih awal dari jam selesai.',
            ]);
        }

        $start = $sesiMulai->jam_mulai;   // string H:i:s
        $end   = $sesiSelesai->jam_selesai;

        // AMBIL JADWAL YANG DI‑EDIT
        $jadwalLab = JadwalLab::findOrFail($id);

        $year = $request->id_tahunAjaran;
        $day  = $request->id_hari;
        $lab  = $request->id_lab;

        // DEFINISI OVERLAP STRICT (bukan bersentuhan)
        $strictOverlap = function ($q) use ($start, $end) {
            $q->where('jam_mulai', '<',  $end)   // existing start < new end
                ->where('jam_selesai', '>', $start); // existing end   > new start
        };

        // BANGUN BASIS QUERY KONFLIK (semua jadwal lain di hari & thn ajaran)
        $base = JadwalLab::where('id_hari', $day)
            ->where('id_tahunAjaran', $year)
            ->where('id_jadwalLab', '!=', $jadwalLab->id_jadwalLab);

        /* LAB bentrok? */
        if ($base->clone()->where('id_lab', $lab)->where($strictOverlap)->exists()) {
            return back()->withInput()->withErrors(['id_lab' => 'Jadwal lab bentrok.']);
        }
        /* DOSEN bentrok? */
        if ($base->clone()->where('id_dosen', $request->id_dosen)->where($strictOverlap)->exists()) {
            return back()->withInput()->withErrors(['id_dosen' => 'Dosen bentrok di rentang sesi tersebut.']);
        }
        /* KELAS bentrok? */
        if ($base->clone()->where('id_kelas', $request->id_kelas)->where($strictOverlap)->exists()) {
            return back()->withInput()->withErrors(['id_kelas' => 'Kelas bentrok di rentang sesi tersebut.']);
        }

        // UPDATE DATA JADWA
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

        // SYNC SESI DI PIVOT
        $sesiRentang = SesiJam::whereBetween('id_sesi_jam', [
            $sesiMulai->id_sesi_jam,
            $sesiSelesai->id_sesi_jam,
        ])->pluck('id_sesi_jam');

        $jadwalLab->sesiJam()->sync($sesiRentang);

        return redirect()->route('jadwal_lab.index')
            ->with('success', 'Jadwal Lab berhasil diperbarui.');
    }


    public function destroy($id)
    {
        $jadwalLab = JadwalLab::findOrFail($id);

        // Cek apakah jadwal lab ini masih digunakan oleh peminjaman (semua status)
        $digunakan = DB::table('peminjaman_jadwal')
            ->where('id_jadwalLab', $id)
            ->exists();

        if ($digunakan) {
            return redirect()->back()
                ->with('error', 'Jadwal Lab tidak dapat dihapus karena masih terhubung oleh data peminjaman.');
        }

        $jadwalLab->delete();

        return redirect()->route('jadwal_lab.index')
            ->with('success', 'Jadwal Lab berhasil dihapus.');
    }

    public function getDependentData($id_prodi)
    {
        $kelas = Kelas::where('id_prodi', $id_prodi)
            ->orderBy('nama_kelas', 'asc')
            ->get();

        $mk = Matakuliah::where('id_prodi', $id_prodi)
            ->orderBy('nama_mk', 'asc')
            ->get();

        $dosen = Dosen::where('id_prodi', $id_prodi)
            ->orderBy('nama_dosen', 'asc')
            ->get();

        return response()->json([
            'kelas' => $kelas,
            'mk' => $mk,
            'dosen' => $dosen,
        ]);
    }

    public function toggleStatus(Request $request, $id_jadwalLab)
    {
        $jadwal = JadwalLab::findOrFail($id_jadwalLab);

        $status = $request->status_jadwalLab;

        if (!in_array($status, ['aktif', 'nonaktif'])) {
            return response()->json(['message' => 'Status tidak valid.'], 422);
        }

        $jadwal->status_jadwalLab = $status;

        if ($status === 'nonaktif') {
            $jadwal->waktu_mulai_nonaktif = $request->waktu_mulai_nonaktif;
            $jadwal->waktu_akhir_nonaktif = $request->waktu_akhir_nonaktif;
        } else {
            // Jika user aktifkan secara manual, bersihkan waktu nonaktif
            $jadwal->waktu_mulai_nonaktif = null;
            $jadwal->waktu_akhir_nonaktif = null;
        }

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

        // Ambil semua ID jadwal yang terhubung dengan peminjaman, tanpa mempedulikan status
        $jadwalTerpakai = DB::table('peminjaman_jadwal')
            ->whereIn('id_jadwalLab', $ids)
            ->pluck('id_jadwalLab')
            ->unique()
            ->toArray();

        // Jika ada yang terpakai, batalkan penghapusan dan beri tahu user
        if (!empty($jadwalTerpakai)) {
            return redirect()->back()
                ->with('error', 'Beberapa jadwal lab tidak bisa dihapus karena masih terhubung dengan data peminjaman.');
        }

        // Jika aman, lakukan penghapusan
        JadwalLab::whereIn('id_jadwalLab', $ids)->delete();

        return redirect()->route('jadwal_lab.index')
            ->with('success', 'Beberapa jadwal lab berhasil dihapus.');
    }
}
