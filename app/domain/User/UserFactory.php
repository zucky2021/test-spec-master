<?php

namespace App\Domain\User;

use App\Domain\User\ValueObject\Email;
use App\Domain\User\ValueObject\Name;

/**
 * Generate user domain object.
 */
final class UserFactory
{
    public static function create(UserDto $dto): UserEntity
    {
        return new UserEntity(
            $dto->id,
            $dto->departmentId,
            new Name($dto->name),
            new Email($dto->email),
            $dto->password,
        );
    }
}
