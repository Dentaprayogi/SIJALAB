<?php

namespace App\Imports;

use App\Models\Dosen;
use App\Models\Hari;
use App\Models\JadwalLab;
use App\Models\Kelas;
use App\Models\Lab;
use App\Models\MataKuliah;
use App\Models\Prodi;
use App\Models\TahunAjaran;
use Illuminate\Support\Collection;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\Log;

class JadwalTemplateSheetImport implements ToCollection
{
    private $requiredColumns = [
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

    // Fungsi bantu untuk normalisasi header
    private function normalizeColumnName($value)
    {
        // Ubah ke lowercase, hapus karakter non-alfanumerik kecuali spasi, lalu trim
        $value = strtolower($value);
        $value = preg_replace('/[^a-z0-9 ]+/u', '', $value); // hanya huruf, angka, dan spasi
        return trim($value);
    }

    private function convertDecimalTimeToTimeString($decimalTime)
    {
        $hours = floor($decimalTime);
        $minutes = ($decimalTime - $hours) * 100;

        return sprintf('%02d:%02d:00', $hours, $minutes);
    }

    private function parseWithCode($value)
    {
        // Contoh input: "Pemrograman Web (TRPL)"
        // Output: ['name' => 'Pemrograman Web', 'code' => 'TRPL']
        preg_match('/^(.*?)\s*\((.*?)\)$/', $value, $matches);
        return [
            'name' => trim($matches[1] ?? $value),
            'code' => trim($matches[2] ?? '')
        ];
    }

    public function collection(Collection $rows)
    {
        if ($rows->isEmpty()) {
            throw ValidationException::withMessages([
                'file' => ['File Excel kosong.']
            ]);
        }

        // Ambil baris header (baris pertama)
        $headerRow = $rows->first();

        // Buat array nama kolom header yang sudah di-lowercase & trim
        $headerColumns = [];
        foreach ($headerRow as $col) {
            $headerColumns[] = $this->normalizeColumnName($col);
        }


        // Cek apakah semua kolom yang dibutuhkan ada di header
        foreach ($this->requiredColumns as $requiredColumn) {
            if (!in_array($requiredColumn, $headerColumns)) {
                $missingColumns[] = $requiredColumn;
            }
        }

        if (!empty($missingColumns)) {
            Log::warning('File Excel tidak memiliki kolom header yang lengkap: ' . implode(', ', $missingColumns));
            throw ValidationException::withMessages([
                'header' => ['Kolom header tidak lengkap, kurang: ' . implode(', ', $missingColumns)],
            ]);
        }

        // Hapus baris header agar proses selanjutnya hanya untuk data
        $rows->shift();

        foreach ($rows as $index => $row) {
            // Pastikan baris data memiliki kolom sesuai header (jumlah kolom >= jumlah header)
            if (count($row) < count($headerColumns)) {
                $emptyColumns = [];
                for ($i = 0; $i < count($headerColumns); $i++) {
                    if (!isset($row[$i]) || trim($row[$i]) === '') {
                        $emptyColumns[] = $headerColumns[$i] . " (Kolom ke-" . ($i + 1) . ")";
                    }
                }

                Log::warning("Baris #" . ($index + 2) . " memiliki kolom kosong: " . implode(', ', $emptyColumns));

                throw ValidationException::withMessages([
                    'row_' . ($index + 2) => ['Kolom data kosong atau tidak lengkap di: ' . implode(', ', $emptyColumns)],
                ]);
            }

            // Mapping kolom sesuai header
            $data = [];
            foreach ($headerColumns as $key => $colName) {
                $data[$colName] = strtolower(trim($row[$key]));
            }

            // Ambil dan proses data dari Excel
            $hariName         = $data['hari'];
            $tahunAjaranFull  = $data['tahun ajaran'];
            $labName          = $data['lab'];
            $jamMulai         = $this->convertDecimalTimeToTimeString(floatval($data['jam mulai']));
            $jamSelesai       = $this->convertDecimalTimeToTimeString(floatval($data['jam selesai']));
            $prodiName        = $data['prodi'];
            $kelasFull        = $data['kelas'];
            $mkFull           = $data['mata kuliah'];
            $dosenFull        = $data['dosen'];

            $tahunAjaranParts = $this->parseWithCode($tahunAjaranFull);
            $kelasParts       = $this->parseWithCode($kelasFull);
            $mkParts          = $this->parseWithCode($mkFull);
            $dosenParts       = $this->parseWithCode($dosenFull);

            // Mapping relasi
            $hari = Hari::whereRaw('LOWER(TRIM(nama_hari)) = ?', [$hariName])->first();
            $tahunAjaran = TahunAjaran::whereRaw('LOWER(TRIM(tahun_ajaran)) = ?', [$tahunAjaranParts['name']])
                ->whereRaw('LOWER(TRIM(semester)) = ?', [$tahunAjaranParts['code']])
                ->first();
            $lab = Lab::whereRaw('LOWER(TRIM(nama_lab)) = ?', [$labName])->first();
            $prodi = Prodi::whereRaw('LOWER(TRIM(singkatan_prodi)) = ?', [$kelasParts['code']])->first();
            $kelas = $prodi ? Kelas::whereRaw('LOWER(TRIM(nama_kelas)) = ?', [$kelasParts['name']])
                ->where('id_prodi', $prodi->id_prodi)
                ->first() : null;
            $mk = $prodi ? MataKuliah::whereRaw('LOWER(TRIM(nama_mk)) = ?', [$mkParts['name']])
                ->where('id_prodi', $prodi->id_prodi)
                ->first() : null;
            $dosen = $prodi ? Dosen::whereRaw('LOWER(TRIM(nama_dosen)) = ?', [$dosenParts['name']])
                ->where('id_prodi', $prodi->id_prodi)
                ->first() : null;

            // Logging (optional untuk debugging)
            Log::debug("Import row #" . ($index + 2), [
                'hari'         => $hariName,
                'tahun_ajaran' => $tahunAjaranParts,
                'lab'          => $labName,
                'jam_mulai'    => $jamMulai,
                'jam_selesai'  => $jamSelesai,
                'prodi'        => $prodiName,
                'kelas'        => $kelasParts,
                'mk'           => $mkParts,
                'dosen'        => $dosenParts,
            ]);

            // Cek duplikat jadwal
            $exists = JadwalLab::where('id_hari', $hari->id_hari)
                ->where('id_tahunAjaran', $tahunAjaran->id_tahunAjaran)
                ->where('id_lab', $lab->id_lab)
                ->where('jam_mulai', $jamMulai)
                ->where('jam_selesai', $jamSelesai)
                ->where('id_prodi', $prodi->id_prodi)
                ->where('id_kelas', $kelas->id_kelas)
                ->where('id_mk', $mk->id_mk)
                ->where('id_dosen', $dosen->id_dosen)
                ->exists();

            if ($exists) {
                throw ValidationException::withMessages([
                    'row_' . ($index + 2) => ['Jadwal sudah ada di database']
                ]);
            }

            Log::debug('Data JadwalLab yang akan disimpan:', [
                'id_hari'         => $hari->id_hari ?? null,
                'id_tahunAjaran'  => $tahunAjaran->id_tahunAjaran ?? null,
                'id_lab'          => $lab->id_lab ?? null,
                'jam_mulai'       => $jamMulai,
                'jam_selesai'     => $jamSelesai,
                'id_prodi'        => $prodi->id_prodi ?? null,
                'id_kelas'        => $kelas->id_kelas ?? null,
                'id_mk'           => $mk->id_mk ?? null,
                'id_dosen'        => $dosen->id_dosen ?? null,
                'status_jadwalLab' => 'aktif',
            ]);

            // Simpan ke database
            JadwalLab::create([
                'id_hari'         => $hari->id_hari,
                'id_tahunAjaran'  => $tahunAjaran->id_tahunAjaran,
                'id_lab'          => $lab->id_lab,
                'jam_mulai'       => $jamMulai,
                'jam_selesai'     => $jamSelesai,
                'id_prodi'        => $prodi->id_prodi,
                'id_kelas'        => $kelas->id_kelas,
                'id_mk'           => $mk->id_mk,
                'id_dosen'        => $dosen->id_dosen,
                'status_jadwalLab' => 'aktif',
            ]);

            Log::info("Data jadwal row #" . ($index + 2) . " berhasil disimpan");
        }
    }
}
