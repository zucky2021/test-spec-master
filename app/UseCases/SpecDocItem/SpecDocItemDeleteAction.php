<?php

namespace App\UseCases\SpecDocItem;

use App\Domain\SpecDocItem\SpecDocItemRepositoryInterface;

final class SpecDocItemDeleteAction
{
    private SpecDocItemRepositoryInterface $repository;

    public function __construct(SpecDocItemRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * シートIDから全て削除
     *
     * @param int $specDocSheetId
     * @return void
     */
    public function deleteAllBySheetId(int $specDocSheetId): void
    {
        $this->repository->deleteAllBySheetId($specDocSheetId);
    }
}
