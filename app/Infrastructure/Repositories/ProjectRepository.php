<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Project\ProjectFactory;
use App\Domain\Project\ProjectRepositoryInterface;
use Illuminate\Support\Facades\DB;

/**
 * Project DB repository
 */
final class ProjectRepository implements ProjectRepositoryInterface
{
    public function findAll(): array
    {
        $projects = DB::table(ProjectRepositoryInterface::TABLE_NAME)
            ->whereNull('deleted_at')
            ->get()
            ->map(function ($project) {
                return ProjectFactory::create((array) $project);
            });

        return $projects->toArray();
    }
}
