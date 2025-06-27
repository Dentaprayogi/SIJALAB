<?php

namespace App\Imports;

use App\Models\{Dosen, Hari, JadwalLab, Kelas, Lab, MataKuliah, Prodi, TahunAjaran};
use Illuminate\Support\Collection;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToCollection;

class JadwalTemplateSheetImport implements ToCollection
{
    /* ==== Kolom wajib pada sheet Template ==== */
    private array $requiredColumns = [
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

    // Fungsi bantu: normalisasi nama kolom header
    private function normalizeColumnName(string $value): string
    {
        $value = strtolower($value);
        $value = preg_replace('/[^a-z0-9 ]+/u', '', $value); // hanya huruf/angka/spasi
        return trim($value);
    }

    // Fungsi bantu: konversi nilai waktu (dropdown teks / desimal)
    private function parseTimeFromCell(string|float $value): string
    {
        $value = trim((string) $value);

        // 1. Format H:i  atau  H.i
        if (preg_match('/^\d{1,2}[:.]\d{2}$/', $value)) {
            $value = str_replace('.', ':', $value);
            return date('H:i:s', strtotime($value));
        }

        // 2. Format H:i:s
        if (preg_match('/^\d{1,2}:\d{2}:\d{2}$/', $value)) {
            return $value;
        }

        // 3. Format desimal lama (7.5 => 07:50)
        if (is_numeric($value)) {
            $hours   = floor($value);
            $minutes = round(($value - $hours) * 100);
            return sprintf('%02d:%02d:00', $hours, $minutes);
        }

        // 4. Tidak dikenali
        throw ValidationException::withMessages([
            'jam' => ["Format jam tidak dikenali: \"$value\". Gunakan format 07:30 atau 13:15"],
        ]);
    }

    // Fungsi bantu: split "Nama (KODE)"
    private function parseWithCode(string $value): array
    {
        preg_match('/^(.*?)\s*\((.*?)\)$/', $value, $m);
        return [
            'name' => trim($m[1] ?? $value),
            'code' => trim($m[2] ?? ''),
        ];
    }

    // ENTRY POINT IMPORT
    public function collection(Collection $rows): void
    {
        if ($rows->isEmpty()) {
            throw ValidationException::withMessages(['file' => ['File Excel kosong.']]);
        }

        $headerRow = $rows->first();
        $headerColumns = [];
        foreach ($headerRow as $col) {
            $headerColumns[] = $this->normalizeColumnName($col);
        }

        $missingColumns = [];
        foreach ($this->requiredColumns as $required) {
            if (!in_array($required, $headerColumns, true)) {
                $missingColumns[] = $required;
            }
        }
        if ($missingColumns) {
            throw ValidationException::withMessages([
                'header' => ['Kolom header kurang: ' . implode(', ', $missingColumns)],
            ]);
        }

        $rows->shift();

        foreach ($rows as $idx => $row) {
            $rowNum = $idx + 2;

            if (count($row) < count($headerColumns)) {
                throw ValidationException::withMessages([
                    "row_$rowNum" => ['Jumlah kolom tidak lengkap.'],
                ]);
            }

            $data = [];
            foreach ($headerColumns as $key => $colName) {
                $data[$colName] = trim((string) $row[$key]);
            }

            $hariName        = strtolower($data['hari']);
            $tahunAjaranFull = $data['tahun ajaran'];
            $labName         = strtolower($data['lab']);
            $jamMulai        = $this->parseTimeFromCell($data['jam mulai']);
            $jamSelesai      = $this->parseTimeFromCell($data['jam selesai']);

            if (strtotime($jamMulai) >= strtotime($jamSelesai)) {
                throw ValidationException::withMessages([
                    "row_$rowNum" => ['Jam mulai harus lebih awal dari jam selesai.'],
                ]);
            }

            $prodiSingkatan = strtolower(trim($data['prodi']));
            $kelasParts     = $this->parseWithCode($data['kelas']);
            $mkParts        = $this->parseWithCode($data['mata kuliah']);
            $dosenParts     = $this->parseWithCode($data['dosen']);
            $tahunParts     = $this->parseWithCode($tahunAjaranFull);

            // RELASI
            $hari = Hari::whereRaw('LOWER(TRIM(nama_hari)) = ?', [$hariName])->first();
            $tahunAjaran = TahunAjaran::whereRaw('LOWER(TRIM(tahun_ajaran)) = ?', [$tahunParts['name']])
                ->whereRaw('LOWER(TRIM(semester)) = ?', [$tahunParts['code']])
                ->first();
            $lab = Lab::whereRaw('LOWER(TRIM(nama_lab)) = ?', [$labName])->first();
            $prodi = Prodi::whereRaw('LOWER(TRIM(singkatan_prodi)) = ?', [$prodiSingkatan])->first();

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
                    "row_$rowNum" => ['Data referensi tidak ditemukan atau salah.'],
                ]);
            }

            $exists = JadwalLab::where([
                'id_hari'        => $hari->id_hari,
                'id_tahunAjaran' => $tahunAjaran->id_tahunAjaran,
                'id_lab'         => $lab->id_lab,
                'jam_mulai'      => $jamMulai,
                'jam_selesai'    => $jamSelesai,
                'id_prodi'       => $prodi->id_prodi,
                'id_kelas'       => $kelas->id_kelas,
                'id_mk'          => $mk->id_mk,
                'id_dosen'       => $dosen->id_dosen,
            ])->exists();

            if ($exists) {
                throw ValidationException::withMessages([
                    "row_$rowNum" => ['Jadwal sudah ada di database.'],
                ]);
            }

            JadwalLab::create([
                'id_hari'          => $hari->id_hari,
                'id_tahunAjaran'   => $tahunAjaran->id_tahunAjaran,
                'id_lab'           => $lab->id_lab,
                'jam_mulai'        => $jamMulai,
                'jam_selesai'      => $jamSelesai,
                'id_prodi'         => $prodi->id_prodi,
                'id_kelas'         => $kelas->id_kelas,
                'id_mk'            => $mk->id_mk,
                'id_dosen'         => $dosen->id_dosen,
                'status_jadwalLab' => 'aktif',
            ]);
        }
    }
}
