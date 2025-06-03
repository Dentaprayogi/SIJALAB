<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Hari;
use App\Models\Lab;
use App\Models\Matakuliah;
use App\Models\Dosen;
use App\Models\Prodi;
use App\Models\Kelas;
use App\Models\TahunAjaran;
use App\Models\JadwalLab;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Maatwebsite\Excel\Facades\Excel;
use Tests\TestCase;
use App\Imports\JadwalLabImport;
use Mockery;
use PHPUnit\Framework\Attributes\Test;

class JadwalLabControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $user = User::factory()->create(['role' => 'teknisi']);
        $this->actingAs($user);
    }

    #[Test]
    public function index_menampilkan_halaman_jadwal_lab()
    {

        // Setup: Tahun Ajaran Aktif dan Jadwal Lab
        $tahunAjaran = TahunAjaran::factory()->create(['status_tahunAjaran' => 'aktif']);
        JadwalLab::factory()->create(['id_tahunAjaran' => $tahunAjaran->id_tahunAjaran]);

        $response = $this->get(route('jadwal_lab.index'));

        $response->assertStatus(200);
        $response->assertViewIs('web.jadwal_lab.index');
        $response->assertViewHas('jadwalLabs');
    }

    #[Test]
    public function create_menampilkan_form_tambah_jadwal_lab()
    {

        Hari::factory()->count(7)->create();
        Lab::factory()->create(['status_lab' => 'aktif']);
        Matakuliah::factory()->create();
        Dosen::factory()->create();
        Prodi::factory()->create();
        Kelas::factory()->create();
        TahunAjaran::factory()->create(['status_tahunAjaran' => 'aktif']);

        $response = $this->get(route('jadwal_lab.create'));

        $response->assertStatus(200);
        $response->assertViewIs('web.jadwal_lab.create');
        $response->assertViewHasAll([
            'hariList',
            'labList',
            'mkList',
            'dosenList',
            'prodiList',
            'kelasList',
            'tahunAjaranList'
        ]);
    }

    #[Test]
    public function import_berhasil_dengan_file_excel_valid()
    {

        // Mock Excel facade
        Excel::fake();

        $file = UploadedFile::fake()->create('jadwal.xlsx');

        $response = $this->post(route('jadwal_lab.import'), [
            'file' => $file,
        ]);

        $response->assertRedirect(route('jadwal_lab.index'));
        $response->assertSessionHas('success', 'Import berhasil!');

        Excel::assertImported('jadwal.xlsx', function (JadwalLabImport $import) {
            return true;
        });
    }

    #[Test]
    public function import_gagal_ketika_file_tidak_valid()
    {

        $file = UploadedFile::fake()->create('not_excel.txt');

        $response = $this->post(route('jadwal_lab.import'), [
            'file' => $file,
        ]);

        $response->assertSessionHasErrors(['file']);
    }

    #[Test]
    public function store_menyimpan_jadwal_lab_baru()
    {
        $hari = Hari::factory()->create();
        $lab = Lab::factory()->create();
        $tahun = TahunAjaran::factory()->create();
        $prodi = Prodi::factory()->create();
        $kelas = Kelas::factory()->create(['id_prodi' => $prodi->id_prodi]);
        $mk = MataKuliah::factory()->create(['id_prodi' => $prodi->id_prodi]);
        $dosen = Dosen::factory()->create(['id_prodi' => $prodi->id_prodi]);

        $data = [
            'id_hari' => $hari->id_hari,
            'id_lab' => $lab->id_lab,
            'jam_mulai' => '08:00',
            'jam_selesai' => '10:00',
            'id_mk' => $mk->id_mk,
            'id_dosen' => $dosen->id_dosen,
            'id_prodi' => $prodi->id_prodi,
            'id_kelas' => $kelas->id_kelas,
            'id_tahunAjaran' => $tahun->id_tahunAjaran,
        ];

        $response = $this->post(route('jadwal_lab.store'), $data);

        $response->assertRedirect(route('jadwal_lab.index'));
        $this->assertDatabaseHas('jadwal_lab', [
            'id_hari' => $data['id_hari'],
            'id_lab' => $data['id_lab'],
            'jam_mulai' => $data['jam_mulai'],
            'jam_selesai' => $data['jam_selesai'],
            'id_mk' => $data['id_mk'],
            'id_dosen' => $data['id_dosen'],
            'id_prodi' => $data['id_prodi'],
            'id_kelas' => $data['id_kelas'],
            'id_tahunAjaran' => $data['id_tahunAjaran'],
        ]);
    }

    #[Test]
    public function store_menolak_jadwal_yang_bentrok_dengan_lab()
    {
        $hari = Hari::factory()->create();
        $lab = Lab::factory()->create();
        $tahun = TahunAjaran::factory()->create();
        $prodi = Prodi::factory()->create();
        $kelas = Kelas::factory()->create(['id_prodi' => $prodi->id_prodi]);
        $mk = MataKuliah::factory()->create(['id_prodi' => $prodi->id_prodi]);
        $dosen = Dosen::factory()->create(['id_prodi' => $prodi->id_prodi]);

        JadwalLab::create([
            'id_hari' => $hari->id_hari,
            'id_lab' => $lab->id_lab,
            'jam_mulai' => '08:00',
            'jam_selesai' => '10:00',
            'id_mk' => $mk->id_mk,
            'id_dosen' => $dosen->id_dosen,
            'id_prodi' => $prodi->id_prodi,
            'id_kelas' => $kelas->id_kelas,
            'id_tahunAjaran' => $tahun->id_tahunAjaran,
            'status_jadwalLab' => 'aktif',
        ]);

        $data = [
            'id_hari' => $hari->id_hari,
            'id_lab' => $lab->id_lab,
            'jam_mulai' => '09:00', // Bentrok
            'jam_selesai' => '11:00',
            'id_mk' => $mk->id_mk,
            'id_dosen' => $dosen->id_dosen,
            'id_prodi' => $prodi->id_prodi,
            'id_kelas' => $kelas->id_kelas,
            'id_tahunAjaran' => $tahun->id_tahunAjaran,
        ];

        $response = $this->from(route('jadwal_lab.index'))->post(route('jadwal_lab.store'), $data);

        $response->assertSessionHasErrors('jam_mulai');
        $this->assertDatabaseCount('jadwal_lab', 1);
    }

    #[Test]
    public function download_template_menghasilkan_file_excel()
    {
        $response = $this->get(route('jadwal_lab.template'));

        $response->assertStatus(200);
        $response->assertHeader('Content-Disposition');
        $this->assertStringContainsString('template_jadwal_lab.xlsx', $response->headers->get('Content-Disposition'));
    }

    #[Test]
    public function update_memperbarui_data_jadwal_lab()
    {
        $prodi = Prodi::factory()->create();
        $hari = Hari::factory()->create();
        $lab = Lab::factory()->create(['status_lab' => 'aktif']);
        $mk = Matakuliah::factory()->create(['id_prodi' => $prodi->id_prodi]);
        $dosen = Dosen::factory()->create(['id_prodi' => $prodi->id_prodi]);
        $kelas = Kelas::factory()->create(['id_prodi' => $prodi->id_prodi]);
        $tahunAjaran = TahunAjaran::factory()->create(['status_tahunAjaran' => 'aktif']);
        $jadwalLab = JadwalLab::factory()->create([
            'id_prodi' => $prodi->id_prodi,
            'id_hari' => $hari->id_hari,
            'id_lab' => $lab->id_lab,
            'jam_mulai' => '08:00',
            'jam_selesai' => '10:00',
            'id_mk' => $mk->id_mk,
            'id_dosen' => $dosen->id_dosen,
            'id_kelas' => $kelas->id_kelas,
            'id_tahunAjaran' => $tahunAjaran->id_tahunAjaran,
            'status_jadwalLab' => 'aktif',
        ]);

        $data = [
            'id_hari' => $hari->id_hari,
            'id_lab' => $lab->id_lab,
            'jam_mulai' => '10:00',
            'jam_selesai' => '12:00',
            'id_mk' => $mk->id_mk,
            'id_dosen' => $dosen->id_dosen,
            'id_prodi' => $prodi->id_prodi,
            'id_kelas' => $kelas->id_kelas,
            'id_tahunAjaran' => $tahunAjaran->id_tahunAjaran,
            'status_jadwalLab' => 'aktif',
        ];

        $response = $this->put(route('jadwal_lab.update', $jadwalLab->id_jadwalLab), $data);

        $response->assertRedirect(route('jadwal_lab.index'));
        $this->assertDatabaseHas('jadwal_lab', [
            'id_jadwalLab' => $jadwalLab->id_jadwalLab,
            'jam_mulai' => '10:00',
            'jam_selesai' => '12:00',
        ]);
    }

    #[Test]
    public function destroy_menghapus_jadwal_lab()
    {
        $jadwalLab = JadwalLab::factory()->create();

        $response = $this->delete(route('jadwal_lab.destroy', $jadwalLab->id_jadwalLab));

        $response->assertRedirect(route('jadwal_lab.index'));
        $this->assertDatabaseMissing('jadwal_lab', [
            'id_jadwalLab' => $jadwalLab->id_jadwalLab,
        ]);
    }

    #[Test]
    public function toggle_status_mengubah_status_jadwal_lab()
    {
        $jadwalLab = JadwalLab::factory()->create(['status_jadwalLab' => 'aktif']);

        $response = $this->patch(route('jadwal_lab.toggle-status', $jadwalLab->id_jadwalLab), [
            'status_jadwalLab' => 'nonaktif',
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('jadwal_lab', [
            'id_jadwalLab' => $jadwalLab->id_jadwalLab,
            'status_jadwalLab' => 'nonaktif',
        ]);
    }

    #[Test]
    public function get_dependent_data_mengembalikan_data_terkait()
    {
        $prodi = Prodi::factory()->create();
        $kelas = Kelas::factory()->create(['id_prodi' => $prodi->id_prodi]);
        $mk = Matakuliah::factory()->create(['id_prodi' => $prodi->id_prodi]);
        $dosen = Dosen::factory()->create(['id_prodi' => $prodi->id_prodi]);

        $response = $this->get(route('jadwal_lab.getDependentData', $prodi->id_prodi));

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'kelas',
            'mk',
            'dosen',
        ]);
    }

    #[Test]
    public function bulk_delete_menghapus_beberapa_jadwal_lab()
    {
        $jadwalLab1 = JadwalLab::factory()->create();
        $jadwalLab2 = JadwalLab::factory()->create();

        $response = $this->delete(route('jadwal_lab.bulkDelete'), [
            'selected_ids' => $jadwalLab1->id_jadwalLab . ',' . $jadwalLab2->id_jadwalLab,
        ]);

        $response->assertRedirect(route('jadwal_lab.index'));
        $this->assertDatabaseMissing('jadwal_lab', [
            'id_jadwalLab' => $jadwalLab1->id_jadwalLab,
        ]);
        $this->assertDatabaseMissing('jadwal_lab', [
            'id_jadwalLab' => $jadwalLab2->id_jadwalLab,
        ]);
    }
}
