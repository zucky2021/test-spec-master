<?php

namespace Tests\Feature\Admin;

use App\Domain\Project\ProjectRepositoryInterface;
use App\Models\User;
use Database\Seeders\DepartmentSeeder;
use Database\Seeders\ProjectSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * 管理者プロジェクト結合テスト
 */
class ProjectTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed([
            DepartmentSeeder::class,
            ProjectSeeder::class,
            UserSeeder::class,
        ]);

        /** @var User */
        $adminUser = User::where('is_admin', true)->first();
        $this->actingAs($adminUser);
    }

    public function test_index(): void
    {
        $response = $this->get(route('admin.projects'));
        $response->assertStatus(200);
    }

    public function test_store(): void
    {
        $newDepartmentId = 1;
        $newName         = 'New name';
        $newSummary      = '# New summary';

        $response = $this->post(route('admin.projects.store'), [
            'departmentId' => $newDepartmentId,
            'name'         => $newName,
            'summary'      => $newSummary,
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success', 'Created project');

        $this->assertDatabaseHas(ProjectRepositoryInterface::TABLE_NAME, [
            'department_id' => $newDepartmentId,
            'name'          => $newName,
            'summary'       => $newSummary,
        ]);
        $response->assertStatus(302);
    }

    public function test_update(): void
    {
        $id           = 1;
        $departmentId = 1;
        $name         = 'Update name';
        $summary      = '# Update summary';

        $response = $this->patch(route('admin.projects.update', ['projectId' => $id]), [
            'id'           => $id,
            'departmentId' => $departmentId,
            'name'         => $name,
            'summary'      => $summary,
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas(ProjectRepositoryInterface::TABLE_NAME, [
            'id'            => $id,
            'department_id' => $departmentId,
            'name'          => $name,
            'summary'       => $summary,
        ]);

        $response->assertSessionHas('success', 'Updated project');
        $response->assertStatus(302);
    }

    public function test_destroy(): void
    {
        $id = 1;

        $response = $this->delete(route('admin.projects.destroy', [
            'projectId' => $id,
        ]));

        $response->assertRedirect();
        $this->assertSoftDeleted(ProjectRepositoryInterface::TABLE_NAME, [
            'id' => $id,
        ]);
        $response->assertSessionHas('success', 'Delete project');
        $response->assertStatus(302);
    }
}
