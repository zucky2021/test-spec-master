<?php

namespace App\Domain\User;

/**
 * ユーザーData Transfer Object(データの受け渡し専用クラス)
 */
final class UserDto
{
    public function __construct(
        public ?int $id,
        public ?int $departmentId,
        public string $name,
        public string $email,
        public string $password,
    ) {
        $this->id           = $id;
        $this->departmentId = $departmentId;
        $this->name         = $name;
        $this->email        = $email;
        $this->password     = $password;
    }
}
