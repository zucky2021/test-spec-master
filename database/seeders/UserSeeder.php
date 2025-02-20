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
                'departmentId' => 1,
                'name'         => 'Admin',
                'email'        => 'admin@example.com',
                'password'     => Hash::make('password'),
                'isAdmin'      => true,
            ],
            [
                'departmentId' => 1,
                'name'         => 'h.suzuki',
                'email'        => 'h.suzuki@example.com',
                'password'     => Hash::make('password'),
                'isAdmin'      => false,
            ],
        ];

        $insertData = [];
        foreach ($values as $val) {
            $dto = new UserDto(
                id: null,
                departmentId: $val['departmentId'],
                name: $val['name'],
                email: $val['email'],
                password: $val['password'],
                isAdmin: $val['isAdmin'],
            );
            $entity       = UserFactory::create($dto);
            $insertData[] = [
                'id'            => $entity->getId(),
                'department_id' => $entity->getDepartmentId(),
                'name'          => $entity->getName()->value(),
                'email'         => $entity->getEmail()->value(),
                'password'      => $entity->getPassword(),
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
