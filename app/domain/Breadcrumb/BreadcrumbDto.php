<?php

namespace App\Domain\Breadcrumb;

final class BreadcrumbDto
{
    public function __construct(
        public string $name,
        public string $url,
    ) {
        $this->name = $name;
        $this->url  = $url;
    }
}
