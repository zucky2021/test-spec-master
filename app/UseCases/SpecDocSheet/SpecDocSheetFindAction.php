<?php

namespace App\UseCases\SpecDocSheet;

use App\Domain\SpecDocSheet\SpecDocSheetEntity;
use App\Domain\SpecDocSheet\SpecDocSheetRepositoryInterface;

final class SpecDocSheetFindAction
{
    private SpecDocSheetRepositoryInterface $repository;

    public function __construct(SpecDocSheetRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * 仕様書IDからシートを取得
     *
     * @param int $specDocId
     * @return SpecDocSheetEntity[]
     */
    public function findAllBySpecDocId(int $specDocId): array
    {
        return $this->repository->findAllBySpecDocId($specDocId);
    }
}
