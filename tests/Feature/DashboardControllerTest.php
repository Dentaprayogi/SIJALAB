<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Lab;
use App\Models\Hari;
use App\Models\JadwalLab;
use App\Models\PeminjamanJadwal;
use App\Models\PeminjamanManual;
use App\Models\Peminjaman;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Carbon\Carbon;

class DashboardControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create(['role' => 'teknisi']);
        $this->actingAs($user);

        // Atur tanggal sekarang agar predictable
        Carbon::setTestNow(Carbon::parse('2025-06-02 10:00:00')); // Senin, 10:00
    }

    public function test_index_menampilkan_view_dengan_data_labs()
    {
        // Tambahkan data hari yang sesuai dengan hari saat ini
        Hari::factory()->create([
            'nama_hari' => ucfirst(now()->locale('id')->isoFormat('dddd'))
        ]);

        // Buat lab aktif dan nonaktif
        $labAktif = Lab::factory()->create(['status_lab' => 'aktif']);
        $labNonaktif = Lab::factory()->create(['status_lab' => 'nonaktif']);

        $response = $this->get(route('dashboard'));

        $response->assertStatus(200);
        $response->assertViewIs('web.dashboard.index');
        $response->assertViewHas('labs');

        $labs = $response->viewData('labs');

        $this->assertCount(2, $labs);

        $this->assertEquals('Nonaktif', $labs->firstWhere('id_lab', $labNonaktif->id_lab)->status);
        $this->assertEquals('Kosong', $labs->firstWhere('id_lab', $labAktif->id_lab)->status);
    }

    public function test_lab_dengan_peminjaman_dipinjam_akan_berstatus_dipinjam()
    {
        $hari = Hari::firstOrCreate(
            ['nama_hari' => 'Senin'],
            ['created_at' => now(), 'updated_at' => now()]
        );

        $lab = Lab::factory()->create(['status_lab' => 'aktif']);

        $jadwal = JadwalLab::factory()->create([
            'id_lab' => $lab->id_lab,
            'id_hari' => $hari->id_hari,
            'jam_mulai' => '09:00:00',
            'jam_selesai' => '11:00:00',
            'status_jadwalLab' => 'aktif',
        ]);

        $peminjaman = Peminjaman::factory()->create([
            'status_peminjaman' => 'dipinjam',
            'tgl_peminjaman' => Carbon::today(),
        ]);

        PeminjamanJadwal::factory()->create([
            'id_peminjaman' => $peminjaman->id_peminjaman,
            'id_jadwalLab' => $jadwal->id_jadwalLab,
        ]);

        $response = $this->get(route('dashboard'));

        $labs = $response->viewData('labs');
        $this->assertEquals('Dipinjam', $labs->firstWhere('id_lab', $lab->id_lab)->status);
    }


    public function test_lab_dengan_peminjaman_pengajuan_akan_berstatus_pengajuan()
    {
        $hari = Hari::firstOrCreate(
            ['nama_hari' => 'Senin'],
            ['created_at' => now(), 'updated_at' => now()]
        );

        $lab = Lab::factory()->create(['status_lab' => 'aktif']);

        $jadwal = JadwalLab::factory()->create([
            'id_lab' => $lab->id_lab,
            'id_hari' => $hari->id_hari,
            'jam_mulai' => '09:00:00',
            'jam_selesai' => '11:00:00',
            'status_jadwalLab' => 'aktif',
        ]);

        $peminjaman = Peminjaman::factory()->create([
            'status_peminjaman' => 'pengajuan',
            'tgl_peminjaman' => Carbon::today(),
        ]);

        PeminjamanJadwal::factory()->create([
            'id_peminjaman' => $peminjaman->id_peminjaman,
            'id_jadwalLab' => $jadwal->id_jadwalLab,
        ]);

        $response = $this->get(route('dashboard'));

        $labs = $response->viewData('labs');
        $this->assertEquals('Pengajuan', $labs->firstWhere('id_lab', $lab->id_lab)->status);
    }

    public function test_lab_dengan_jadwal_aktif_akan_berstatus_tersedia()
    {
        $hari = Hari::firstOrCreate(
            ['nama_hari' => 'Senin'],
            ['created_at' => now(), 'updated_at' => now()]
        );

        $lab = Lab::factory()->create(['status_lab' => 'aktif']);

        JadwalLab::factory()->create([
            'id_lab' => $lab->id_lab,
            'id_hari' => $hari->id_hari,
            'jam_mulai' => '09:00:00',
            'jam_selesai' => '11:00:00',
            'status_jadwalLab' => 'aktif',
        ]);

        $response = $this->get(route('dashboard'));

        $labs = $response->viewData('labs');
        $this->assertEquals('Tersedia', $labs->firstWhere('id_lab', $lab->id_lab)->status);
    }
}
