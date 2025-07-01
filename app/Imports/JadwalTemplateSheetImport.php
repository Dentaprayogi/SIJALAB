<?php

namespace App\Imports;

use App\Models\{
    Dosen,
    Hari,
    JadwalLab,
    Kelas,
    Lab,
    MataKuliah,
    Prodi,
    SesiJam,
    TahunAjaran
};

use Illuminate\Support\Collection;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Concerns\ToCollection;

class JadwalTemplateSheetImport implements ToCollection
{
    //HEADER WAJIB PADA SHEET TEMPLATE 
    private array $requiredColumns = [
        'hari',
        'tahun ajaran',
        'lab',
        'sesi mulai',
        'sesi selesai',
        'prodi',
        'kelas',
        'mata kuliah',
        'dosen',
    ];

    //Normalize kolom header: lowercase + trim + hapus simbol
    private function normalize(string $val): string
    {
        return trim(preg_replace('/[^a-z0-9 ]+/u', '', strtolower($val)));
    }

    //Split  ❝Nama (KODE)❞   →   ['name' => …, 'code' => …]
    private function splitWithCode(string $val): array
    {
        preg_match('/^(.*?)\s*\((.*?)\)$/', $val, $m);
        return [
            'name' => trim($m[1] ?? $val),
            'code' => trim($m[2] ?? ''),
        ];
    }

    //Konversi sel Excel (07.30, 7.5, 07:30, dst) → 07:30:00 
    private function toTimeString(string|float $v): string
    {
        $v = trim((string) $v);

        /* 07:30  |  07.30 */
        if (preg_match('/^\d{1,2}([:.])\d{2}$/', $v)) {
            $v = str_replace('.', ':', $v);
            return date('H:i:s', strtotime($v));
        }

        /* 07:30:00 */
        if (preg_match('/^\d{1,2}:\d{2}:\d{2}$/', $v)) {
            return $v;
        }

        /* 7.5 → 07:50 */
        if (is_numeric($v)) {
            $h = (int) $v;
            $m = (int) round(($v - $h) * 100);
            return sprintf('%02d:%02d:00', $h, $m);
        }

        throw ValidationException::withMessages([
            'jam' => ["Format jam tidak dikenali: \"$v\""],
        ]);
    }

    //Cari id_sesi_jam berdasarkan jam mulai ATAU jam selesai  
    private function getSesiJamId(string $jam, string $tipe): ?int
    {
        return $tipe === 'mulai'
            ? SesiJam::where('jam_mulai', $jam)->value('id_sesi_jam')
            : SesiJam::where('jam_selesai', $jam)->value('id_sesi_jam');
    }

