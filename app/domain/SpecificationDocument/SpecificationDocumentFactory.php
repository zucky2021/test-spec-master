<?php

namespace App\Domain\SpecificationDocument;

use App\Domain\SpecificationDocument\ValueObject\Summary;
use App\Domain\SpecificationDocument\ValueObject\Title;
use DateTimeImmutable;

final class SpecificationDocumentFactory
{
    public static function create(array $data): SpecificationDocumentEntity
    {
        return new SpecificationDocumentEntity(
            (int) $data['id'],
            (int) $data['project_id'],
            (int) $data['user_id'],
            new Title($data['title']),
            new Summary($data['summary']),
            new DateTimeImmutable($data['created_at'])
        );
    }
}
