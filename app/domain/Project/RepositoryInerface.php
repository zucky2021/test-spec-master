<?php

namespace App\Domain\Project;

interface RepositoryInterface
{
    public function findAll(): array;
}
