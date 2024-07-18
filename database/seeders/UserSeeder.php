<?php

namespace Database\Seeders;

use App\Domain\User\UserFactory;
use App\Domain\User\UserRepositoryInterface;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $values = [
            [
                'id' => 1,
                'department_id' => 5,
                'name' => 'h.suzuki',
                'email' => 'h.suzuki@example.com',
                'password' => Hash::make('password'),
            ],
        ];

        $insertData = [];
        foreach ($values as $val) {
            $entity = UserFactory::create($val);
            $insertData[] = [
                'id' => $entity->getId(),
                'department_id' => $entity->getDepartmentId(),
                'name' => $entity->getName()->value(),
                'email' => $entity->getEmail()->value(),
                'password' => $entity->getPassword(),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table(UserRepositoryInterface::TABLE_NAME)->insert($insertData);
    }
}
