<?php

namespace App\UseCases\SpecDocSheet;

use App\Domain\SpecDocSheet\SpecDocSheetDto;
use App\Domain\SpecDocSheet\SpecDocSheetRepositoryInterface;

final class SpecDocSheetFindAction
{
    private SpecDocSheetRepositoryInterface $repository;

    public function __construct(SpecDocSheetRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function exists(int $id): bool
    {
        return $this->repository->exists($id);
    }

    /**
     * 仕様書IDからシートを取得
     *
     * @param int $specDocId
     * @return SpecDocSheetDto[]
     */
    public function findAllBySpecDocId(int $specDocId): array
    {
        return $this->repository->findAllBySpecDocId($specDocId);
    }
}
