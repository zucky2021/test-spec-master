<?php

namespace App\UseCases\Breadcrumb;

use App\Domain\Breadcrumb\BreadcrumbDto;

final class BreadcrumbFindAction
{
    /**
     * パンクズリスト生成
     *
     * @param int $projectId
     * @param int|null $specDocId
     * @param int|null $specDocSheetId
     * @return BreadcrumbDto[]
     */
    public function generateBreadcrumbs(
        int $projectId,
        ?int $specDocId = null,
        ?int $specDocSheetId = null,
    ): array {
        $breadcrumbs = [];

        $arr[] = new BreadcrumbDto(name: 'Project', url: route('projects.index'));

        $arr[] = new BreadcrumbDto(name: 'Specification document list', url: route('specDocs.index', $projectId));

        if (!empty($specDocId)) {
            $arr[] = new BreadcrumbDto(
                name: 'Spec doc sheet list',
                url: route('specDocSheets.index', [$projectId, $specDocId]),
            );

            if (!empty($specDocSheetId)) {
                $arr[] = new BreadcrumbDto(
                    name: 'Spec doc Sheet',
                    url: route('specDocSheets.show', [$projectId, $specDocId, $specDocSheetId]),
                );
            }
        }

        return $arr;
    }
}
