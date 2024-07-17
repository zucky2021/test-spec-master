<?php

namespace App\Domain\SpecificationDocument;

use App\Domain\SpecificationDocument\ValueObject\Summary;
use App\Domain\SpecificationDocument\ValueObject\Title;
use DateTimeImmutable;

/**
 * 仕様書Entity
 */
final class SpecificationDocumentEntity
{
    private int $id;
    private int $projectId;
    private int $userId;
    private Title $title;
    private Summary $summary;
    private DateTimeImmutable $createdAt;

    public function __construct(
        int $id,
        int $projectId,
        int $userId,
        Title $title,
        Summary $summary,
        DateTimeImmutable $createdAt
    ) {
        $this->id = $id;
        $this->projectId = $projectId;
        $this->userId = $userId;
        $this->title = $title;
        $this->summary = $summary;
        $this->createdAt = $createdAt;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getProjectId(): int
    {
        return $this->projectId;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getTitle(): Title
    {
        return $this->title;
    }

    public function getSummary(): Summary
    {
        return $this->summary;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function toArray(): array
    {
        $retArr = get_object_vars($this);
        $retArr['title'] = $this->getTitle()->value();
        $retArr['summary'] = $this->getSummary()->value();

        return $retArr;
    }
}
