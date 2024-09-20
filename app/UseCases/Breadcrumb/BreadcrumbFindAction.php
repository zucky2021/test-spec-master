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
     * @return BreadcrumbDto[]
     */
    public function generateBreadcrumbs(
        int $projectId,
        ?int $specDocId = null,
    ): array {
        /** @var array{ name: string, url: string }[] */
        $arr = [
            [
                'name' => 'Projects',
                'url'  => route('projects.index'),
            ],
        ];

        $arr[] = [
            'name' => 'Specification document list',
            'url'  => route('specDocs.index', $projectId),
        ];

        if (!empty($specDocId)) {
            $arr[] = [
                'name' => 'Spec doc sheet list',
                'url'  => route('specDocSheets.index', [$projectId, $specDocId]),
            ];
        }

        return array_map(function ($val) {
            return new BreadcrumbDto(
                name: $val['name'],
                url: $val['url'],
            );
        }, $arr);
    }
}
