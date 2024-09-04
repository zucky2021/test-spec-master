<?php

namespace App\Infrastructure\Repositories;

use App\Domain\SpecDocItem\SpecDocItemDto;
use App\Domain\SpecDocItem\SpecDocItemFactory;
use App\Domain\SpecDocItem\SpecDocItemRepositoryInterface;
use DateTimeImmutable;
use Illuminate\Support\Facades\DB;
use stdClass;

/**
 * テスト仕様書シートDB永続化及び取得
 */
final class SpecDocItemRepository implements SpecDocItemRepositoryInterface
{
    public function exists(int $id): bool
    {
        return DB::table(self::TABLE_NAME)
            ->where('id', $id)
            ->exists();
    }

    public function findById(int $id): SpecDocItemDto
    {
        /** @var stdClass */
        $model = DB::table(self::TABLE_NAME . ' as sds')
            ->first();

        return new SpecDocItemDto(
            id: $model->id,
            specDocSheetId: $model->spec_doc_sheet_id,
            targetArea: $model->target_area,
            checkDetail: $model->check_detail,
            remark: $model->remark,
            statusId: $model->status_id,
        );
    }

    public function findAllBySpecDocSheetId(int $specDocSheetId): array
    {
        /** @var SpecDocItemDto[] */
        return DB::table(self::TABLE_NAME)
            ->get()
            ->map(function ($value) {
                /** @var stdClass $value */
                return new SpecDocItemDto(
                    id: $value->id,
                    specDocSheetId: $value->spec_doc_sheet_id,
                    targetArea: $value->target_area,
                    checkDetail: $value->check_detail,
                    remark: $value->remark,
                    statusId: $value->status_id,
                );
            })
            ->toArray();
    }

    public function store(array $dtoArr): void
    {
        $inserts = [];
        foreach ($dtoArr as $dto) {
            $entity    = SpecDocItemFactory::create($dto);
            $inserts[] = [
                'spec_doc_sheet_id' => $entity->getSpecDocSheetId(),
                'target_area'       => $entity->getTargetArea()->value(),
                'check_detail'      => $entity->getCheckDetail()->value(),
                'remark'            => $entity->getRemark()?->value(),
                'status_id'         => $entity->getStatusId()->value(),
                'created_at'        => (new DateTimeImmutable())->format('Y-m-d H:i:s'),
                'updated_at'        => (new DateTimeImmutable())->format('Y-m-d H:i:s'),
            ];
        }
        DB::table(self::TABLE_NAME)
            ->insert($inserts);
    }

    public function update(SpecDocItemDto $dto): void
    {
        $entity = SpecDocItemFactory::create($dto);

        DB::table(self::TABLE_NAME)
            ->where('id', $entity->getId())
            ->update([
                'status_id'  => $entity->getStatusId()->value(),
                'updated_at' => (new DateTimeImmutable())->format('Y-m-d H:i:s'),
            ]);
    }

    public function deleteAllBySheetId(int $specDocSheetId): void
    {
        DB::table(self::TABLE_NAME)
            ->where('spec_doc_sheet_id', $specDocSheetId)
            ->delete();
    }
}
