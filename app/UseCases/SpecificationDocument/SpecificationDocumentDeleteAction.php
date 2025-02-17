<?php

namespace App\UseCases\SpecificationDocument;

use App\Domain\SpecificationDocument\SpecificationDocumentRepositoryInterface;

final class SpecificationDocumentDeleteAction
{
    private SpecificationDocumentRepositoryInterface $repository;

    public function __construct(SpecificationDocumentRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function delete(int $id): void
    {
        $this->repository->delete($id);
    }
}
