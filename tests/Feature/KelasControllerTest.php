<?php

namespace Tests\Feature;

use App\Models\Kelas;
use App\Models\Prodi;
use App\Models\Mahasiswa;
use App\Models\JadwalLab;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class KelasControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $user = User::factory()->create(['role' => 'teknisi']);
        $this->actingAs($user);
    }

    #[Test]
    public function index_menampilkan_halaman_dan_data_kelas()
    {
        $prodi = Prodi::factory()->create();
        Kelas::factory()->count(3)->create(['id_prodi' => $prodi->id_prodi]);

        $response = $this->get(route('kelas.index'));

        $response->assertStatus(200);
        $response->assertViewIs('web.kelas.index');
        $response->assertViewHasAll(['kelas', 'prodi']);
        $this->assertCount(3, $response->viewData('kelas'));
        $this->assertCount(1, $response->viewData('prodi'));
    }

    #[Test]
    public function store_menambahkan_kelas_baru()
    {
        $prodi = Prodi::factory()->create();

        $data = [
            'id_prodi' => $prodi->id_prodi,
            'nama_kelas' => 'A1',
        ];

        $response = $this->post(route('kelas.store'), $data);

        $response->assertRedirect(route('kelas.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('kelas', $data);
    }

    #[Test]
    public function store_gagal_jika_kelas_sudah_ada_dalam_prodi()
    {
        $prodi = Prodi::factory()->create();
        Kelas::factory()->create([
            'id_prodi' => $prodi->id_prodi,
            'nama_kelas' => 'A1',
        ]);

        $data = [
            'id_prodi' => $prodi->id_prodi,
            'nama_kelas' => 'A1',
        ];

        $response = $this->post(route('kelas.store'), $data);

        $response->assertRedirect(route('kelas.index'));
        $response->assertSessionHas('error');
        $this->assertCount(1, Kelas::where('id_prodi', $prodi->id_prodi)->where('nama_kelas', 'A1')->get());
    }

    #[Test]
    public function update_memperbarui_data_kelas()
    {
        $prodi1 = Prodi::factory()->create();
        $prodi2 = Prodi::factory()->create();
        $kelas = Kelas::factory()->create([
            'id_prodi' => $prodi1->id_prodi,
            'nama_kelas' => 'A1',
        ]);

        $dataUpdate = [
            'id_prodi' => $prodi2->id_prodi,
            'nama_kelas' => 'B2',
        ];

        $response = $this->put(route('kelas.update', $kelas->id_kelas), $dataUpdate);

        $response->assertRedirect(route('kelas.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('kelas', [
            'id_kelas' => $kelas->id_kelas,
            'id_prodi' => $prodi2->id_prodi,
            'nama_kelas' => 'B2',
        ]);
    }

    #[Test]
    public function update_gagal_jika_nama_kelas_sudah_ada_di_prodi_lain()
    {
        $prodi = Prodi::factory()->create();
        Kelas::factory()->create([
            'id_prodi' => $prodi->id_prodi,
            'nama_kelas' => 'A1',
        ]);

        $kelasToUpdate = Kelas::factory()->create([
            'id_prodi' => $prodi->id_prodi,
            'nama_kelas' => 'B2',
        ]);

        $dataUpdate = [
            'id_prodi' => $prodi->id_prodi,
            'nama_kelas' => 'A1', // nama kelas sudah ada
        ];

        $response = $this->put(route('kelas.update', $kelasToUpdate->id_kelas), $dataUpdate);

        $response->assertRedirect(route('kelas.index'));
        $response->assertSessionHas('error');
        // Pastikan data tidak berubah
        $this->assertDatabaseHas('kelas', [
            'id_kelas' => $kelasToUpdate->id_kelas,
            'nama_kelas' => 'B2',
        ]);
    }

    #[Test]
    public function destroy_hapus_kelas_yang_tidak_terhubung()
    {
        $kelas = Kelas::factory()->create();

        $response = $this->delete(route('kelas.destroy', $kelas->id_kelas));

        $response->assertRedirect(route('kelas.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseMissing('kelas', ['id_kelas' => $kelas->id_kelas]);
    }

    // #[Test]
    // public function destroy_gagal_hapus_kelas_terhubung_dengan_mahasiswa_atau_jadwal()
    // {
    //     $kelas = Kelas::factory()->create();

    //     Mahasiswa::factory()->create(['id_kelas' => $kelas->id_kelas]);
    //     JadwalLab::factory()->create(['id_kelas' => $kelas->id_kelas]);

    //     $response = $this->delete(route('kelas.destroy', $kelas->id_kelas));

    //     $response->assertRedirect(route('kelas.index'));
    //     $response->assertSessionHas('error');
    //     $this->assertDatabaseHas('kelas', ['id_kelas' => $kelas->id_kelas]);
    // }
}
