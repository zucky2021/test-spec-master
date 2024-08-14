<?php

namespace App\Domain\ExecutionEnvironment;

/**
 * Interface with external(DB)
 */
interface ExecutionEnvironmentRepositoryInterface
{
    public const TABLE_NAME = 'execution_environments';

    /**
     * 全ての実施環境を取得
     *
     * @return ExecutionEnvironmentDto[]
     */
    public function findAll(): array;
}
