<?php

namespace App\Domain\User;

use App\Domain\User\ValueObject\Email;
use App\Domain\User\ValueObject\Name;

/**
 * User entity
 */
final class UserEntity
{
    private ?int $id;
    private ?int $departmentId;
    private Name $name;
    private Email $email;
    private string $password;

    public function __construct(
        ?int $id,
        ?int $departmentId,
        Name $name,
        Email $email,
        string $password
    ) {
        $this->id = $id;
        $this->departmentId = $departmentId;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
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
}
