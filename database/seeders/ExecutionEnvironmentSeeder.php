<?php

namespace Database\Seeders;

use App\Domain\ExecutionEnvironment\ExecutionEnvironmentDto;
use App\Domain\ExecutionEnvironment\ExecutionEnvironmentFactory;
use App\Domain\ExecutionEnvironment\ExecutionEnvironmentRepositoryInterface;
use Exception;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ExecutionEnvironmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $values = [
            [
                'name'       => 'PC(Chrome)',
                'order_num'  => 1,
                'is_display' => true,
            ],
            [
                'name'       => 'iPhone(Safari)',
                'order_num'  => 2,
                'is_display' => true,
            ],
            [
                'name'       => 'Android(Chrome)',
                'order_num'  => 3,
                'is_display' => true,
            ],
        ];

        $insertData = [];
        foreach ($values as $val) {
            $dto = new ExecutionEnvironmentDto(
                id: null,
                name: $val['name'],
                orderNum: $val['order_num'],
                isDisplay: $val['is_display'],
            );
            $entity       = ExecutionEnvironmentFactory::create($dto);
            $insertData[] = [
                'name'       => $entity->getName()->value(),
                'order_num'  => $entity->getOrderNum()->value(),
                'is_display' => $entity->getIsDisplay(),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        try {
            DB::table(ExecutionEnvironmentRepositoryInterface::TABLE_NAME)->insert($insertData);
        } catch (Exception $e) {
            Log::error('Failed to insert: ' . $e->getMessage());
        }
    }
}
