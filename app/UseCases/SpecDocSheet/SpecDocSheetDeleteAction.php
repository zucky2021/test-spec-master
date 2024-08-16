<?php

namespace App\UseCases\SpecDocSheet;

use App\Domain\SpecDocSheet\SpecDocSheetRepositoryInterface;

final class SpecDocSheetDeleteAction
{
    private SpecDocSheetRepositoryInterface $repository;

    public function __construct(SpecDocSheetRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function deleteById(int $id): void
    {
        $this->repository->deleteById($id);
    }
}
