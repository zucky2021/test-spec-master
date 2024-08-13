<?php

namespace App\UseCases\SpecificationDocument;

use App\Domain\SpecificationDocument\SpecificationDocumentDto;
use App\Domain\SpecificationDocument\SpecificationDocumentRepositoryInterface;

final class SpecificationDocumentStoreAction
{
    private SpecificationDocumentRepositoryInterface $repository;

    public function __construct(SpecificationDocumentRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function store(SpecificationDocumentDto $dto): int
    {
        return $this->repository->store($dto);
    }
}
