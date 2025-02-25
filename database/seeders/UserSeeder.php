<?php

namespace Database\Seeders;

use App\Domain\User\UserDto;
use App\Domain\User\UserFactory;
use App\Domain\User\UserRepositoryInterface;
use Exception;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $values = [
            [
                'department_id' => 1,
                'name'          => 'Admin',
                'email'         => 'admin@example.com',
                'password'      => Hash::make('password'),
                'is_admin'      => true,
            ],
            [
                'department_id' => 1,
                'name'          => 'Not admin',
                'email'         => 'not.admin@example.com',
                'password'      => Hash::make('password'),
                'is_admin'      => false,
            ],
        ];

        $insertData = [];
        foreach ($values as $val) {
            $dto = new UserDto(
                id: null,
                departmentId: $val['department_id'],
                name: $val['name'],
                email: $val['email'],
                password: $val['password'],
                isAdmin: $val['is_admin'],
            );
            $entity       = UserFactory::create($dto);
            $insertData[] = [
                'id'            => $entity->getId(),
                'department_id' => $entity->getDepartmentId(),
                'name'          => $entity->getName()->value(),
                'email'         => $entity->getEmail()->value(),
                'password'      => $entity->getPassword(),
                'is_admin'      => $entity->getIsAdmin(),
                'created_at'    => now(),
                'updated_at'    => now(),
            ];
        }

        try {
            DB::table(UserRepositoryInterface::TABLE_NAME)->insert($insertData);
        } catch (Exception $e) {
            Log::error('Failed to insert: ' . $e->getMessage());
        }
    }
}
