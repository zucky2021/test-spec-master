<?php

namespace App\Domain\Breadcrumb;

final class BreadcrumbFactory
{
    public static function create(BreadcrumbDto $dto): BreadcrumbEntity
    {
        return new BreadcrumbEntity(
            name: $dto->name,
            url: $dto->url,
        );
    }
}
