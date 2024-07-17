<?php

namespace App\Infrastructure\Repositories;

use App\Domain\SpecificationDocument\SpecificationDocumentFactory;
use App\Domain\SpecificationDocument\SpecificationDocumentRepositoryInterface;
use Illuminate\Support\Facades\DB;

/**
 * 仕様書DB永続化及び取得
 */

final class SpecificationDocumentRepository implements SpecificationDocumentRepositoryInterface
{
    public function findAllByProjectId(int $projectId): array
    {
        $projects = DB::table(SpecificationDocumentRepositoryInterface::TABLE_NAME)
            ->where('project_id', $projectId)
            ->whereNull('deleted_at')
            ->get()
            ->map(function ($project) {
                return SpecificationDocumentFactory::create((array) $project);
            });

        return $projects->toArray();
    }
}
