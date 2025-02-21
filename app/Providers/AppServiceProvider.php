<?php

namespace App\Providers;

use App\Domain\Department\DepartmentRepositoryInterface;
use App\Domain\ExecutionEnvironment\ExecutionEnvironmentRepositoryInterface;
use App\Domain\Project\ProjectRepositoryInterface;
use App\Domain\SpecDocItem\SpecDocItemRepositoryInterface;
use App\Domain\SpecDocSheet\SpecDocSheetRepositoryInterface;
use App\Domain\SpecificationDocument\SpecificationDocumentRepositoryInterface;
use App\Domain\Tester\TesterRepositoryInterface;
use App\Domain\User\UserRepositoryInterface;
use App\Infrastructure\Repositories\DepartmentRepository;
use App\Infrastructure\Repositories\ExecutionEnvironmentRepository;
use App\Infrastructure\Repositories\ProjectRepository;
use App\Infrastructure\Repositories\SpecDocItemRepository;
use App\Infrastructure\Repositories\SpecDocSheetRepository;
use App\Infrastructure\Repositories\SpecificationDocumentRepository;
use App\Infrastructure\Repositories\TesterRepository;
use App\Infrastructure\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);

        $this->app->bind(ProjectRepositoryInterface::class, ProjectRepository::class);

        $this->app->bind(DepartmentRepositoryInterface::class, DepartmentRepository::class);

        $this->app->bind(ExecutionEnvironmentRepositoryInterface::class, ExecutionEnvironmentRepository::class);

        $this->app->bind(SpecificationDocumentRepositoryInterface::class, SpecificationDocumentRepository::class);

        $this->app->bind(SpecDocSheetRepositoryInterface::class, SpecDocSheetRepository::class);

        $this->app->bind(SpecDocItemRepositoryInterface::class, SpecDocItemRepository::class);

        $this->app->bind(TesterRepositoryInterface::class, TesterRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
