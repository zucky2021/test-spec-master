<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Tester\TesterDto;
use App\Domain\Tester\TesterRepositoryInterface;
use Illuminate\Support\Facades\DB;
use stdClass;

final class TesterRepository implements TesterRepositoryInterface
{
    public function findAllBySpecDocSheetId(int $specDocSheetId): array
    {
        /** @var TesterDto[] */
        return DB::table(self::TABLE_NAME)
            ->where('spec_doc_sheet_id', $specDocSheetId)
            ->get()
            ->map(function ($value) {
                /** @var stdClass $value */
                return new TesterDto(
                    id: $value->id,
                    userId: $value->user_id,
                    specDocSheetId: $value->spec_doc_sheet_id,
                    createdAt: $value->created_at,
                );
            })
            ->toArray();
    }

    public function exists(int $id): bool
    {
        return DB::table(self::TABLE_NAME)
            ->where('id', $id)
            ->exists();
    }
}
