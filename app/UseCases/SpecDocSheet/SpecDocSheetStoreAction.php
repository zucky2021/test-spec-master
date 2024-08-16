<?php

namespace App\UseCases\SpecDocSheet;

use App\Domain\SpecDocSheet\SpecDocSheetDto;
use App\Domain\SpecDocSheet\SpecDocSheetRepositoryInterface;

final class SpecDocSheetStoreAction
{
    private SpecDocSheetRepositoryInterface $repository;

    public function __construct(SpecDocSheetRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function store(SpecDocSheetDto $dto): int
    {
        return $this->repository->store($dto);
    }
}
