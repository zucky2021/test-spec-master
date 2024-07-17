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
     * @return array
     */
    public function findAllByProjectId(int $projectId): array;
}
