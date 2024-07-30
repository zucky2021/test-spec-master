<?php

namespace App\UseCases\SpecificationDocument;

use App\Domain\SpecificationDocument\SpecificationDocumentEntity;
use App\Domain\SpecificationDocument\SpecificationDocumentRepositoryInterface;

final class SpecificationDocumentFindAction
{
    private SpecificationDocumentRepositoryInterface $repository;

    public function __construct(SpecificationDocumentRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * プロジェクトIDから仕様書を取得
     *
     * @param int $projectId
     * @return SpecificationDocumentEntity[]
     */
    public function findAllByProjectId(int $projectId): array
    {
        return $this->repository->findAllByProjectId($projectId);
    }
}
