<?php

namespace App\Domain\SpecDocSheet;

/**
 * Interface with external(DB)
 */
interface SpecDocSheetRepositoryInterface
{
    public const TABLE_NAME = 'specification_document_sheets';

    public function exists(int $id): bool;

    /**
     * PKからシートを取得
     *
     * @param int $specDocSheetId
     * @return SpecDocSheetEntity
     */
    public function findAllById(int $specDocSheetId): SpecDocSheetEntity;

    /**
     * 仕様書IDからシートを全て取得
     *
     * @param int $specDocId
     * @return SpecDocSheetDto[]
     */
    public function findAllBySpecDocId(int $specDocId): array;

    /**
     * 新規作成
     *
     * @param \App\Domain\SpecDocSheet\SpecDocSheetDto $dto
     * @return int
     */
    public function store(SpecDocSheetDto $dto): int;

    public function deleteById(int $id): void;
}
