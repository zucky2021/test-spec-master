<?php

namespace Database\Seeders;

use App\Domain\Project\ProjectDto;
use App\Domain\Project\ProjectFactory;
use App\Domain\Project\ProjectRepositoryInterface;
use Exception;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        $values = [
            [
                'department_id' => 1,
                'name'          => 'ProjectA',
                'summary'       => '# 求人',
            ],
            [
                'department_id' => 2,
                'name'          => 'ProjectB',
                'summary'       => '# 集客',
            ],
            [
                'department_id' => 3,
                'name'          => 'ProjectC',
                'summary'       => '# SNS',
            ],
        ];

        $insertData = [];
        foreach ($values as $val) {
            $dto = new ProjectDto(
                id: null,
                departmentId: $val['department_id'],
                name: $val['name'],
                summary: $val['summary'],
            );
            $entity       = ProjectFactory::create($dto);
            $insertData[] = [
                'department_id' => $entity->getDepartmentId(),
                'name'          => $entity->getName()->value(),
                'summary'       => $entity->getSummary()->value(),
                'created_at'    => now(),
                'updated_at'    => now(),
            ];
        }

        try {
            DB::table(ProjectRepositoryInterface::TABLE_NAME)->insert($insertData);
        } catch (Exception $e) {
            Log::error('Failed to insert: ' . $e->getMessage());
        }
    }
}
