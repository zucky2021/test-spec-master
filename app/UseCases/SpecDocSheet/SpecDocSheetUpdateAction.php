<?php

namespace App\UseCases\SpecDocSheet;

use App\Domain\SpecDocSheet\SpecDocSheetDto;
use App\Domain\SpecDocSheet\SpecDocSheetRepositoryInterface;

final class SpecDocSheetUpdateAction
{
    private SpecDocSheetRepositoryInterface $repository;

    public function __construct(SpecDocSheetRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function update(SpecDocSheetDto $dto): void
    {
        $this->repository->update($dto);
    }
}
