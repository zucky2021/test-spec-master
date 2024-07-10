<?php

namespace Database\Seeders;

use App\Domain\Department\DepartmentFactory;
use App\Domain\Department\DepartmentRepositoryInterface;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $values = [
            [
                'id' => 1,
                'name' => 'プラットフォーム事業部1課',
            ],
            [
                'id' => 2,
                'name' => 'プラットフォーム事業部2課',
            ],
            [
                'id' => 3,
                'name' => 'プラットフォーム事業部3課',
            ],
            [
                'id' => 4,
                'name' => 'アジャイル事業部1課',
            ],
            [
                'id' => 5,
                'name' => 'アジャイル事業部2課',
            ],
            [
                'id' => 6,
                'name' => 'メディアソリューション事業部1課',
            ],
        ];

        $insertData = [];
        foreach ($values as $val) {
            $entity = DepartmentFactory::create($val);
            $insertData[] = [
                'id' => $entity->getId(),
                'name' => $entity->getName()->value(),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table(DepartmentRepositoryInterface::TABLE_NAME)->insert($insertData);
    }
}
