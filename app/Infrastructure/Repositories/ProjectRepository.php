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
    public function findById(int $id): ?ProjectDto
    {
        /** @var stdClass|null */
        $model = DB::table(ProjectRepositoryInterface::TABLE_NAME)
            ->where('id', $id)
            ->first();

        if (is_null($model)) {
            return null;
        }

        return new ProjectDto(
            id: $model->id,
            departmentId: $model->department_id,
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
