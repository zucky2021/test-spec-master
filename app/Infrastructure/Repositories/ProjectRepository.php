<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Project\ProjectDto;
use App\Domain\Project\ProjectFactory;
use App\Domain\Project\ProjectRepositoryInterface;
use DateTimeImmutable;
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
        $model = DB::table(self::TABLE_NAME)
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
        /** @var ProjectDto[] */
        return DB::table(self::TABLE_NAME)
            ->whereNull('deleted_at')
            ->get()
            ->map(function ($value) {
                /** @var stdClass $value */
                return new ProjectDto(
                    id: $value->id,
                    departmentId: $value->department_id,
                    name: $value->name,
                    summary: $value->summary,
                );
            })
            ->toArray();
    }

    public function exists(int $projectId): bool
    {
        return DB::table(self::TABLE_NAME)
            ->where('id', $projectId)
            ->exists();
    }

    public function store(ProjectDto $dto): int
    {
        $entity = ProjectFactory::create($dto);
        $now    = (new DateTimeImmutable())->format('Y-m-d H:i:s');

        return DB::table(self::TABLE_NAME)
            ->insertGetId([
                'department_id' => $entity->getDepartmentId(),
                'name'          => $entity->getName()->value(),
                'summary'       => $entity->getSummary()->value(),
                'created_at'    => $now,
                'updated_at'    => $now,
            ]);
    }

    public function update(ProjectDto $dto): void
    {
        $entity = ProjectFactory::create($dto);
        $now    = (new DateTimeImmutable())->format('Y-m-d H:i:s');

        DB::table(self::TABLE_NAME)
            ->where('id', $entity->getId())
            ->update([
                'department_id' => $entity->getDepartmentId(),
                'name'          => $entity->getName()->value(),
                'summary'       => $entity->getSummary()->value(),
                'updated_at'    => $now,
            ]);
    }
}
