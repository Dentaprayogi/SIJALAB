<?php

namespace Tests\Feature;

use App\Models\Dosen;
use App\Models\User;
use App\Models\Prodi;
use App\Models\Kelas;
use App\Models\Hari;
use App\Models\Lab;
use App\Models\Peralatan;
use App\Models\JadwalLab;
use App\Models\Mahasiswa;
use App\Models\Matakuliah;
use App\Models\Peminjaman;
use App\Models\PeminjamanJadwal;
use App\Models\PeminjamanManual;
use App\Models\TahunAjaran;
use App\Models\UnitPeralatan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class PeminjamanControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function index_menampilkan_daftar_peminjaman_untuk_mahasiswa()
    {
        // Setup: Buat data yang diperlukan
        $prodi = Prodi::factory()->create();
        $kelas = Kelas::factory()->create(['id_prodi' => $prodi->id_prodi]);
        $user = User::factory()->create(['role' => 'mahasiswa']);
        $mahasiswa = Mahasiswa::factory()->create([
            'id' => $user->id,
            'id_prodi' => $prodi->id_prodi,
            'id_kelas' => $kelas->id_kelas,
        ]);
        $peminjaman = Peminjaman::factory()->create([
            'id' => $user->id,
            'status_peminjaman' => 'pengajuan',
        ]);

        // Aksi: Login sebagai mahasiswa dan akses route index
        $this->actingAs($user);
        $response = $this->get(route('peminjaman.index'));

        // Asersi: Pastikan response berhasil dan data ditampilkan
        $response->assertStatus(200);
        $response->assertViewIs('web.peminjaman.index');
        $response->assertViewHas('peminjamans', function ($peminjamans) use ($peminjaman) {
            return $peminjamans->contains($peminjaman);
        });
    }

    #[Test]
    public function get_available_labs_mengembalikan_lab_yang_tersedia()
    {
        $prodi = Prodi::factory()->create();
        $kelas = Kelas::factory()->create(['id_prodi' => $prodi->id_prodi]);
        $user = User::factory()->create(['role' => 'mahasiswa']);
        $mahasiswa = Mahasiswa::factory()->create([
            'id' => $user->id,
            'id_prodi' => $prodi->id_prodi,
            'id_kelas' => $kelas->id_kelas,
        ]);

        $hari = Hari::factory()->create(['nama_hari' => Carbon::now()->locale('id')->isoFormat('dddd')]);
        $lab = Lab::factory()->create(['status_lab' => 'aktif']);
        $tahunAjaran = TahunAjaran::factory()->create(['status_tahunAjaran' => 'aktif']);

        // Buat matakuliah dan dosen
        $matakuliah = Matakuliah::factory()->create();
        $dosen = Dosen::factory()->create();

        // Buat jadwal lab
        JadwalLab::factory()->create([
            'id_prodi' => $prodi->id_prodi,
            'id_hari' => $hari->id_hari,
            'id_lab' => $lab->id_lab,
            'jam_mulai' => '08:00:00',
            'jam_selesai' => '10:00:00',
            'id_mk' => $matakuliah->id_mk, // pastikan nama kolom sesuai
            'id_dosen' => $dosen->id_dosen, // pastikan nama kolom sesuai
            'id_kelas' => $kelas->id_kelas,
            'id_tahunAjaran' => $tahunAjaran->id_tahunAjaran,
            'status_jadwalLab' => 'aktif',
        ]);

        // Jalankan request sebagai mahasiswa
        $this->actingAs($user);
        $response = $this->post(route('labs.available'), [
            'jam_mulai' => '10:30',
            'jam_selesai' => '12:00',
        ]);

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'id_lab' => $lab->id_lab,
            'nama_lab' => $lab->nama_lab,
        ]);
    }

    #[Test]
    public function store_jadwal_should_create_peminjaman_jadwal()
    {
        $user = User::factory()->create(['role' => 'mahasiswa']);
        $this->actingAs($user);

        // Buat data relasi yang diperlukan
        $lab = Lab::factory()->create();
        $jadwalLab = JadwalLab::factory()->create(['id_lab' => $lab->id_lab]);

        $peralatan = Peralatan::factory()->count(2)->create();
        $peralatanIds = $peralatan->pluck('id_peralatan')->toArray();

        $response = $this->post(route('peminjaman.storeJadwal'), [
            'id_jadwalLab' => $jadwalLab->id_jadwalLab,
            'peralatan' => $peralatanIds,
        ]);

        $response->assertRedirect(route('peminjaman.index'));
        $this->assertDatabaseHas('peminjaman', [
            'status_peminjaman' => 'pengajuan',
        ]);
        $this->assertDatabaseHas('peminjaman_jadwal', [
            'id_jadwalLab' => $jadwalLab->id_jadwalLab,
        ]);
    }

    #[Test]
    public function store_manual_should_create_peminjaman_manual()
    {
        $user = User::factory()->create(['role' => 'mahasiswa']);
        $this->actingAs($user);

        $lab = Lab::factory()->create();
        $peralatan = Peralatan::factory()->count(2)->create();
        $peralatanIds = $peralatan->pluck('id_peralatan')->toArray();

        $response = $this->post(route('peminjaman.storeManual'), [
            'jam_mulai' => '10:00',
            'jam_selesai' => '12:00',
            'id_lab' => $lab->id_lab,
            'kegiatan' => 'Tes Kegiatan',
            'peralatan' => $peralatanIds,
        ]);

        $response->assertRedirect(route('peminjaman.index'));
        $this->assertDatabaseHas('peminjaman_manual', [
            'id_lab' => $lab->id_lab,
            'jam_mulai' => '10:00:00',
            'jam_selesai' => '12:00:00',
            'kegiatan' => 'Tes Kegiatan',
        ]);
    }

    #[Test]
    public function test_show_method()
    {
        $user = User::factory()->create(['role' => 'mahasiswa']);
        // Tambahkan relasi mahasiswa
        $prodi = Prodi::factory()->create();
        $kelas = Kelas::factory()->create(['id_prodi' => $prodi->id_prodi]);

        Mahasiswa::create([
            'id' => $user->id,
            'id_prodi' => $prodi->id_prodi,
            'id_kelas' => $kelas->id_kelas,
            'nim' => '361234567890',
            'telepon' => '081234567890',
            'foto_ktm' => null,
        ]);


        $peminjaman = Peminjaman::factory()->create([
            'id' => $user->id,
            'status_peminjaman' => 'pengajuan', // gunakan value yang valid sesuai enum di DB
        ]);

        // Buat Peralatan dan attach ke peminjaman
        $peralatan = Peralatan::factory()->create([
            'nama_peralatan' => 'LCD',
        ]);
        $peminjaman->peralatan()->attach($peralatan->id_peralatan);

        // Buat UnitPeralatan dan attach ke peminjaman
        $unitPeralatan = UnitPeralatan::factory()->create([
            'id_peralatan' => $peralatan->id_peralatan,
            'status_unit' => 'tersedia',
            'kode_unit' => 'UNIT-001',
        ]);
        $peminjaman->unitPeralatan()->attach($unitPeralatan->id_unit);

        // Buat jadwal lab yang akan terhubung melalui PeminjamanJadwal
        $jadwalLab = JadwalLab::factory()->create(); // Biarkan auto-generate id_jadwalLab

        $peminjamanJadwal = PeminjamanJadwal::factory()->create([
            'id_peminjaman' => $peminjaman->id_peminjaman,
            'id_jadwalLab' => $jadwalLab->id_jadwalLab, // relasi foreign key
        ]);

        // Jalankan test pada route show
        $this->actingAs($user)
            ->get(route('peminjaman.show', $peminjaman->id_peminjaman))
            ->assertStatus(200)
            ->assertViewIs('web.peminjaman.show')
            ->assertViewHas('peminjaman');
    }

    #[Test]
    public function test_setujui_method()
    {
        $peminjaman = Peminjaman::factory()->create([
            'status_peminjaman' => 'pengajuan'
        ]);

        $user = User::factory()->create(['role' => 'teknisi']);

        $this->actingAs($user)
            ->put(route('peminjaman.setujui', $peminjaman->id_peminjaman))
            ->assertRedirect(route('peminjaman.show', $peminjaman->id_peminjaman)); // pastikan route benar

        $peminjaman->refresh(); // ambil ulang dari DB

        $this->assertEquals('dipinjam', $peminjaman->status_peminjaman); // opsional tambahan
        $this->assertDatabaseHas('peminjaman', [
            'id_peminjaman' => $peminjaman->id_peminjaman,
            'status_peminjaman' => 'dipinjam',
        ]);
    }

    #[Test]
    public function test_bermasalah_method()
    {
        $peminjaman = Peminjaman::factory()->create([
            'status_peminjaman' => 'dipinjam'
        ]);

        $this->actingAs(User::factory()->create(['role' => 'teknisi']))
            ->put(route('peminjaman.bermasalah', $peminjaman->id_peminjaman), [
                'alasan_bermasalah' => 'Kerusakan alat',
            ]);

        $this->assertDatabaseHas('peminjaman', [
            'id_peminjaman' => $peminjaman->id_peminjaman,
            'status_peminjaman' => 'bermasalah',
        ]);

        $this->assertDatabaseHas('peminjaman_bermasalah', [
            'id_peminjaman' => $peminjaman->id_peminjaman,
            'alasan_bermasalah' => 'Kerusakan alat',
        ]);
    }

    #[Test]
    public function test_selesai_method()
    {
        $peminjaman = Peminjaman::factory()->create();

        $this->actingAs(User::factory()->create(['role' => 'teknisi']))
            ->put(route('peminjaman.selesai', $peminjaman->id_peminjaman));

        $this->assertDatabaseHas('peminjaman', [
            'id_peminjaman' => $peminjaman->id_peminjaman,
            'status_peminjaman' => 'selesai',
        ]);

        $this->assertDatabaseHas('peminjaman_selesai', [
            'id_peminjaman' => $peminjaman->id_peminjaman,
        ]);
    }

    #[Test]
    public function test_tolak_method()
    {
        $peminjaman = Peminjaman::factory()->create();

        $this->actingAs(User::factory()->create(['role' => 'teknisi']))
            ->put(route('peminjaman.tolak', $peminjaman->id_peminjaman), [
                'alasan_ditolak' => 'Data tidak lengkap'
            ]);

        $this->assertDatabaseHas('peminjaman', [
            'id_peminjaman' => $peminjaman->id_peminjaman,
            'status_peminjaman' => 'ditolak',
        ]);

        $this->assertDatabaseHas('peminjaman_ditolak', [
            'id_peminjaman' => $peminjaman->id_peminjaman,
            'alasan_ditolak' => 'Data tidak lengkap',
        ]);
    }

    #[Test]
    public function test_destroy_method_as_mahasiswa()
    {
        $user = User::factory()->create(['role' => 'mahasiswa']);
        $peminjaman = Peminjaman::factory()->create([
            'status_peminjaman' => 'pengajuan'
        ]);

        $this->actingAs($user)
            ->delete(route('peminjaman.destroy', $peminjaman->id_peminjaman))
            ->assertSessionHas('success');

        $this->assertDatabaseMissing('peminjaman', ['id_peminjaman' => $peminjaman->id_peminjaman]);
    }

    #[Test]
    public function test_bulkDelete_method()
    {
        $user = User::factory()->create(['role' => 'teknisi']);
        $p1 = Peminjaman::factory()->create(['status_peminjaman' => 'selesai']);
        $p2 = Peminjaman::factory()->create(['status_peminjaman' => 'bermasalah']);
        $p3 = Peminjaman::factory()->create(['status_peminjaman' => 'ditolak']); // Should not be deleted

        $this->actingAs($user)
            ->delete(route('peminjaman.bulkDelete'), [
                'selected_ids' => implode(',', [$p1->id_peminjaman, $p2->id_peminjaman, $p3->id_peminjaman])
            ])
            ->assertSessionHas('success');

        $this->assertDatabaseMissing('peminjaman', ['id_peminjaman' => $p1->id_peminjaman]);
        $this->assertDatabaseMissing('peminjaman', ['id_peminjaman' => $p2->id_peminjaman]);
        $this->assertDatabaseMissing('peminjaman', ['id_peminjaman' => $p3->id_peminjaman]);
    }
}
