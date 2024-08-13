<?php

namespace App\Domain\SpecificationDocument;

/**
 * Interface with external(DB)
 */
interface SpecificationDocumentRepositoryInterface
{
    public const TABLE_NAME = 'specification_documents';

    /**
     * PKから仕様書entityを取得
     *
     * @param int $id
     * @return \App\Domain\SpecificationDocument\SpecificationDocumentDto
     */
    public function findById(int $id): SpecificationDocumentDto;

    /**
     * プロジェクトIDから仕様書を取得
     *
     * @param int $projectId
     * @return \App\Domain\SpecificationDocument\SpecificationDocumentDto[]
     */
    public function findAllByProjectId(int $projectId): array;

    /**
     * PKの存在確認
     *
     * @param int $id
     * @return bool
     */
    public function exists(int $id): bool;

    /**
     * 新規登録
     *
     * @param \App\Domain\SpecificationDocument\SpecificationDocumentDto $dto
     * @return int 新規PK
     */
    public function store(SpecificationDocumentDto $dto): int;
}
