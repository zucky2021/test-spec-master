<?php

namespace App\UseCases\ExecutionEnvironment;

use App\Domain\ExecutionEnvironment\ExecutionEnvironmentDto;
use App\Domain\ExecutionEnvironment\ExecutionEnvironmentRepositoryInterface;

final class ExecutionEnvironmentFindAction
{
    private ExecutionEnvironmentRepositoryInterface $repository;

    public function __construct(ExecutionEnvironmentRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * 全ての実行環境を取得
     *
     * @return ExecutionEnvironmentDto[]
     */
    public function findAll(): array
    {
        return $this->repository->findAll();
    }
}
