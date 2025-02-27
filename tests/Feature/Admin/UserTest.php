<?php

namespace Tests\Feature\Admin;

use App\Domain\User\UserRepositoryInterface;
use App\Models\User;
use Database\Seeders\DepartmentSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * 管理者ユーザー結合テスト
 */
class UserTest extends TestCase
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
        $response = $this->get(route('admin.users'));
        $response->assertStatus(200);
    }

    public function test_ajax_get(): void
    {
        $response = $this->get(route('admin.users.ajax'));
        $response->assertStatus(200);
    }

    public function test_update(): void
    {
        $notAdminUserId = 2;
        $newIsAdmin     = true;

        $response = $this->patch(route('admin.users.update.ajax'), [
            'userId'  => $notAdminUserId,
            'isAdmin' => $newIsAdmin,
        ]);

        $this->assertDatabaseHas(UserRepositoryInterface::TABLE_NAME, [
            'id'       => $notAdminUserId,
            'is_admin' => $newIsAdmin,
        ]);

        $response->assertStatus(200);
    }
}
