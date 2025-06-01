<?php

namespace Tests\Feature;

use App\Models\Lab;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LabControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function login()
    {
        $user = User::factory()->create(); // pastikan model User dan autentikasi sudah berjalan
        $this->actingAs($user);
    }

    public function test_index_menampilkan_halaman_daftar_lab()
    {
        $this->login();
        $response = $this->get(route('lab.index'));
        $response->assertStatus(200);
        $response->assertViewIs('web.lab.index');
    }

    public function test_create_menampilkan_form_tambah_lab()
    {
        $this->login();
        $response = $this->get(route('lab.create'));
        $response->assertStatus(200);
        $response->assertViewIs('web.lab.create');
    }

    public function test_store_menyimpan_data_lab_baru()
    {
        $this->login();
        $response = $this->post(route('lab.store'), [
            'nama_lab' => 'Lab Komputer 1',
        ]);

        $response->assertRedirect(route('lab.index'));
        $this->assertDatabaseHas('lab', [
            'nama_lab' => 'Lab Komputer 1',
            'status_lab' => 'aktif',
        ]);
    }

    public function test_edit_menampilkan_form_edit_lab()
    {
        $this->login();
        $lab = Lab::create(['nama_lab' => 'Lab 1', 'status_lab' => 'aktif']);

        $response = $this->get(route('lab.edit', $lab->id_lab));
        $response->assertStatus(200);
        $response->assertViewIs('web.lab.edit');
        $response->assertViewHas('lab', $lab);
    }

    public function test_update_memperbarui_data_lab()
    {
        $this->login();
        $lab = Lab::create(['nama_lab' => 'Lab Lama', 'status_lab' => 'aktif']);

        $response = $this->put(route('lab.update', $lab->id_lab), [
            'nama_lab' => 'Lab Baru',
            'status_lab' => 'aktif',
        ]);

        $response->assertRedirect(route('lab.index'));
        $this->assertDatabaseHas('lab', [
            'id_lab' => $lab->id_lab,
            'nama_lab' => 'Lab Baru',
        ]);
    }

    public function test_destroy_menghapus_lab_yang_tidak_terhubung()
    {
        $this->login();
        $lab = Lab::create(['nama_lab' => 'Lab Hapus', 'status_lab' => 'aktif']);

        $response = $this->delete(route('lab.destroy', $lab->id_lab));
        $response->assertRedirect(route('lab.index'));
        $this->assertDatabaseMissing('lab', ['id_lab' => $lab->id_lab]);
    }

    public function test_toggle_status_mengubah_status_lab_ke_nonaktif()
    {
        $this->login();
        $lab = Lab::create(['nama_lab' => 'Lab Uji', 'status_lab' => 'aktif']);

        $response = $this->patch(route('lab.toggleStatus', $lab->id_lab), [
            'status_lab' => 'nonaktif',
        ]);

        $response->assertJson(['message' => 'Status lab berhasil diubah.']);
        $this->assertDatabaseHas('lab', [
            'id_lab' => $lab->id_lab,
            'status_lab' => 'nonaktif',
        ]);
    }
}
