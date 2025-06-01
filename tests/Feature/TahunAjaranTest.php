<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\TahunAjaran;
use App\Models\JadwalLab;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TahunAjaranTest extends TestCase
{
    use RefreshDatabase;

    public function test_menampilkan_index_tahun_ajaran(): void
    {

        // $user = User::factory()->create([
        //     'status' => 'aktif',
        //     'role' => 'admin', // sesuaikan dengan kebutuhan aplikasimu
        // ]);
        // $this->actingAs($user);

        $user = User::factory()->create();
        $this->actingAs($user);

        TahunAjaran::factory()->count(3)->create();

        $response = $this->get('/tahunajaran');

        $response->assertStatus(200);
        $response->assertSee('Tahun Ajaran');
    }

    public function test_store_tahun_ajaran_baru()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $data = [
            'tahun_ajaran' => '2024/2025',
            'semester' => 'ganjil',
        ];

        $response = $this->post(route('tahunajaran.store'), $data);

        $response->assertRedirect(route('tahunajaran.index'));

        $this->assertDatabaseHas('tahun_ajaran', $data);
    }

    public function test_store_tahun_ajaran_baru_gagal_jika_kombinasi_duplikat()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        TahunAjaran::factory()->create([
            'tahun_ajaran' => '2024/2025',
            'semester' => 'ganjil',
        ]);

        $response = $this->post(route('tahunajaran.store'), [
            'tahun_ajaran' => '2024/2025',
            'semester' => 'ganjil',
        ]);

        $response->assertSessionHas('error');
    }

    public function test_update_tahun_ajaran()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $tahun = TahunAjaran::factory()->create([
            'tahun_ajaran' => '2023/2024',
            'semester' => 'genap',
            'status_tahunAjaran' => 'nonaktif',
        ]);

        $response = $this->put(route('tahunajaran.update', $tahun->id_tahunAjaran), [
            'tahun_ajaran' => '2024/2025',
            'semester' => 'ganjil',
            'status_tahunAjaran' => 'aktif',
        ]);

        $response->assertRedirect(route('tahunajaran.index'));

        $this->assertDatabaseHas('tahun_ajaran', [
            'id_tahunAjaran' => $tahun->id_tahunAjaran,
            'tahun_ajaran' => '2024/2025',
            'semester' => 'ganjil',
            'status_tahunAjaran' => 'aktif',
        ]);
    }

    public function test_hapus_tahun_ajaran_yang_tidak_terkait_dengan_jadwal()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $tahun = TahunAjaran::factory()->create();

        $response = $this->delete(route('tahunajaran.destroy', $tahun->id_tahunAjaran));

        $response->assertRedirect(route('tahunajaran.index'));
        $this->assertDatabaseMissing('tahun_ajaran', [
            'id_tahunAjaran' => $tahun->id_tahunAjaran
        ]);
    }

    // public function test_hapus_tahun_ajaran_gagal_jika_terkait_dengan_jadwal()
    // {
    //     $user = User::factory()->create();
    //     $this->actingAs($user);

    //     $tahun = TahunAjaran::factory()->create();
    //     JadwalLab::factory()->create(['id_tahunAjaran' => $tahun->id_tahunAjaran]);

    //     $response = $this->delete(route('tahunajaran.destroy', $tahun->id_tahunAjaran));

    //     $response->assertRedirect(route('tahunajaran.index'));
    //     $response->assertSessionHas('error');
    //     $this->assertDatabaseHas('tahun_ajaran', [
    //         'id_tahunAjaran' => $tahun->id_tahunAjaran
    //     ]);
    // }

    public function test_toggle_status_berhasil_mengubah_status()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $tahun = TahunAjaran::factory()->create(['status_tahunAjaran' => 'nonaktif']);

        $response = $this->patch(route('tahunajaran.toggleStatus', $tahun->id_tahunAjaran), [
            'status_tahunAjaran' => 'aktif',
        ]);

        $response->assertStatus(200);
        $response->assertJson(['message' => 'Status tahun ajaran berhasil diubah.']);

        $this->assertDatabaseHas('tahun_ajaran', [
            'id_tahunAjaran' => $tahun->id_tahunAjaran,
            'status_tahunAjaran' => 'aktif',
        ]);
    }

    public function test_toggle_status_gagal_dengan_nilai_tidak_valid()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $tahun = TahunAjaran::factory()->create();

        $response = $this->patch(route('tahunajaran.toggleStatus', $tahun->id_tahunAjaran), [
            'status_tahunAjaran' => 'invalid',
        ]);

        $response->assertStatus(422);
        $response->assertJson(['message' => 'Status tidak valid.']);
    }
}
