<?php

namespace Database\Seeders;

use App\Domain\SpecDocItem\SpecDocItemDto;
use App\Domain\SpecDocItem\SpecDocItemFactory;
use App\Domain\SpecDocItem\SpecDocItemRepositoryInterface;
use App\Domain\SpecDocItem\ValueObject\StatusId;
use Exception;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SpecDocItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $values = [
            [
                'spec_doc_sheet_id' => 1,
                'target_area'       => '[トップページ](https://core-tech.jp/)',
                'check_detail'      => '
                    画面を開けること
                    [![Image from Gyazo](https://i.gyazo.com/62d87d866c7b764e7903784c58a2d515.png)](https://gyazo.com/62d87d866c7b764e7903784c58a2d515)
                ',
                'remark'    => null,
                'status_id' => 0,
            ],
        ];

        $insertData = [];
        foreach ($values as $val) {
            $dto = new SpecDocItemDto(
                id: null,
                specDocSheetId: $val['spec_doc_sheet_id'],
                targetArea: $val['target_area'],
                checkDetail: $val['check_detail'],
                remark: $val['remark'],
                statusId: array_key_first(StatusId::STATUSES),
            );
            $entity       = SpecDocItemFactory::create($dto);
            $insertData[] = [
                'spec_doc_sheet_id' => $entity->getSpecDocSheetId(),
                'target_area'       => $entity->getTargetArea()->value(),
                'check_detail'      => $entity->getCheckDetail()->value(),
                'remark'            => $entity->getRemark()?->value(),
                'status_id'         => $entity->getStatusId()->value(),
                'created_at'        => now(),
                'updated_at'        => now(),
            ];
        }

        try {
            DB::table(SpecDocItemRepositoryInterface::TABLE_NAME)->insert($insertData);
        } catch (Exception $e) {
            Log::error('Failed to insert: ' . $e->getMessage());
        }
    }
}
