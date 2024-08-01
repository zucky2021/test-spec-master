<?php

namespace App\Domain\SpecDocSheet;

/**
 * Interface with external(DB)
 */
interface SpecDocSheetRepositoryInterface
{
    public const TABLE_NAME = 'specification_document_sheets';

    /**
     * 仕様書IDからシートを取得
     *
     * @param int $specDocId
     * @return SpecDocSheetEntity[]
     */
    public function findAllBySpecDocId(int $specDocId): array;
}
