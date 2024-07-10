<?php

namespace Database\Seeders;

use App\Domain\Project\ProjectFactory;
use App\Domain\Project\ProjectRepositoryInterface;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProjectSeeder extends Seeder
{
    public function run()
    {
        $values = [
            [
                'department_id' => 1,
                'name' => '風俗じゃぱん',
                'summary' => '集客',
            ],
            [
                'department_id' => 2,
                'name' => 'デリヘルじゃぱん',
                'summary' => '集客',
            ],
            [
                'department_id' => 3,
                'name' => 'バニラ',
                'summary' => '求人',
            ],
            [
                'department_id' => 4,
                'name' => 'ショコラ',
                'summary' => '求人',
            ],
            [
                'department_id' => 5,
                'name' => '駅ちか',
                'summary' => '集客',
            ],
            [
                'department_id' => 5,
                'name' => 'ココア',
                'summary' => '求人',
            ],
            [
                'department_id' => 5,
                'name' => 'リラクジョブ',
                'summary' => 'メンズエステ求人',
            ],
            [
                'department_id' => 5,
                'name' => 'ホスト',
                'summary' => '求人',
            ],
            [
                'department_id' => 6,
                'name' => 'FANNE',
                'summary' => 'SNS',
            ],
        ];

        $insertData = [];
        foreach ($values as $val) {
            $entity = ProjectFactory::create($val);
            $insertData[] = [
                'id' => $entity->getId(),
                'department_id' => $entity->getDepartmentId(),
                'name' => $entity->getName(),
                'summary' => $entity->getSummary(),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table(ProjectRepositoryInterface::TABLE_NAME)->insert($insertData);
    }
}
