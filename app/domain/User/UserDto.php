<?php

namespace App\Domain\User;

/**
 * ユーザーData Transfer Object(データの受け渡し専用クラス)
 */
final class UserDto
{
    public ?int $id;
    public ?int $departmentId;
    public string $name;
    public string $email;
    public string $password;

    public function __construct(
        ?int $id,
        ?int $departmentId,
        string $name,
        string $email,
        string $password,
    ) {
        $this->id           = $id;
        $this->departmentId = $departmentId;
        $this->name         = $name;
        $this->email        = $email;
        $this->password     = $password;
    }
}
