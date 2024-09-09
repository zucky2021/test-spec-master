<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Tester\TesterDto;
use App\Domain\Tester\TesterFactory;
use App\Domain\Tester\TesterRepositoryInterface;
use App\Domain\User\UserRepositoryInterface;
use DateTimeImmutable;
use Illuminate\Support\Facades\DB;
use stdClass;

final class TesterRepository implements TesterRepositoryInterface
{
    public function findAllBySpecDocSheetId(int $specDocSheetId): array
    {
        /** @var TesterDto[] */
        return DB::table(self::TABLE_NAME . ' as t')
            ->leftJoin(UserRepositoryInterface::TABLE_NAME . ' as u', 't.user_id', '=', 'u.id')
            ->where('spec_doc_sheet_id', $specDocSheetId)
            ->select('t.*', 'u.name as user_name')
            ->get()
            ->map(function ($value) {
                /** @var stdClass $value */
                return new TesterDto(
                    id: $value->id,
                    userId: $value->user_id,
                    specDocSheetId: $value->spec_doc_sheet_id,
                    createdAt: $value->created_at,
                    userName: $value->user_name,
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

    public function store(TesterDto $dto): int
    {
        $entity = TesterFactory::create($dto);
        $now    = (new DateTimeImmutable())->format('Y-m-d H:i:s');

        return DB::table(self::TABLE_NAME)
            ->insertGetId([
                'user_id'           => $entity->getUserId(),
                'spec_doc_sheet_id' => $entity->getSpecDocSheetId(),
                'created_at'        => $now,
                'updated_at'        => $now,
            ]);
    }

    public function deleteById(int $id): void
    {
        DB::table(self::TABLE_NAME)
            ->where('id', $id)
            ->delete();
    }
}
