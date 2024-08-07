<?php

namespace App\Domain\Project;

use App\Domain\Project\ValueObject\Name;
use App\Domain\Project\ValueObject\Summary;

/**
 * Project domain object generation
 */
final class ProjectFactory
{
    public static function create(ProjectDto $dto): ProjectEntity
    {
        return new ProjectEntity(
            $dto->id,
            $dto->department_id,
            new Name($dto->name),
            new Summary($dto->summary),
        );
    }
}
