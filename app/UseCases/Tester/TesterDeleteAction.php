<?php

namespace App\UseCases\Tester;

use App\Domain\Tester\TesterRepositoryInterface;

final class TesterDeleteAction
{
    private TesterRepositoryInterface $repository;

    public function __construct(TesterRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function deleteById(int $id): void
    {
        $this->repository->deleteById($id);
    }
}
