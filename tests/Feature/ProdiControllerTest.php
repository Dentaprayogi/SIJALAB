<?php

namespace Tests\Feature;

use App\Models\Prodi;
use App\Models\Kelas;
use App\Models\Mahasiswa;
use App\Models\Dosen;
use App\Models\JadwalLab;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ProdiControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $user = User::factory()->create(['role' => 'teknisi']);
        $this->actingAs($user);
    }

    #[Test]
    public function index_menampilkan_daftar_prodi()
    {
        Prodi::factory()->count(3)->create();

        $response = $this->get(route('prodi.index'));

        $response->assertStatus(200);
        $response->assertViewIs('web.prodi.index');
        $response->assertViewHas('prodi');
    }

    #[Test]
    public function store_menambahkan_prodi_baru()
    {
        $data = [
            'nama_prodi' => 'Teknik Informatika',
            'singkatan_prodi' => 'TI',
        ];

        $response = $this->post(route('prodi.store'), $data);

        $response->assertRedirect(route('prodi.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('prodi', $data);
    }

    #[Test]
    public function update_memperbarui_data_prodi()
    {
        $prodi = Prodi::factory()->create([
            'nama_prodi' => 'Teknik Mesin',
            'singkatan_prodi' => 'TM',
        ]);

        $dataUpdate = [
            'nama_prodi' => 'Teknik Sipil',
            'singkatan_prodi' => 'TS',
        ];

        $response = $this->put(route('prodi.update', $prodi->id_prodi), $dataUpdate);

        $response->assertRedirect(route('prodi.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('prodi', [
            'id_prodi' => $prodi->id_prodi,
            'nama_prodi' => 'Teknik Sipil',
            'singkatan_prodi' => 'TS',
        ]);
    }

    #[Test]
    public function destroy_hapus_prodi_yang_tidak_terhubung()
    {
        $prodi = Prodi::factory()->create();

        $response = $this->delete(route('prodi.destroy', $prodi->id_prodi));

        $response->assertRedirect(route('prodi.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseMissing('prodi', ['id_prodi' => $prodi->id_prodi]);
    }

    #[Test]
    public function destroy_gagal_hapus_prodi_terhubung_dengan_data_lain()
    {
        $prodi = Prodi::factory()->create();

        // Membuat relasi dummy dengan model terkait
        Kelas::factory()->create(['id_prodi' => $prodi->id_prodi]);
        Mahasiswa::factory()->create(['id_prodi' => $prodi->id_prodi]);
        Dosen::factory()->create(['id_prodi' => $prodi->id_prodi]);
        JadwalLab::factory()->create(['id_prodi' => $prodi->id_prodi]);

        $response = $this->delete(route('prodi.destroy', $prodi->id_prodi));

        $response->assertRedirect(route('prodi.index'));
        $response->assertSessionHas('error');

        $this->assertDatabaseHas('prodi', ['id_prodi' => $prodi->id_prodi]);
    }
}
