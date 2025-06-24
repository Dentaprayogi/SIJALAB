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
                ['nama_dosen' => 'Mohamad Dimyati Ayatullah, S.T., M.Kom.', 'telepon' => '08123399184', 'nip' => '197601222021211001'],
                ['nama_dosen' => 'Dianni Yusuf, S.Kom., M.Kom.', 'telepon' => '082328333399', 'nip' => '198403052021212004'],
                ['nama_dosen' => 'Eka Mistiko Rini, S.Kom, M.Kom.', 'telepon' => '081913922224', 'nip' => '198310202014042001'],
                ['nama_dosen' => 'Farizqi Panduardi, S.ST., M.T.', 'telepon' => '082244680800', 'nip' => '198603052024211014'],
                ['nama_dosen' => 'Devit Suwardiyanto,S.Si., M.T.', 'telepon' => '08113570683', 'nip' => '198311052015041001'],
                ['nama_dosen' => 'Lutfi Hakim, S.Pd., M.T.', 'telepon' => '085330161514', 'nip' => '199203302019031012'],
                ['nama_dosen' => 'Sepyan Purnama Kristanto, S.Kom., M.Kom.', 'telepon' => '+6285237516017', 'nip' => '199009052019031024'],
                ['nama_dosen' => 'Ruth Ema Febrita, S.Pd., M.Kom.', 'telepon' => '085259082627', 'nip' => '199202272020122019'],
                ['nama_dosen' => 'Lukman Hakim S.Kom., M.T', 'telepon' => '081232947805', 'nip' => '198903232022031007'],
                ['nama_dosen' => 'Khoirul Umam, S.Pd, M.Kom', 'telepon' => '087755580796', 'nip' => '199103112022031006'],
                ['nama_dosen' => 'Arif Fahmi, S.T., M.T.', 'telepon' => '081217945658', 'nip' => '199503032024061001'],
                ['nama_dosen' => 'Eka Novita Sari, S. Kom., M.Kom.', 'telepon' => '+6285736907069', 'nip' => '199312032024062002'],
                ['nama_dosen' => 'Furiansyah Dipraja, S.T., M.Kom.', 'telepon' => '+6282129916997', 'nip' => '199408122024061002'],
                ['nama_dosen' => 'Indra Kurniawan, S.T., M.Eng.', 'telepon' => '+6285293810942', 'nip' => '199607142024061001'],
            ],
            'Teknologi Rekayasa Komputer dan jaringan' => [
                ['nama_dosen' => 'Herman Yuliandoko, S.T., M.T.', 'telepon' => '081334436478', 'nip' => '197509272021211002'],
                ['nama_dosen' => 'Vivien Arief Wardhany, S.T., M.T.', 'telepon' => '081331068658', 'nip' => '198404032019032012'],
                ['nama_dosen' => 'Endi Sailul Haq, S.T., M.Kom.', 'telepon' => '081336851513', 'nip' => '198403112019031005'],
                ['nama_dosen' => 'Subono, S.T., M.T.', 'telepon' => '087859576210', 'nip' => '197506252021211003'],
                ['nama_dosen' => 'Alfin Hidayat, S.T., M.T.', 'telepon' => '085731147608', 'nip' => '199010052014041002'],
                ['nama_dosen' => 'Junaedi Adi Prasetyo, S.ST., M.Sc.', 'telepon' => '082333312244', 'nip' => '199004192018031001'],
                ['nama_dosen' => 'Galih Hendra Wibowo, S.Tr.Kom., M.T.', 'telepon' => '083831120642', 'nip' => '199209052022031004'],
                ['nama_dosen' => 'Agus Priyo Utomo, S.ST., M.Tr.Kom.', 'telepon' => '085 731 311 399', 'nip' => '198708272024211012'],
            ],
            'Bisnis Digital' => [
                ['nama_dosen' => 'I Wayan Suardinata, S.Kom., M.T.', 'telepon' => '085736577864', 'nip' => '198010222015041001'],
                ['nama_dosen' => 'Moh. Nur Shodiq, S.T., M.T.', 'telepon' => '085236675444', 'nip' => '198301192021211006'],
                ['nama_dosen' => 'Dedy Hidayat Kusuma, S.T., M.Cs.', 'telepon' => '087755527517', 'nip' => '197704042021211004'],
                ['nama_dosen' => 'Muh. Fuad Al Haris, S.T., M.T.', 'telepon' => '081234619898', 'nip' => '197806132014041001'],
                ['nama_dosen' => 'Arum Andary Ratri, S.Si., M.Si.', 'telepon' => '083117703473', 'nip' => '199209212020122021'],
                ['nama_dosen' => 'Indira Nuansa Ratri, S.M., M.SM.', 'telepon' => '083831244299', 'nip' => '199607032024062001'],
                ['nama_dosen' => 'Mega Devita Sari, M. A', 'telepon' => '082397148738', 'nip' => '199708052025062007'],
                ['nama_dosen' => 'Septa Lukman Andes, S.AB., M.AB.', 'telepon' => '087789027297', 'nip' => '199409212025061002'],
            ],
        ];

        foreach ($dataDosen as $namaProdi => $dosenList) {
            $prodi = Prodi::where('nama_prodi', $namaProdi)->first();

            if ($prodi) {
                foreach ($dosenList as $dosen) {
                    Dosen::create([
                        'nama_dosen' => $dosen['nama_dosen'],
                        'nip' => $dosen['nip'],
                        'telepon' => $dosen['telepon'],
                        'id_prodi' => $prodi->id_prodi,
                    ]);
                }
            }
        }
    }
}
