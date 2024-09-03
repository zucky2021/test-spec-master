<?php

namespace App\UseCases\SpecDocItem;

use App\Domain\SpecDocItem\SpecDocItemDto;
use App\Domain\SpecDocItem\SpecDocItemRepositoryInterface;

final class SpecDocItemStoreAction
{
    private SpecDocItemRepositoryInterface $repository;

    public function __construct(SpecDocItemRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * 複数の項目を登録
     *
     * @param SpecDocItemDto[] $dtoArr
     * @return void
     */
    public function store(array $dtoArr): void
    {
        $this->repository->store($dtoArr);
    }
}
