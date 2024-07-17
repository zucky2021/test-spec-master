<?php

namespace Database\Seeders;

use App\Domain\SpecificationDocument\SpecificationDocumentFactory;
use App\Domain\SpecificationDocument\SpecificationDocumentRepositoryInterface;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SpecificationDocumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $values = [
            [
                'id' => 1,
                'project_id' => 5,
                'user_id' => 1,
                'title' => 'EKI-0',
                'summary' => 'Sample',
                'created_at' => 'now',
            ],
        ];

        $insertData = [];
        foreach ($values as $val) {
            $entity = SpecificationDocumentFactory::create($val);
            $insertData[] = [
                'id' => $entity->getId(),
                'project_id' => $entity->getProjectId(),
                'user_id' => $entity->getUserId(),
                'title' => $entity->getTitle()->value(),
                'summary' => $entity->getSummary()->value(),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table(SpecificationDocumentRepositoryInterface::TABLE_NAME)->insert($insertData);
    }
}
