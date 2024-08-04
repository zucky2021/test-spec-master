<?php

namespace App\Domain\SpecificationDocument;

/**
 * Interface with external(DB)
 */
interface SpecificationDocumentRepositoryInterface
{
    public const TABLE_NAME = 'specification_documents';

    /**
     * プロジェクトIDから仕様書を取得
     *
     * @param int $projectId
     * @return SpecificationDocumentEntity[]
     */
    public function findAllByProjectId(int $projectId): array;

    /**
     * PKの存在確認
     *
     * @param int $specDocId
     * @return bool
     */
    public function exists(int $specDocId): bool;
}
