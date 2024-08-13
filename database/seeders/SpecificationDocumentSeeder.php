<?php

namespace Database\Seeders;

use App\Domain\SpecificationDocument\SpecificationDocumentDto;
use App\Domain\SpecificationDocument\SpecificationDocumentFactory;
use App\Domain\SpecificationDocument\SpecificationDocumentRepositoryInterface;
use Exception;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SpecificationDocumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $values = [
            [
                'project_id' => 5,
                'user_id'    => 1,
                'title'      => 'EKI-0',
                'summary'    => 'https://backlog.com/ja/',
            ],
        ];

        $insertData = [];
        foreach ($values as $val) {
            $dto = new SpecificationDocumentDto(
                id: null,
                projectId: (int) $val['project_id'],
                userId: $val['user_id'],
                title: $val['title'],
                summary: $val['summary'],
                updatedAt: now(),
            );
            $entity       = SpecificationDocumentFactory::create($dto);
            $insertData[] = [
                'project_id' => $entity->getProjectId(),
                'user_id'    => $entity->getUserId(),
                'title'      => $entity->getTitle()->value(),
                'summary'    => $entity->getSummary()->value(),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        try {
            DB::table(SpecificationDocumentRepositoryInterface::TABLE_NAME)->insert($insertData);
        } catch (Exception $e) {
            Log::error('Failed to insert: ' . $e->getMessage());
        }
    }
}
