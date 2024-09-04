<?php

namespace App\UseCases\SpecDocItem;

use App\Domain\SpecDocItem\SpecDocItemDto;
use App\Domain\SpecDocItem\SpecDocItemRepositoryInterface;

final class SpecDocItemUpdateAction
{
    private SpecDocItemRepositoryInterface $repository;

    public function __construct(SpecDocItemRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function update(SpecDocItemDto $dto): void
    {
        $this->repository->update($dto);
    }
}
