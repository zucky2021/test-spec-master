<?php

namespace Database\Seeders;

use App\Domain\SpecDocSheet\SpecDocSheetDto;
use App\Domain\SpecDocSheet\SpecDocSheetFactory;
use App\Domain\SpecDocSheet\SpecDocSheetRepositoryInterface;
use App\Domain\SpecDocSheet\ValueObject\StatusId;
use DateTimeImmutable;
use Exception;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SpecDocSheetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $values = [
            [
                'spec_doc_id' => 1,
                'exec_env_id' => 1,
            ],
        ];

        $insertData = [];
        foreach ($values as $val) {
            $dto = new SpecDocSheetDto(
                id: null,
                specDocId: $val['spec_doc_id'],
                execEnvId: $val['exec_env_id'],
                statusId: array_key_first(StatusId::STATUSES),
                updatedAt: new DateTimeImmutable(),
                execEnvName: null,
            );
            $entity       = SpecDocSheetFactory::create($dto);
            $insertData[] = [
                'spec_doc_id' => $entity->getSpecDocId(),
                'exec_env_id' => $entity->getExecEnvId(),
                'status_id'   => $entity->getStatusId()->value(),
                'created_at'  => now(),
                'updated_at'  => now(),
            ];
        }

        try {
            DB::table(SpecDocSheetRepositoryInterface::TABLE_NAME)->insert($insertData);
        } catch (Exception $e) {
            Log::error('Failed to insert: ' . $e->getMessage());
        }
    }
}
