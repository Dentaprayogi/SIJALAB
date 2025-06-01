<?php

namespace Tests\Feature;

use App\Models\Dosen;
use App\Models\Prodi;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class DosenControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $user = User::factory()->create(['role' => 'teknisi']);
        $this->actingAs($user);
    }

    #[Test]
    public function index_menampilkan_halaman_daftar_dosen()
    {
        $prodi = Prodi::factory()->create();
        Dosen::factory()->count(3)->create(['id_prodi' => $prodi->id_prodi]);

        $response = $this->get(route('dosen.index'));

        $response->assertStatus(200);
        $response->assertViewIs('web.dosen.index');
        $response->assertViewHas(['dosens', 'prodi']);
    }

    #[Test]
    public function store_menambah_data_dosen_baru()
    {
        $prodi = Prodi::factory()->create();

        $data = [
            'nama_dosen' => 'Budi Santoso',
            'telepon' => '08123456789',
            'id_prodi' => $prodi->id_prodi,
        ];

        $response = $this->post(route('dosen.store'), $data);

        $response->assertRedirect(route('dosen.index'));
        $this->assertDatabaseHas('dosen', ['nama_dosen' => 'Budi Santoso']);
    }

    #[Test]
    public function validasi_unik_nama_dosen()
    {
        $prodi = Prodi::factory()->create();
        Dosen::factory()->create([
            'nama_dosen' => 'Budi Santoso',
            'id_prodi' => $prodi->id_prodi
        ]);

        $data = [
            'nama_dosen' => 'Budi Santoso',
            'telepon' => '08123456789',
            'id_prodi' => $prodi->id_prodi,
        ];

        $response = $this->post(route('dosen.store'), $data);

        $response->assertSessionHasErrors('nama_dosen');
    }

    #[Test]
    public function update_dosen()
    {
        $prodi = Prodi::factory()->create();
        $dosen = Dosen::factory()->create(['id_prodi' => $prodi->id_prodi]);

        $data = [
            'nama_dosen' => 'Agus Raharjo',
            'telepon' => '089999999',
            'id_prodi' => $prodi->id_prodi,
        ];

        $response = $this->put(route('dosen.update', $dosen->id_dosen), $data);

        $response->assertRedirect(route('dosen.index'));
        $this->assertDatabaseHas('dosen', ['nama_dosen' => 'Agus Raharjo']);
    }

    #[Test]
    public function delete_hapus_dosen()
    {
        $prodi = Prodi::factory()->create();
        $dosen = Dosen::factory()->create(['id_prodi' => $prodi->id_prodi]);

        $response = $this->delete(route('dosen.destroy', $dosen->id_dosen));

        $response->assertRedirect(route('dosen.index'));
        $this->assertDatabaseMissing('dosen', ['id_dosen' => $dosen->id_dosen]);
    }
}
