<?php

namespace App\Domain\Breadcrumb;

final class BreadcrumbEntity
{
    public function __construct(
        private string $name,
        private string $url,
    ) {
        $this->name = $name;
        $this->url  = $url;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * プリミティブ型の配列を返却
     *
     * @return array<string>
     */
    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'url'  => $this->url,
        ];
    }
}
