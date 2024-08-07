<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Project\ProjectDto;
use App\Domain\Project\ProjectEntity;
use App\Domain\Project\ProjectFactory;
use App\Domain\Project\ProjectRepositoryInterface;
use Illuminate\Support\Facades\DB;

/**
 * Project DB repository
 */
final class ProjectRepository implements ProjectRepositoryInterface
{
    public function findById(int $id): ?ProjectDto
    {
        /** @var ProjectDto|null */
        $model = DB::table(ProjectRepositoryInterface::TABLE_NAME)
            ->where('id', $id)
            ->first();

        if (is_null($model)) {
            return null;
        }

        return new ProjectDto(
            id: $model->id,
            department_id: $model->department_id,
            name: $model->name,
            summary: $model->summary,
        );
    }
    public function findAll(): array
    {
        /** @var ProjectEntity[] */
        $entities = DB::table(ProjectRepositoryInterface::TABLE_NAME)
            ->whereNull('deleted_at')
            ->get()
            ->map(function ($value) {
                /** @var ProjectDto $value */
                $dto = new ProjectDto(
                    id: $value->id,
                    department_id: $value->department_id,
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
