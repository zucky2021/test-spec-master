<?php

namespace App\Domain\Tester;

interface TesterRepositoryInterface
{
    public const TABLE_NAME = 'testers';

    /**
     * 対象のシートIDからテスターを全て取得
     *
     * @param int $specDocSheetId
     * @return TesterDto[]
     */
    public function findAllBySpecDocSheetId(int $specDocSheetId): array;

    /**
     * テスターIDから全ての取得
     *
     * @param int $userId
     * @return TesterDto[]
     */
    public function findAllByUserId(int $userId): array;

    public function exists(int $id): bool;

    public function store(TesterDto $dto): int;

    public function deleteById(int $id): void;
}
