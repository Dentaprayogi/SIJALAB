<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Laravel\Fortify\Features;
use Laravel\Jetstream\Jetstream;
use Tests\TestCase;
use App\Models\Prodi;
use App\Models\Kelas;
use App\Models\Mahasiswa;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_form_registrasi_dapat_ditampilkan(): void
    {
        if (! Features::enabled(Features::registration())) {
            $this->markTestSkipped('Registration support is not enabled.');
        }

        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function test_rigister_user_baru(): void
    {
        if (! Features::enabled(Features::registration())) {
            $this->markTestSkipped('Registration support is not enabled.');
        }

        Storage::fake('public');

        // Buat data prodi dan kelas yang dibutuhkan
        $prodi = Prodi::factory()->create();
        $kelas = Kelas::factory()->create();

        $response = $this->post('/register', [
            'name' => 'Mahasiswa Test',
            'email' => 'mahasiswa@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'nim' => '361234567890',
            'telepon' => '08987654321',
            'id_prodi' => $prodi->id_prodi,
            'id_kelas' => $kelas->id_kelas,
            'terms' => true,
            'foto_ktm' => UploadedFile::fake()->image('ktm.jpg'),
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('dashboard', absolute: false));

        // Verifikasi data masuk ke tabel
        $this->assertDatabaseHas('users', [
            'email' => 'mahasiswa@example.com',
            'role' => 'mahasiswa',
        ]);

        $this->assertDatabaseHas('mahasiswa', [
            'nim' => '361234567890',
            'telepon' => '08987654321',
            'id_prodi' => $prodi->id_prodi,
            'id_kelas' => $kelas->id_kelas,
        ]);

        // Verifikasi file terupload
        $fotoPath = Mahasiswa::first()->foto_ktm;
        $this->assertTrue(Storage::disk('public')->exists($fotoPath));
    }
}
