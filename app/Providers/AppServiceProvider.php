<?php

namespace App\Providers;

use App\Domain\Department\DepartmentRepositoryInterface;
use App\Domain\Project\ProjectRepositoryInterface;
use App\Infrastructure\Repositories\DepartmentRepository;
use App\Infrastructure\Repositories\ProjectRepository;
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
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
