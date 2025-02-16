<?php

namespace App\Infrastructure\Repositories;

use App\Domain\SpecificationDocument\SpecificationDocumentDto;
use App\Domain\SpecificationDocument\SpecificationDocumentFactory;
use App\Domain\SpecificationDocument\SpecificationDocumentRepositoryInterface;
use App\Domain\User\UserRepositoryInterface;
use DateTimeImmutable;
use Illuminate\Support\Facades\DB;
use stdClass;

/**
 * 仕様書DB永続化及び取得
 */
final class SpecificationDocumentRepository implements SpecificationDocumentRepositoryInterface
{
    public function findById(int $id): SpecificationDocumentDto
    {
        /** @var stdClass */
        $model = DB::table(SpecificationDocumentRepositoryInterface::TABLE_NAME . ' as sd')
            ->leftJoin(UserRepositoryInterface::TABLE_NAME . ' as u', 'sd.user_id', '=', 'u.id')
            ->where('sd.id', $id)
            ->select('sd.*', 'u.name as user_name')
            ->first();

        return new SpecificationDocumentDto(
            id: $model->id,
            projectId: $model->project_id,
            userId: $model->user_id,
            title: $model->title,
            summary: $model->summary,
            updatedAt: $model->updated_at,
            userName: $model->user_name,
        );
    }
    public function findAllByProjectId(int $projectId): array
    {
        /** @var SpecificationDocumentDto[] */
        return DB::table(SpecificationDocumentRepositoryInterface::TABLE_NAME)
            ->where('project_id', $projectId)
            ->whereNull('deleted_at')
            ->get()
            ->map(function ($value) {
                /** @var stdClass $value */
                return new SpecificationDocumentDto(
                    id: $value->id,
                    projectId: $value->project_id,
                    userId: $value->user_id,
                    title: $value->title,
                    summary: $value->summary,
                    updatedAt: $value->updated_at,
                    userName: null,
                );
            })
            ->toArray();
    }

    public function exists(int $specDocId): bool
    {
        return DB::table(SpecificationDocumentRepositoryInterface::TABLE_NAME)
            ->where('id', $specDocId)
            ->exists();
    }

    public function store(SpecificationDocumentDto $dto): int
    {
        $entity = SpecificationDocumentFactory::create($dto);

        $now = (new DateTimeImmutable())->format('Y-m-d H:i:s');

        return DB::table(SpecificationDocumentRepositoryInterface::TABLE_NAME)
            ->insertGetId([
                'project_id' => $entity->getProjectId(),
                'user_id'    => $entity->getUserId(),
                'title'      => $entity->getTitle()->value(),
                'summary'    => $entity->getSummary()->value(),
                'created_at' => $now,
                'updated_at' => $now,
            ]);
    }

    public function update(SpecificationDocumentDto $dto): void
    {
        $entity = SpecificationDocumentFactory::create($dto);

        DB::table(SpecificationDocumentRepositoryInterface::TABLE_NAME)
            ->where('id', $entity->getId())
            ->update([
                'title'      => $entity->getTitle()->value(),
                'summary'    => $entity->getSummary()->value(),
                'updated_at' => (new DateTimeImmutable())->format('Y-m-d H:i:s'),
            ]);
    }

    public function delete(int $id): void
    {
        DB::table(SpecificationDocumentRepositoryInterface::TABLE_NAME)
            ->where('id', $id)
            ->update([
                'deleted_at' => (new DateTimeImmutable())->format('Y-m-d H:i:s'),
            ]);
    }
}
