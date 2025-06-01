<?php

namespace Tests\Feature;

use App\Models\Matakuliah;
use App\Models\Prodi;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MatakuliahControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $user = User::factory()->create(['role' => 'teknisi']);
        $this->actingAs($user);
    }

    public function test_menampilkan_halamn_daftar_matakuliah()
    {
        $prodi = Prodi::factory()->create();
        $matakuliah = Matakuliah::factory()->create(['id_prodi' => $prodi->id_prodi]);

        $response = $this->get(route('matakuliah.index'));

        $response->assertStatus(200);
        $response->assertViewIs('web.matakuliah.index');
        $response->assertViewHas('matakuliah');
        $response->assertViewHas('prodi');
        $this->assertTrue($response->original->getData()['matakuliah']->contains($matakuliah));
    }

    public function test_menambah_mata_kuliah_dengan_data_yang_valid()
    {
        $prodi = Prodi::factory()->create();

        $response = $this->post(route('matakuliah.store'), [
            'id_prodi' => $prodi->id_prodi,
            'nama_mk' => 'Matakuliah Baru',
        ]);

        $response->assertRedirect(route('matakuliah.index'));
        $response->assertSessionHas('success', 'Matakuliah berhasil ditambahkan!');
        $this->assertDatabaseHas('matakuliah', [
            'id_prodi' => $prodi->id_prodi,
            'nama_mk' => 'Matakuliah Baru',
        ]);
    }

    public function test_menambah_matata_kuliah_yang_sama_gagal()
    {
        $prodi = Prodi::factory()->create();
        Matakuliah::factory()->create([
            'id_prodi' => $prodi->id_prodi,
            'nama_mk' => 'Matakuliah Sama',
        ]);

        $response = $this->post(route('matakuliah.store'), [
            'id_prodi' => $prodi->id_prodi,
            'nama_mk' => 'Matakuliah Sama',
        ]);

        $response->assertRedirect(route('matakuliah.index'));
        $response->assertSessionHas('error', 'Matakuliah dengan nama yang sama sudah ada dalam prodi ini!');
    }

    public function test_update_mata_kuliah_dengan_data_valid()
    {
        $prodi = Prodi::factory()->create();
        $matakuliah = Matakuliah::factory()->create([
            'id_prodi' => $prodi->id_prodi,
            'nama_mk' => 'Matakuliah Lama',
        ]);

        $response = $this->put(route('matakuliah.update', $matakuliah->id_mk), [
            'id_prodi' => $prodi->id_prodi,
            'nama_mk' => 'Matakuliah Baru',
        ]);

        $response->assertRedirect(route('matakuliah.index'));
        $response->assertSessionHas('success', 'Mata Kuliah berhasil diperbarui!');

        $this->assertDatabaseHas('matakuliah', [
            'id_mk' => $matakuliah->id_mk,
            'nama_mk' => 'Matakuliah Baru',
        ]);
    }

    public function test_update_mata_kuliah_dengan_data_yang_sama_gagal()
    {
        $prodi = Prodi::factory()->create();
        $matakuliah1 = Matakuliah::factory()->create([
            'id_prodi' => $prodi->id_prodi,
            'nama_mk' => 'Matakuliah 1',
        ]);
        $matakuliah2 = Matakuliah::factory()->create([
            'id_prodi' => $prodi->id_prodi,
            'nama_mk' => 'Matakuliah 2',
        ]);

        $response = $this->put(route('matakuliah.update', $matakuliah2->id_mk), [
            'id_prodi' => $prodi->id_prodi,
            'nama_mk' => 'Matakuliah 1',
        ]);

        $response->assertRedirect(route('matakuliah.index'));
        $response->assertSessionHas('error', 'Mata Kuliah yang sama sudah ada dalam prodi ini!');
    }

    public function test_hapus_mata_kuliah_yang_tidak_terkait_di_jadwal_lab()
    {
        $matakuliah = Matakuliah::factory()->create();

        // Pastikan jadwalLab kosong
        $this->assertFalse($matakuliah->jadwalLab()->exists());

        $response = $this->delete(route('matakuliah.destroy', $matakuliah->id_mk));

        $response->assertRedirect(route('matakuliah.index'));
        $response->assertSessionHas('success', 'Mata Kuliah berhasil dihapus!');
        $this->assertDatabaseMissing('matakuliah', ['id_mk' => $matakuliah->id_mk]);
    }

    // public function test_hapus_mata_kuliah_yang_terkait_dengan_jadwal_lab_gagal()
    // {
    //     $matakuliah = Matakuliah::factory()->create();

    //     // Mock jadwalLab exists to true
    //     $this->partialMock(\App\Models\Matakuliah::class, function ($mock) use ($matakuliah) {
    //         $mock->shouldReceive('findOrFail')->andReturn($matakuliah);
    //         $mock->shouldReceive('jadwalLab->exists')->andReturn(true);
    //     });

    //     // Karena jadwalLab exists true, harus redirect dengan error
    //     $response = $this->delete(route('matakuliah.destroy', $matakuliah->id_mk));

    //     $response->assertRedirect(route('matakuliah.index'));
    //     $response->assertSessionHas('error', 'Mata Kuliah tidak dapat dihapus karena masih memiliki jadwal lab yang terkait.');
    // }
}
