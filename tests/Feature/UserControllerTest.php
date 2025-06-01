<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function menampilkan_halaman_daftar_user()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get(route('users.index'));

        $response->assertStatus(200);
        $response->assertViewIs('web.user.index');
        $response->assertViewHas('users');
    }

    #[Test]
    public function menampilkan_halaman_detaik_user()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $targetUser = User::factory()->create();

        $response = $this->get(route('users.show', $targetUser->id));

        $response->assertStatus(200);
        $response->assertViewIs('web.user.show');
        $response->assertViewHas('user', $targetUser);
    }

    #[Test]
    public function toggle_status_user_berhasil()
    {
        $user = User::factory()->create(['role' => 'teknisi']);
        $this->actingAs($user);

        $targetUser = User::factory()->create([
            'status_user' => 'nonaktif',
            'role' => 'mahasiswa'
        ]);

        $response = $this->patch("/users/{$targetUser->id}/toggle-status", [
            'status_user' => 'aktif',
        ]);

        $response->assertStatus(200);
        $response->assertJson(['message' => 'Status user berhasil diubah']);

        $this->assertDatabaseHas('users', [
            'id' => $targetUser->id,
            'status_user' => 'aktif',
        ]);
    }

    #[Test]
    public function toggle_status_user_role_teknisi_dilarang()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $teknisi = User::factory()->create(['role' => 'teknisi']);

        $response = $this->patch("/users/{$teknisi->id}/toggle-status", [
            'status_user' => 'nonaktif',
        ]);

        $response->assertStatus(403);
        $response->assertJson(['message' => 'User teknisi tidak boleh diubah statusnya.']);
    }

    #[Test]
    public function hapus_user()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $targetUser = User::factory()->create(['role' => 'mahasiswa']);

        $response = $this->delete(route('users.destroy', $targetUser->id));

        $response->assertRedirect(route('users.index'));
        $this->assertDatabaseMissing('users', ['id' => $targetUser->id]);
    }

    #[Test]
    public function hapus_user_gagal_saat_role_teknisi()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $teknisi = User::factory()->create(['role' => 'teknisi']);

        $response = $this->delete(route('users.destroy', $teknisi->id));

        $response->assertRedirect();
        $response->assertSessionHas('error', 'User dengan role teknisi tidak boleh dihapus.');
    }

    #[Test]
    public function penghapusan_massal_hanya_menghapus_pengguna_yang_valid()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $user1 = User::factory()->create(['role' => 'mahasiswa']);
        $user2 = User::factory()->create(['role' => 'mahasiswa']);
        $user3 = User::factory()->create(['role' => 'teknisi']);

        $response = $this->delete(route('users.bulkDelete'), [
            'selected_ids' => [$user1->id, $user2->id, $user3->id],
        ]);

        $response->assertRedirect(route('users.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseMissing('users', ['id' => $user1->id]);
        $this->assertDatabaseMissing('users', ['id' => $user2->id]);
        $this->assertDatabaseHas('users', ['id' => $user3->id]); // teknisi tidak boleh dihapus
    }
}
