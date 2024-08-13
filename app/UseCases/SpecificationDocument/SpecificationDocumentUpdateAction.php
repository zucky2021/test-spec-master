<?php

namespace App\UseCases\SpecificationDocument;

use App\Domain\SpecificationDocument\SpecificationDocumentDto;
use App\Domain\SpecificationDocument\SpecificationDocumentRepositoryInterface;

final class SpecificationDocumentUpdateAction
{
    private SpecificationDocumentRepositoryInterface $repository;

    public function __construct(SpecificationDocumentRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function update(SpecificationDocumentDto $dto): void
    {
        $this->repository->update($dto);
    }
}
