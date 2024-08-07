<?php

namespace App\Infrastructure\Repositories;

use App\Domain\ExecutionEnvironment\ExecutionEnvironmentRepositoryInterface;
use App\Domain\SpecDocSheet\SpecDocSheetDto;
use App\Domain\SpecDocSheet\SpecDocSheetEntity;
use App\Domain\SpecDocSheet\SpecDocSheetFactory;
use App\Domain\SpecDocSheet\SpecDocSheetRepositoryInterface;
use DateTimeImmutable;
use Illuminate\Support\Facades\DB;
use stdClass;

/**
 * テスト仕様書シートDB永続化及び取得
 */
final class SpecDocSheetRepository implements SpecDocSheetRepositoryInterface
{
    public function findAllById(int $specDocSheetId): SpecDocSheetEntity
    {
        /** @var stdClass */
        $model = DB::table(SpecDocSheetRepositoryInterface::TABLE_NAME)
            ->where('id', $specDocSheetId)
            ->first();

        $dto = new SpecDocSheetDto(
            id: $model->id,
            specDocId: $model->spec_doc_id,
            execEnvId: $model->exec_env_id,
            statusId: $model->status_id,
            updatedAt: new DateTimeImmutable($model->updated_at),
            execEnvName: null,
        );

        return SpecDocSheetFactory::create($dto);
    }

    public function findAllBySpecDocId(int $specDocId): array
    {
        /** @var SpecDocSheetEntity[] */
        $entities = DB::table(SpecDocSheetRepositoryInterface::TABLE_NAME . ' as sds')
            ->join(ExecutionEnvironmentRepositoryInterface::TABLE_NAME . ' as ee', 'sds.exec_env_id', '=', 'ee.id')
            ->where('sds.spec_doc_id', $specDocId)
            ->select('sds.*', 'ee.name as exec_env_name')
            ->get()
            ->map(function ($value) {
                /** @var stdClass $value */
                $dto = new SpecDocSheetDto(
                    id: $value->id,
                    specDocId: $value->spec_doc_id,
                    execEnvId: $value->exec_env_id,
                    statusId: $value->status_id,
                    updatedAt: new DateTimeImmutable($value->updated_at),
                    execEnvName: $value->exec_env_name,
                );

                return SpecDocSheetFactory::create($dto);
            })
            ->toArray();

        return $entities;
    }
}
