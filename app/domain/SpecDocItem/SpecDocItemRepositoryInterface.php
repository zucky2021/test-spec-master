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
}
