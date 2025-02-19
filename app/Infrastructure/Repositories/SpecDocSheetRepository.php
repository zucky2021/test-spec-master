<?php

namespace App\Infrastructure\Repositories;

use App\Domain\ExecutionEnvironment\ExecutionEnvironmentRepositoryInterface;
use App\Domain\SpecDocItem\SpecDocItemRepositoryInterface;
use App\Domain\SpecDocItem\ValueObject\StatusId as ItemStatusId;
use App\Domain\SpecDocSheet\SpecDocSheetDto;
use App\Domain\SpecDocSheet\SpecDocSheetEntity;
use App\Domain\SpecDocSheet\SpecDocSheetFactory;
use App\Domain\SpecDocSheet\SpecDocSheetRepositoryInterface;
use App\Domain\SpecDocSheet\ValueObject\StatusId;
use App\Domain\SpecificationDocument\SpecificationDocumentRepositoryInterface;
use DateTimeImmutable;
use Illuminate\Support\Facades\DB;
use stdClass;

/**
 * テスト仕様書シートDB永続化及び取得
 */
final class SpecDocSheetRepository implements SpecDocSheetRepositoryInterface
{
    public function exists(int $id): bool
    {
        return DB::table(self::TABLE_NAME)
            ->where('id', $id)
            ->exists();
    }

    public function findById(int $id): SpecDocSheetDto
    {
        /** @var stdClass */
        $model = DB::table(self::TABLE_NAME . ' as sds')
            ->join(ExecutionEnvironmentRepositoryInterface::TABLE_NAME . ' as ee', 'sds.exec_env_id', '=', 'ee.id')
            ->where('sds.id', $id)
            ->select('sds.*', 'ee.name as exec_env_name')
            ->first();

        return new SpecDocSheetDto(
            id: $model->id,
            specDocId: $model->spec_doc_id,
            execEnvId: $model->exec_env_id,
            statusId: $model->status_id,
            updatedAt: $model->updated_at,
            execEnvName: $model->exec_env_name,
        );
    }

    public function findAllById(int $specDocSheetId): SpecDocSheetEntity
    {
        /** @var stdClass */
        $model = DB::table(self::TABLE_NAME)
            ->where('id', $specDocSheetId)
            ->first();

        $dto = new SpecDocSheetDto(
            id: $model->id,
            specDocId: $model->spec_doc_id,
            execEnvId: $model->exec_env_id,
            statusId: $model->status_id,
            updatedAt: $model->updated_at,
            execEnvName: null,
        );

        return SpecDocSheetFactory::create($dto);
    }

    public function findAllBySpecDocId(int $specDocId): array
    {
        $query = DB::table(self::TABLE_NAME . ' as sds')
            ->join(ExecutionEnvironmentRepositoryInterface::TABLE_NAME . ' as ee', 'sds.exec_env_id', '=', 'ee.id')
            ->leftJoin(SpecDocItemRepositoryInterface::TABLE_NAME . ' as sdi', 'sds.id', '=', 'sdi.spec_doc_sheet_id')
            ->where('sds.spec_doc_id', $specDocId)
            ->select(
                'sds.*',
                'ee.name as exec_env_name',
                DB::raw('
                    CASE
                        WHEN MAX(sdi.status_id) IS NULL OR MAX(sdi.status_id) = ' . ItemStatusId::PENDING . ' THEN ' . StatusId::PENDING . '
                        WHEN MIN(sdi.status_id) = ' . ItemStatusId::PENDING . ' THEN ' . StatusId::IN_PROGRESS . '
                        WHEN MAX(sdi.status_id) = ' . ItemStatusId::NG . ' THEN ' . StatusId::NG . '
                        WHEN MIN(sdi.status_id) = ' . ItemStatusId::OK . ' AND MAX(sdi.status_id) = ' . ItemStatusId::OK . ' THEN ' . StatusId::COMPLETED . '
                        ELSE ' . StatusId::IN_PROGRESS . '
                    END as aggregated_status_id
                '),
            )
            ->groupBy('sds.id');

        /** @var SpecDocSheetDto[] */
        return $query->get()
            ->map(function ($value) {
                /** @var stdClass $value */
                return new SpecDocSheetDto(
                    id: $value->id,
                    specDocId: $value->spec_doc_id,
                    execEnvId: $value->exec_env_id,
                    statusId: $value->aggregated_status_id,
                    updatedAt: $value->updated_at,
                    execEnvName: $value->exec_env_name,
                );
            })
            ->toArray();
    }

    public function findAllByUserId(int $userId): array
    {
        $query = '
            SELECT *
            FROM ' . self::TABLE_NAME . ' AS sds
            JOIN ' . SpecificationDocumentRepositoryInterface::TABLE_NAME . ' AS sd
                ON sds.spec_doc_id = sd.id
                AND sd.user_id = :userId
        ';

        $result = DB::select($query, ['userId' => $userId]);

        return array_map(function ($value) {
            return new SpecDocSheetDto(
                id: $value->id,
                specDocId: $value->spec_doc_id,
                execEnvId: $value->exec_env_id,
                statusId: $value->status_id,
                updatedAt: $value->updated_at,
            );
        }, $result);
    }

    public function store(SpecDocSheetDto $dto): int
    {
        $entity = SpecDocSheetFactory::create($dto);
        $now    = (new DateTimeImmutable())->format('Y-m-d H:i:s');

        return DB::table(self::TABLE_NAME)
            ->insertGetId([
                'spec_doc_id' => $entity->getSpecDocId(),
                'exec_env_id' => $entity->getExecEnvId(),
                'created_at'  => $now,
                'updated_at'  => $now,
            ]);
    }

    public function update(SpecDocSheetDto $dto): void
    {
        $entity = SpecDocSheetFactory::create($dto);
        DB::table(self::TABLE_NAME)
            ->where('id', $entity->getId())
            ->update([
                'updated_at' => (new DateTimeImmutable())->format('Y-m-d H:i:s'),
            ]);
    }

    public function deleteById(int $id): void
    {
        DB::table(self::TABLE_NAME)
            ->where('id', $id)
            ->delete();
    }
}
