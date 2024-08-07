<?php

namespace App\UseCases\SpecificationDocument;

use App\Domain\SpecificationDocument\SpecificationDocumentDto;
use App\Domain\SpecificationDocument\SpecificationDocumentRepositoryInterface;

final class SpecificationDocumentFindAction
{
    private SpecificationDocumentRepositoryInterface $repository;

    public function __construct(SpecificationDocumentRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function findById(int $id): SpecificationDocumentDto
    {
        return $this->repository->findById($id);
    }

    public function exists(int $id): bool
    {
        return $this->repository->exists($id);
    }

    /**
     * プロジェクトIDから仕様書を取得
     *
     * @param int $projectId
     * @return SpecificationDocumentDto[]
     */
    public function findAllByProjectId(int $projectId): array
    {
        return $this->repository->findAllByProjectId($projectId);
    }
}
