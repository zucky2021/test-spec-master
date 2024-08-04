<?php

namespace App\Domain\SpecDocSheet;

/**
 * Interface with external(DB)
 */
interface SpecDocSheetRepositoryInterface
{
    public const TABLE_NAME = 'specification_document_sheets';

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
     * @return SpecDocSheetEntity[]
     */
    public function findAllBySpecDocId(int $specDocId): array;
}
