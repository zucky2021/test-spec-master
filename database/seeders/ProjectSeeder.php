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
                'name'          => '風俗じゃぱん',
                'summary'       => '集客',
            ],
            [
                'department_id' => 2,
                'name'          => 'デリヘルじゃぱん',
                'summary'       => '集客',
            ],
            [
                'department_id' => 3,
                'name'          => 'バニラ',
                'summary'       => '求人',
            ],
            [
                'department_id' => 4,
                'name'          => 'ショコラ',
                'summary'       => '求人',
            ],
            [
                'department_id' => 5,
                'name'          => '駅ちか',
                'summary'       => '集客',
            ],
            [
                'department_id' => 5,
                'name'          => 'ココア',
                'summary'       => '求人',
            ],
            [
                'department_id' => 5,
                'name'          => 'リラクジョブ',
                'summary'       => 'メンズエステ求人',
            ],
            [
                'department_id' => 5,
                'name'          => 'ホスト',
                'summary'       => '求人',
            ],
            [
                'department_id' => 6,
                'name'          => 'FANNE',
                'summary'       => 'SNS',
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
