<?php

namespace App\UseCases\Tester;

use App\Domain\Tester\TesterDto;
use App\Domain\Tester\TesterRepositoryInterface;

final class TesterStoreAction
{
    private TesterRepositoryInterface $repository;

    public function __construct(TesterRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function store(TesterDto $dto): int
    {
        return $this->repository->store($dto);
    }
}
