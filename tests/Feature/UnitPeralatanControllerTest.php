<?php

namespace Tests\Feature;

use App\Models\Peralatan;
use App\Models\UnitPeralatan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class UnitPeralatanControllerTest extends TestCase
{
    use RefreshDatabase;

    private function actingAsAdmin()
    {
        $user = User::factory()->create(['role' => 'teknisi']);
        $this->actingAs($user);
    }

    #[Test]
    public function index_menampilkan_halaman_dan_data_unit_peralatan()
    {
        $this->actingAsAdmin();

        $peralatan = Peralatan::factory()->create();
        UnitPeralatan::factory()->create([
            'id_peralatan' => $peralatan->id_peralatan,
            'kode_unit' => 'UNIT-001',
        ]);

        $response = $this->get(route('unit-peralatan.index'));

        $response->assertStatus(200);
        $response->assertSee('UNIT-001');
    }

    #[Test]
    public function store_menyimpan_unit_peralatan_baru()
    {
        $this->actingAsAdmin();

        $peralatan = Peralatan::factory()->create();

        $response = $this->post(route('unit-peralatan.store'), [
            'id_peralatan' => $peralatan->id_peralatan,
            'kode_unit' => 'UNIT-002',
        ]);

        $response->assertRedirect(route('unit-peralatan.index'));
        $this->assertDatabaseHas('unit_peralatan', [
            'kode_unit' => 'UNIT-002',
            'id_peralatan' => $peralatan->id_peralatan,
        ]);
    }

    #[Test]
    public function update_memperbarui_unit_peralatan()
    {
        $this->actingAsAdmin();

        $peralatan = Peralatan::factory()->create();
        $unit = UnitPeralatan::factory()->create([
            'id_peralatan' => $peralatan->id_peralatan,
            'kode_unit' => 'UNIT-003',
            'status_unit' => 'tersedia',
        ]);

        $response = $this->put(route('unit-peralatan.update', $unit->id_unit), [
            'id_peralatan' => $peralatan->id_peralatan,
            'kode_unit' => 'UNIT-003-UPDATED',
            'status_unit' => 'rusak',
        ]);

        $response->assertRedirect(route('unit-peralatan.index'));
        $this->assertDatabaseHas('unit_peralatan', [
            'id_unit' => $unit->id_unit,
            'kode_unit' => 'UNIT-003-UPDATED',
            'status_unit' => 'rusak',
        ]);
    }

    #[Test]
    public function destroy_menghapus_unit_peralatan()
    {
        $this->actingAsAdmin();

        $unit = UnitPeralatan::factory()->create();

        $response = $this->delete(route('unit-peralatan.destroy', $unit->id_unit));

        $response->assertRedirect(route('unit-peralatan.index'));
        $this->assertDatabaseMissing('unit_peralatan', [
            'id_unit' => $unit->id_unit,
        ]);
    }
}
