<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Dosen;
use App\Models\Prodi;

class DosenSeeder extends Seeder
{
    public function run(): void
    {
        $dataDosen = [
            'Teknologi Rekayasa Perangkat Lunak' => [
                ['nama_dosen' => 'Mohamad Dimyati Ayatullah, S.T., M.Kom.', 'telepon' => '08123399184'],
                ['nama_dosen' => 'Dianni Yusuf, S.Kom., M.Kom.', 'telepon' => '082328333399'],
                ['nama_dosen' => 'Eka Mistiko Rini, S.Kom, M.Kom.', 'telepon' => '081913922224'],
                ['nama_dosen' => 'Farizqi Panduardi, S.ST., M.T.', 'telepon' => '082244680800'],
                ['nama_dosen' => 'Devit Suwardiyanto,S.Si., M.T.', 'telepon' => '08113570683'],
                ['nama_dosen' => 'Lutfi Hakim, S.Pd., M.T.', 'telepon' => '085330161514'],
                ['nama_dosen' => 'Sepyan Purnama Kristanto, S.Kom., M.Kom.', 'telepon' => '+6285237516017'],
                ['nama_dosen' => 'Ruth Ema Febrita, S.Pd., M.Kom.', 'telepon' => '085259082627'],
                ['nama_dosen' => 'Lukman Hakim S.Kom., M.T', 'telepon' => '081232947805'],
                ['nama_dosen' => 'Khoirul Umam, S.Pd, M.Kom', 'telepon' => '087755580796'],
                ['nama_dosen' => 'Arif Fahmi, S.T., M.T.', 'telepon' => '081217945658'],
                ['nama_dosen' => 'Eka Novita Sari, S. Kom., M.Kom.', 'telepon' => '+6285736907069'],
                ['nama_dosen' => 'Furiansyah Dipraja, S.T., M.Kom.', 'telepon' => '+6282129916997'],
                ['nama_dosen' => 'Indra Kurniawan, S.T., M.Eng.', 'telepon' => '+6285293810942'],
            ],
            'Teknologi Rekayasa Komputer dan Jaringan' => [
                ['nama_dosen' => 'Herman Yuliandoko, S.T., M.T.', 'telepon' => '081334436478'],
                ['nama_dosen' => 'Vivien Arief Wardhany, S.T., M.T.', 'telepon' => '081331068658'],
                ['nama_dosen' => 'Endi Sailul Haq, S.T., M.Kom.', 'telepon' => '081336851513'],
                ['nama_dosen' => 'Subono, S.T., M.T.', 'telepon' => '087859576210'],
                ['nama_dosen' => 'Alfin Hidayat, S.T., M.T.', 'telepon' => '085731147608'],
                ['nama_dosen' => 'Junaedi Adi Prasetyo, S.ST., M.Sc.', 'telepon' => '082333312244'],
                ['nama_dosen' => 'Galih Hendra Wibowo, S.Tr.Kom., M.T.', 'telepon' => '083831120642'],
                ['nama_dosen' => 'Agus Priyo Utomo, S.ST., M.Tr.Kom.', 'telepon' => '085 731 311 399'],
            ],
            'Bisnis Digital' => [
                ['nama_dosen' => 'I Wayan Suardinata, S.Kom., M.T.', 'telepon' => '085736577864'],
                ['nama_dosen' => 'Moh. Nur Shodiq, S.T., M.T.', 'telepon' => '085236675444'],
                ['nama_dosen' => 'Dedy Hidayat Kusuma, S.T., M.Cs.', 'telepon' => '087755527517'],
                ['nama_dosen' => 'Muh. Fuad Al Haris, S.T., M.T.', 'telepon' => '081234619898'],
                ['nama_dosen' => 'Arum Andary Ratri, S.Si., M.Si.', 'telepon' => '083117703473'],
                ['nama_dosen' => 'Indira Nuansa Ratri, S.M., M.SM.', 'telepon' => '083831244299'],
            ],
        ];

        foreach ($dataDosen as $namaProdi => $dosenList) {
            $prodi = Prodi::where('nama_prodi', $namaProdi)->first();

            if ($prodi) {
                foreach ($dosenList as $dosen) {
                    Dosen::create([
                        'nama_dosen' => $dosen['nama_dosen'],
                        'telepon' => $dosen['telepon'],
                        'id_prodi' => $prodi->id_prodi,
                    ]);
                }
            }
        }
    }
}
