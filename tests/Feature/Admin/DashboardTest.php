<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Database\Seeders\DepartmentSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * 管理者ダッシュボード結合テスト
 */
class DashboardTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed([
            DepartmentSeeder::class,
            UserSeeder::class,
        ]);

        /** @var User */
        $adminUser = User::where('is_admin', true)->first();
        $this->actingAs($adminUser);
    }

    public function test_index(): void
    {
        /** @var User */
        $adminUser = User::where('is_admin', true)->first();
        $this->actingAs($adminUser);

        $response = $this->get(route('admin.dashboard'));
        $response->assertStatus(200);
    }

    public function test_index_non_admin_user(): void
    {
        /** @var User */
        $user = User::where('is_admin', false)->first();
        $this->actingAs($user);

        $response = $this->get(route('admin.dashboard'));
        $response->assertStatus(403);
    }
}
