<?php

namespace App\Domain\Project;
use App\Domain\Project\ValueObject\Name;
use App\Domain\Project\ValueObject\Summary;
use DateTimeImmutable;

final class Factory
{
    public static function create($project): Entity
    {
        return new Entity(
            (int) $project['id'],
            new Name($project['name']),
            isset($project['summary']) ? new Summary($project['summary']) : null,
            new DateTimeImmutable($project)
        );
    }
}