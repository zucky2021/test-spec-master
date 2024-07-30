<?php

namespace App\Infrastructure\Repositories;

use App\Domain\SpecificationDocument\SpecificationDocumentDto;
use App\Domain\SpecificationDocument\SpecificationDocumentEntity;
use App\Domain\SpecificationDocument\SpecificationDocumentFactory;
use App\Domain\SpecificationDocument\SpecificationDocumentRepositoryInterface;
use DateTimeImmutable;
use Illuminate\Support\Facades\DB;
use stdClass;

/**
 * 仕様書DB永続化及び取得
 */
final class SpecificationDocumentRepository implements SpecificationDocumentRepositoryInterface
{
    public function findAllByProjectId(int $projectId): array
    {
        /** @var SpecificationDocumentEntity[] */
        $entities = DB::table(SpecificationDocumentRepositoryInterface::TABLE_NAME)
            ->where('project_id', $projectId)
            ->whereNull('deleted_at')
            ->get()
            ->map(function ($value) {
                /** @var stdClass $value */
                $dto = new SpecificationDocumentDto(
                    id: $value->id,
                    projectId: $value->project_id,
                    userId: $value->user_id,
                    title: $value->title,
                    summary: $value->summary,
                    updatedAt: new DateTimeImmutable($value->updated_at),
                );

                return SpecificationDocumentFactory::create($dto);
            })
            ->toArray();

        return $entities;
    }
}
