<?php

namespace App\Domain\Project;
use App\Domain\Project\ValueObject\Name;
use App\Domain\Project\ValueObject\Summary;
use DateTimeImmutable;

/**
 * Project domain object generation
 */
final class ProjectFactory
{
    public static function create($project): ProjectEntity
    {
        return new ProjectEntity(
            isset($project['id']) ? (int) $project['id'] : null,
            (int) $project['department_id'],
            new Name($project['name']),
            new Summary($project['summary']),
            new DateTimeImmutable($project)
        );
    }
}