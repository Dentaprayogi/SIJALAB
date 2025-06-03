<?php

namespace Tests\Feature;

use App\Models\Peralatan;
use App\Models\User;
use App\Models\Peminjaman;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;


class PeralatanControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $user = User::factory()->create(['role' => 'teknisi']);
        $this->actingAs($user);
    }

    #[Test]
    public function index_menampilkan_daftar_peralatan()
    {
        Peralatan::factory()->count(3)->create();

        $response = $this->get(route('peralatan.index'));

        $response->assertStatus(200);
        $response->assertViewIs('web.peralatan.index');
        $response->assertViewHas('peralatan');
    }

    #[Test]
    public function store_berhasil_menambah_peralatan()
    {
        $data = ['nama_peralatan' => 'Proyektor Epson'];

        $response = $this->post(route('peralatan.store'), $data);

        $response->assertRedirect(route('peralatan.index'));
        $this->assertDatabaseHas('peralatan', $data);
    }

    #[Test]
    public function store_gagal_jika_nama_peralatan_duplikat()
    {
        Peralatan::factory()->create(['nama_peralatan' => 'Laptop Lenovo']);

        $response = $this->post(route('peralatan.store'), ['nama_peralatan' => 'Laptop Lenovo']);

        $response->assertSessionHasErrors('nama_peralatan');
    }

    #[Test]
    public function update_berhasil_memperbarui_peralatan()
    {
        $peralatan = Peralatan::factory()->create(['nama_peralatan' => 'Router Lama']);

        $response = $this->put(route('peralatan.update', $peralatan->id_peralatan), [
            'nama_peralatan' => 'Router Baru'
        ]);

        $response->assertRedirect(route('peralatan.index'));
        $this->assertDatabaseHas('peralatan', [
            'id_peralatan' => $peralatan->id_peralatan,
            'nama_peralatan' => 'Router Baru'
        ]);
    }

    #[Test]
    public function destroy_berhasil_menghapus_peralatan_tanpa_peminjaman_aktif()
    {
        $peralatan = Peralatan::factory()->create();

        $response = $this->delete(route('peralatan.destroy', $peralatan->id_peralatan));

        $response->assertRedirect(route('peralatan.index'));
        $this->assertDatabaseMissing('peralatan', ['id_peralatan' => $peralatan->id_peralatan]);
    }

    #[Test]
    public function destroy_gagal_jika_ada_peminjaman_aktif()
    {
        $peralatan = Peralatan::factory()->create();

        // Buat peminjaman tanpa id_peralatan
        $peminjaman = Peminjaman::factory()->create([
            'status_peminjaman' => 'dipinjam'
        ]);

        // Hubungkan peminjaman dengan peralatan via tabel pivot
        $peminjaman->peralatan()->attach($peralatan->id_peralatan);

        $response = $this->delete(route('peralatan.destroy', $peralatan->id_peralatan));

        $response->assertRedirect(route('peralatan.index'));
        $response->assertSessionHas('error');
        $this->assertDatabaseHas('peralatan', ['id_peralatan' => $peralatan->id_peralatan]);
    }
}