    //ENTRY POINT  
    public function collection(Collection $rows): void
    {
        if ($rows->isEmpty()) {
            throw ValidationException::withMessages(['file' => ['File Excel kosong.']]);
        }

        //Validasi Header
        $headerRaw      = $rows->shift();
        $headerColumns  = $headerRaw->map(fn($c) => $this->normalize($c))->toArray();
        $missing        = array_diff($this->requiredColumns, $headerColumns);

        if ($missing) {
            throw ValidationException::withMessages([
                'header' => ['Kolom header kurang: ' . implode(', ', $missing)],
            ]);
        }

        //Dapatkan indeks kolom sekali saja (lebih cepat)
        $colIdx = array_flip($headerColumns);

        //Iterasi baris data
        foreach ($rows as $idx => $row) {
            $rowNum = $idx + 2;

            //Pastikan jumlah kolom cukup
            if (count($row) < count($headerColumns)) {
                throw ValidationException::withMessages([
                    "row_$rowNum" => ['Jumlah kolom tidak lengkap.'],
                ]);
            }

            //Ambil dan bersihkan value 
            $val = fn(string $key) => trim((string) $row[$colIdx[$key]]);

            //Ambil nilai inti
            $hariName       = strtolower($val('hari'));
            $taFull         = $val('tahun ajaran');
            $labName        = strtolower($val('lab'));
            $prodiShort     = strtolower($val('prodi'));

            $jamMulaiStr    = $this->toTimeString($val('sesi mulai'));
            $jamSelesaiStr  = $this->toTimeString($val('sesi selesai'));

            //Cari id sesi 
            $idSesiMulai   = $this->getSesiJamId($jamMulaiStr,  'mulai');
            $idSesiSelesai = $this->getSesiJamId($jamSelesaiStr, 'selesai');

            if (!$idSesiMulai || !$idSesiSelesai) {
                throw ValidationException::withMessages([
                    "row_$rowNum" => ['Sesi mulai / selesai tidak cocok dengan tabel sesi_jam.'],
                ]);
            }

            //Pastikan urutan benar secara kronologis
            $sesiMulai   = SesiJam::find($idSesiMulai);
            $sesiSelesai = SesiJam::find($idSesiSelesai);

            if ($sesiMulai->jam_mulai >= $sesiSelesai->jam_selesai) {
                throw ValidationException::withMessages([
                    "row_$rowNum" => ['Sesi mulai harus lebih awal dari sesi selesai.'],
                ]);
            }

            //Split kolom bertanda kode
            $kelasParts  = $this->splitWithCode($val('kelas'));
            $mkParts     = $this->splitWithCode($val('mata kuliah'));
            $dosenParts  = $this->splitWithCode($val('dosen'));
            $taParts     = $this->splitWithCode($taFull);

            //Ambil referensi DB
            $hari = Hari::whereRaw('LOWER(TRIM(nama_hari)) = ?', [$hariName])->first();
            $tahunAjaran = TahunAjaran::whereRaw('LOWER(TRIM(tahun_ajaran)) = ?', [$taParts['name']])
                ->whereRaw('LOWER(TRIM(semester)) = ?', [$taParts['code']])
                ->first();
            $lab = Lab::whereRaw('LOWER(TRIM(nama_lab)) = ?', [$labName])->first();
            $prodi = Prodi::whereRaw('LOWER(TRIM(singkatan_prodi)) = ?', [$prodiShort])->first();

            $kelas = $prodi ? Kelas::where('id_prodi', $prodi->id_prodi)
                ->whereRaw('LOWER(TRIM(nama_kelas)) = ?', [strtolower($kelasParts['name'])])
                ->first() : null;

            $mk = $prodi ? MataKuliah::where('id_prodi', $prodi->id_prodi)
                ->whereRaw('LOWER(TRIM(nama_mk)) = ?', [strtolower($mkParts['name'])])
                ->first() : null;

            $dosen = $prodi ? Dosen::where('id_prodi', $prodi->id_prodi)
                ->whereRaw('LOWER(TRIM(nama_dosen)) = ?', [strtolower($dosenParts['name'])])
                ->first() : null;

            if (!$hari || !$tahunAjaran || !$lab || !$prodi || !$kelas || !$mk || !$dosen) {
                throw ValidationException::withMessages([
                    "row_$rowNum" => ['Data referensi tidak ditemukan / salah.'],
                ]);
            }

            //SIMPAN JADWAL
            $jadwal = JadwalLab::create([
                'id_hari'          => $hari->id_hari,
                'id_tahunAjaran'   => $tahunAjaran->id_tahunAjaran,
                'id_lab'           => $lab->id_lab,
                'id_prodi'         => $prodi->id_prodi,
                'id_kelas'         => $kelas->id_kelas,
                'id_mk'            => $mk->id_mk,
                'id_dosen'         => $dosen->id_dosen,
                'status_jadwalLab' => 'aktif',
            ]);

            // Ambil seluruh sesi di rentang 
            $sesiIds = SesiJam::whereBetween(
                'id_sesi_jam',
                [$idSesiMulai, $idSesiSelesai]
            )->pluck('id_sesi_jam');

            $jadwal->sesiJam()->attach($sesiIds);
        }
    }
}
