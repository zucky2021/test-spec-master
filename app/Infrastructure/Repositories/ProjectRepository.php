<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Project\ProjectDto;
use App\Domain\Project\ProjectEntity;
use App\Domain\Project\ProjectFactory;
use App\Domain\Project\ProjectRepositoryInterface;
use Illuminate\Support\Facades\DB;
use stdClass;

/**
 * Project DB repository
 */
final class ProjectRepository implements ProjectRepositoryInterface
{
    public function findAll(): array
    {
        /** @var ProjectEntity[] */
        $entities = DB::table(ProjectRepositoryInterface::TABLE_NAME)
            ->whereNull('deleted_at')
            ->get()
            ->map(function ($value) {
                /** @var stdClass $value */
                $dto = new ProjectDto(
                    id: $value->id,
                    departmentId: $value->department_id,
                    name: $value->name,
                    summary: $value->summary,
                );

                return ProjectFactory::create($dto);
            })
            ->toArray();

        return $entities;
    }

    public function exists(int $projectId): bool
    {
        return DB::table(ProjectRepositoryInterface::TABLE_NAME)
            ->where('id', $projectId)
            ->exists();
    }
}
