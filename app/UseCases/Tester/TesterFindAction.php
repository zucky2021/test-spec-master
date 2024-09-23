<?php

namespace App\UseCases\Tester;

use App\Domain\Tester\TesterDto;
use App\Domain\Tester\TesterRepositoryInterface;

final class TesterFindAction
{
    private TesterRepositoryInterface $repository;

    public function __construct(TesterRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * 対象のシートのテスターを全て取得
     *
     * @param int $specDocSheetId
     * @return TesterDto[]
     */
    public function findAllBySpecDocSheetId(int $specDocSheetId): array
    {
        return $this->repository->findAllBySpecDocSheetId($specDocSheetId);
    }

    /**
     * テスターIDから全てのレコードを取得
     *
     * @param int $userId
     * @return TesterDto[]
     */
    public function findAllByUserId(int $userId): array
    {
        return $this->repository->findAllByUserId($userId);
    }

    public function exists(int $id): bool
    {
        return $this->repository->exists($id);
    }
}
