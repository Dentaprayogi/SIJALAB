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

        // Header kolom yang rapi dan konsisten (huruf kecil, satu spasi)
        $headers = [
            'hari',
            'tahun ajaran',
            'lab',
            'jam mulai',
            'jam selesai',
            'prodi',
            'kelas',
            'mata kuliah',
            'dosen',
        ];
        $templateSheet->fromArray($headers, null, 'A1');

        // Data referensi
        $references = [
            'Hari' => [Hari::all(['id_hari', 'nama_hari']), 'id_hari', 'nama_hari'],

            'Tahun Ajaran' => [
                TahunAjaran::where('status_tahunAjaran', 'aktif')
                    ->orderBy('tahun_ajaran')
                    ->orderBy('semester')
                    ->get(['id_tahunAjaran', 'tahun_ajaran', 'semester']),
                'id_tahunAjaran',
                'tahun_ajaran',
                'semester'
            ],

            'Lab' => [
                Lab::where('status_lab', 'aktif')
                    ->orderBy('nama_lab', 'asc')
                    ->get(['id_lab', 'nama_lab']),
                'id_lab',
                'nama_lab'
            ],

            'Prodi' => [
                Prodi::orderBy('singkatan_prodi', 'asc')
                    ->get(['id_prodi', 'nama_prodi', 'singkatan_prodi']),
                'id_prodi',
                'nama_prodi',
                'singkatan_prodi'
            ],

            'Kelas' => [
                Kelas::with('prodi:id_prodi,singkatan_prodi')
                    ->join('prodi', 'kelas.id_prodi', '=', 'prodi.id_prodi')
                    ->orderBy('prodi.singkatan_prodi')
                    ->orderBy('kelas.nama_kelas')
                    ->select('kelas.*') // Hindari ambil kolom dari join jika tidak diperlukan
                    ->get(),
                'id_kelas',
                'nama_kelas',
                null
            ],

            'Mata Kuliah' => [
                MataKuliah::with('prodi:id_prodi,singkatan_prodi')
                    ->join('prodi', 'matakuliah.id_prodi', '=', 'prodi.id_prodi')
                    ->orderBy('prodi.singkatan_prodi')
                    ->orderBy('matakuliah.nama_mk')
                    ->select('matakuliah.*')
                    ->get(),
                'id_mk',
                'nama_mk',
                null
            ],

            'Dosen' => [
                Dosen::with('prodi:id_prodi,singkatan_prodi')
                    ->join('prodi', 'dosen.id_prodi', '=', 'prodi.id_prodi')
                    ->orderBy('prodi.singkatan_prodi')
                    ->orderBy('dosen.nama_dosen')
                    ->select('dosen.*')
                    ->get(),
                'id_dosen',
                'nama_dosen',
                null
            ],
        ];

        // Mapping kolom ke huruf kolom di Template
        $colIndex = [
            'Hari' => 'A',
            'Tahun Ajaran' => 'B',
            'Lab' => 'C',
            'Prodi' => 'F',
            'Kelas' => 'G',
            'Mata Kuliah' => 'H',
            'Dosen' => 'I',
        ];

        // Mapping kolom ke named range
        $namedRangesMap = [
            'Hari' => 'HariList',
            'Tahun Ajaran' => 'TahunAjaranList',
            'Lab' => 'LabList',
            'Prodi' => 'ProdiList',
            'Kelas' => 'KelasList',
            'Mata Kuliah' => 'MKList',
            'Dosen' => 'DosenList',
        ];

        $sheetIndex = 1;

        foreach ($references as $sheetName => [$data, $idField, $nameField]) {
            $sheet = $spreadsheet->createSheet($sheetIndex++);
            $sheet->setTitle("Referensi $sheetName");

            $sheet->setCellValue('A1', $idField);
            $sheet->setCellValue('B1', $nameField);

            $row = 2;
            foreach ($data as $item) {
                $sheet->setCellValue("A{$row}", $item->$idField);

                switch ($sheetName) {
                    case 'Tahun Ajaran':
                        $sheet->setCellValue("B{$row}", "{$item->tahun_ajaran} ({$item->semester})");
                        break;

                    case 'Prodi':
                        $sheet->setCellValue("B{$row}", $item->singkatan_prodi);
                        break;

                    case 'Kelas':
                        $sheet->setCellValue("B{$row}", "{$item->nama_kelas} ({$item->prodi->singkatan_prodi})");
                        break;

                    case 'Mata Kuliah':
                        $sheet->setCellValue("B{$row}", "{$item->nama_mk} ({$item->prodi->singkatan_prodi})");
                        break;

                    case 'Dosen':
                        $sheet->setCellValue("B{$row}", "{$item->nama_dosen} ({$item->prodi->singkatan_prodi})");
                        break;

                    default:
                        $sheet->setCellValue("B{$row}", $item->$nameField);
                }

                $row++;
            }

            $highestRow = $row - 1;
            $namedRangeName = $namedRangesMap[$sheetName] ?? null;

            if ($namedRangeName) {
                $spreadsheet->addNamedRange(
                    new NamedRange(
                        $namedRangeName,
                        $sheet,
                        "\$B\$2:\$B\$$highestRow"
                    )
                );
            }
        }

        // Dropdown validation dari baris 2-100
        for ($i = 2; $i <= 100; $i++) {
            foreach ($colIndex as $columnLabel => $colLetter) {
                $validation = $templateSheet->getCell("{$colLetter}{$i}")->getDataValidation();
                $validation->setType(DataValidation::TYPE_LIST);
                $validation->setErrorStyle(DataValidation::STYLE_STOP);
                $validation->setAllowBlank(true);
                $validation->setShowInputMessage(true);
                $validation->setShowErrorMessage(true);
                $validation->setShowDropDown(true);
                $validation->setFormula1("={$namedRangesMap[$columnLabel]}");
            }
        }

        $spreadsheet->setActiveSheetIndex(0);

        $writer = new WriterXlsx($spreadsheet);
        $filename = 'template_jadwal_lab.xlsx';
        $temp_file = tempnam(sys_get_temp_dir(), $filename);
        $writer->save($temp_file);

        return response()->download($temp_file, $filename)->deleteFileAfterSend(true);
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
