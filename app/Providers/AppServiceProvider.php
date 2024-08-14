<?php

namespace App\Providers;

use App\Domain\Department\DepartmentRepositoryInterface;
use App\Domain\ExecutionEnvironment\ExecutionEnvironmentRepositoryInterface;
use App\Domain\Project\ProjectRepositoryInterface;
use App\Domain\SpecDocSheet\SpecDocSheetRepositoryInterface;
use App\Domain\SpecificationDocument\SpecificationDocumentRepositoryInterface;
use App\Infrastructure\Repositories\DepartmentRepository;
use App\Infrastructure\Repositories\ExecutionEnvironmentRepository;
use App\Infrastructure\Repositories\ProjectRepository;
use App\Infrastructure\Repositories\SpecDocSheetRepository;
use App\Infrastructure\Repositories\SpecificationDocumentRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ProjectRepositoryInterface::class, ProjectRepository::class);

        $this->app->bind(DepartmentRepositoryInterface::class, DepartmentRepository::class);

        $this->app->bind(ExecutionEnvironmentRepositoryInterface::class, ExecutionEnvironmentRepository::class);

        $this->app->bind(SpecificationDocumentRepositoryInterface::class, SpecificationDocumentRepository::class);

        $this->app->bind(SpecDocSheetRepositoryInterface::class, SpecDocSheetRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
