<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Jetstream\Features;
use Laravel\Jetstream\Http\Livewire\DeleteUserForm;
use Livewire\Livewire;
use Tests\TestCase;

class DeleteAccountTest extends TestCase
{
    use RefreshDatabase;

    public function test_akun_user_dapat_dihapus(): void
    {
        if (! Features::hasAccountDeletionFeatures()) {
            $this->markTestSkipped('Account deletion is not enabled.');
        }

        $this->actingAs($user = User::factory()->create());

        $component = Livewire::test(DeleteUserForm::class)
            ->set('password', 'password')
            ->call('deleteUser');

        $this->assertNull($user->fresh());
    }

    // public function test_kata_sandi_harus_diberikan_sebelum_akun_terhapus(): void
    // {
    //     if (! Features::hasAccountDeletionFeatures()) {
    //         $this->markTestSkipped('Account deletion is not enabled.');
    //     }

    //     $this->actingAs($user = User::factory()->create());

    //     Livewire::test(DeleteUserForm::class)
    //         ->set('password', 'wrong-password')
    //         ->call('deleteUser')
    //         ->assertHasErrors(['password']);

    //     $this->assertNotNull($user->fresh());
    // }
}
