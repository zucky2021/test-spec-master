<?php

namespace App\Domain\User;

use App\Domain\User\ValueObject\Email;
use App\Domain\User\ValueObject\Name;

/**
 * User entity
 */
final class UserEntity
{
    public function __construct(
        private ?int $id,
        private ?int $departmentId,
        private Name $name,
        private Email $email,
        private string $password,
        private bool $isAdmin,
    ) {
        $this->id           = $id;
        $this->departmentId = $departmentId;
        $this->name         = $name;
        $this->email        = $email;
        $this->password     = $password;
        $this->isAdmin      = $isAdmin;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDepartmentId(): ?int
    {
        return $this->departmentId;
    }

    public function getName(): Name
    {
        return $this->name;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getIsAdmin(): bool
    {
        return $this->isAdmin;
    }
}
