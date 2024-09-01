<?php

namespace App\UseCases\SpecDocItem;

use App\Domain\SpecDocItem\SpecDocItemDto;
use App\Domain\SpecDocItem\SpecDocItemRepositoryInterface;

final class SpecDocItemFindAction
{
    private SpecDocItemRepositoryInterface $repository;

    public function __construct(SpecDocItemRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    // public function exists(int $id): bool
    // {
    //     return $this->repository->exists($id);
    // }

    // public function findById(int $id): SpecDocItemDto
    // {
    //     return $this->repository->findById($id);
    // }

    /**
     * シートIDから全ての項目を取得
     *
     * @param int $specDocSheetId
     * @return SpecDocItemDto[]
     */
    public function findAllBySpecDocSheetId(int $specDocSheetId): array
    {
        return $this->repository->findAllBySpecDocSheetId($specDocSheetId);
    }
}
