<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SuperAdminBarangAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_super_admin_can_access_barang_masuk_and_barang_keluar_pages(): void
    {
        $role = Role::create(['name' => 'Super Admin']);

        $user = User::factory()->create([
            'role_id' => $role->id,
        ]);

        $this->actingAs($user)
            ->get(route('barang-masuk.index'))
            ->assertOk();

        $this->actingAs($user)
            ->get(route('barang-keluar.index'))
            ->assertOk();
    }
}
