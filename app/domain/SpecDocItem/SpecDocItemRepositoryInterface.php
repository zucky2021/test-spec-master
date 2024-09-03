<?php

namespace App\Domain\SpecDocItem;

/**
 * Interface with external(DB)
 */
interface SpecDocItemRepositoryInterface
{
    public const TABLE_NAME = 'specification_document_items';

    /**
     * シートIDから全ての項目を取得
     *
     * @param int $specDocSheetId
     * @return SpecDocItemDto[]
     */
    public function findAllBySpecDocSheetId(int $specDocSheetId): array;

    /**
     * 複数の項目を登録
     *
     * @param SpecDocItemDto[] $dtoArr
     * @return void
     */
    public function store(array $dtoArr): void;

    /**
     * シートIdから全ての項目を削除
     *
     * @param int $specDocSheetId
     * @return void
     */
    public function deleteAllBySheetId(int $specDocSheetId): void;
}
