<?php

namespace App\Infrastructure\Repositories;

use App\Domain\SpecificationDocument\SpecificationDocumentDto;
use App\Domain\SpecificationDocument\SpecificationDocumentRepositoryInterface;
use Illuminate\Support\Facades\DB;

/**
 * 仕様書DB永続化及び取得
 */
final class SpecificationDocumentRepository implements SpecificationDocumentRepositoryInterface
{
    public function findById(int $id): SpecificationDocumentDto
    {
        /** @var SpecificationDocumentDto */
        $model = DB::table(SpecificationDocumentRepositoryInterface::TABLE_NAME)
            ->where('id', $id)
            ->first();

        return new SpecificationDocumentDto(
            id: $model->id,
            project_id: $model->project_id,
            user_id: $model->user_id,
            title: $model->title,
            summary: $model->summary,
            updated_at: $model->updated_at,
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
                /** @var SpecificationDocumentDto $value */
                return new SpecificationDocumentDto(
                    id: $value->id,
                    project_id: $value->project_id,
                    user_id: $value->user_id,
                    title: $value->title,
                    summary: $value->summary,
                    updated_at: $value->updated_at,
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
}
