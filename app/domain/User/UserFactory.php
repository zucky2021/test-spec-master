<?php

namespace App\Domain\User;

use App\Domain\User\ValueObject\Email;
use App\Domain\User\ValueObject\Name;

/**
 * Generate user domain object.
 */
final class UserFactory
{
    public static function create(array $data): UserEntity
    {
        return new UserEntity(
            isset($data['id']) ? (int)$data['id'] : null,
            isset($data['department_id']) ? (int)$data['department_id'] : null,
            new Name($data['name']),
            new Email($data['email']),
            $data['password']
        );
    }
}
