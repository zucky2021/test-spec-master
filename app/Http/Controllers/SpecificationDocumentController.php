<?php

namespace App\Http\Controllers;

use App\Domain\Breadcrumb\BreadcrumbFactory;
use App\Domain\ExecutionEnvironment\ExecutionEnvironmentFactory;
use App\Domain\Project\ProjectFactory;
use App\Domain\SpecDocSheet\SpecDocSheetFactory;
use App\Domain\SpecificationDocument\SpecificationDocumentDto;
use App\Domain\SpecificationDocument\SpecificationDocumentFactory;
use App\Http\Requests\SpecificationDocumentRequest;
use App\UseCases\Breadcrumb\BreadcrumbFindAction;
use App\UseCases\ExecutionEnvironment\ExecutionEnvironmentFindAction;
use App\UseCases\Project\ProjectFindAction;
use App\UseCases\SpecDocSheet\SpecDocSheetFindAction;
use App\UseCases\SpecificationDocument\SpecificationDocumentDeleteAction;
use App\UseCases\SpecificationDocument\SpecificationDocumentFindAction;
use App\UseCases\SpecificationDocument\SpecificationDocumentStoreAction;
use App\UseCases\SpecificationDocument\SpecificationDocumentUpdateAction;
use DateTimeImmutable;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;

/**
 * 仕様書Controller
 */
class SpecificationDocumentController extends Controller
{
    /**
     * テスト仕様書一覧表示
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\UseCases\Project\ProjectFindAction $projectFindAction
     * @param \App\UseCases\SpecificationDocument\SpecificationDocumentFindAction $specificationDocumentFindAction
     * @return \Inertia\Response
     */
    public function index(
        Request $request,
        ProjectFindAction $projectFindAction,
        SpecificationDocumentFindAction $specificationDocumentFindAction,
        BreadcrumbFindAction $breadcrumbFindAction,
    ): Response {
        /** @var int 検証済プロジェクトID */
        $projectId = $request->input('projectId');

        $projectDto    = $projectFindAction->findById($projectId);
        $projectEntity = !empty($projectDto) ? ProjectFactory::create($projectDto) : null;

        $specDocDtoArr          = $specificationDocumentFindAction->findAllByProjectId($projectId);
        $specificationDocuments = array_map(function ($dto) {
            return SpecificationDocumentFactory::create($dto)->toArray();
        }, $specDocDtoArr);

        $breadcrumbDtoArr = $breadcrumbFindAction->generateBreadcrumbs(projectId: $projectId);
        $breadcrumbs      = array_map(function ($dto) {
            return BreadcrumbFactory::create($dto)->toArray();
        }, $breadcrumbDtoArr);

        return Inertia::render('SpecificationDocument/Index', [
            'project'                => $projectEntity?->toArray(),
            'specificationDocuments' => $specificationDocuments,
            'breadcrumbs'            => $breadcrumbs,
        ]);
    }

    /**
     * 仕様書作成画面
     */
    public function create(Request $request, ProjectFindAction $projectFindAction): Response
    {
        /** @var int 検証済プロジェクトID */
        $projectId = $request->input('projectId');

        $projectDto    = $projectFindAction->findById($projectId);
        $projectEntity = !empty($projectDto) ? ProjectFactory::create($projectDto) : null;

        return Inertia::render('SpecificationDocument/Create', [
            'project' => $projectEntity?->toArray(),
        ]);
    }

    /**
     * 仕様書保存
     */
    public function store(
        SpecificationDocumentRequest $request,
        SpecificationDocumentStoreAction $specificationDocumentStoreAction,
    ): RedirectResponse {
        /** @var int */
        $projectId = $request->input('projectId');
        /** @var int */
        $userId = $request->user()?->id;
        /** @var string */
        $title = $request->validated('title');
        /** @var string */
        $summary = $request->validated('summary');

        $dto = new SpecificationDocumentDto(
            id: null,
            projectId: $projectId,
            userId: $userId,
            title: $title,
            summary: $summary,
            updatedAt: (new DateTimeImmutable())->format('Y-m-d H:i:s'),
        );

        try {
            $specificationDocumentStoreAction->store($dto);
        } catch (Exception $e) {
            Log::error('Failed to create spec doc:' . $e->getMessage() . PHP_EOL . $e->getTraceAsString());

            return redirect()->back()->with('error', 'Please, reload.');
        }

        return redirect()->route('specDocs.index', ['projectId' => $projectId])
            ->with('success', 'Specification document created success.');
    }

    /**
     * 仕様書編集画面
     */
    public function edit(
        Request $request,
        ProjectFindAction $projectFindAction,
        SpecificationDocumentFindAction $specificationDocumentFindAction,
        ExecutionEnvironmentFindAction $executionEnvironmentFindAction,
        SpecDocSheetFindAction $specDocSheetFindAction,
    ): Response {
        /** @var int */
        $projectId = $request->input('projectId');
        /** @var int */
        $specDocId = $request->input('specDocId');

        $projectDto    = $projectFindAction->findById($projectId);
        $projectEntity = !empty($projectDto) ? ProjectFactory::create($projectDto) : null;

        $specDocDto = $specificationDocumentFindAction->findById($specDocId);

        $execEnvDtoArr = $executionEnvironmentFindAction->findAll();
        $execEnvArr    = array_map(function ($dto) {
            $entity = ExecutionEnvironmentFactory::create($dto);

            return $entity->toArray();
        }, $execEnvDtoArr);

        $specDocSheetDtoArr = $specDocSheetFindAction->findAllBySpecDocId($specDocId);
        $specDocSheets      = array_map(function ($dto) {
            $entity = SpecDocSheetFactory::create($dto);

            return $entity->toArray();
        }, $specDocSheetDtoArr);


        return Inertia::render('SpecificationDocument/Edit', [
            'project'               => $projectEntity?->toArray(),
            'specificationDocument' => SpecificationDocumentFactory::create($specDocDto)->toArray(),
            'executionEnvironments' => $execEnvArr,
            'specDocSheets'         => $specDocSheets,
        ]);
    }

    /**
     * 更新
     *
     * @param \App\Http\Requests\SpecificationDocumentRequest $request
     * @param \App\UseCases\SpecificationDocument\SpecificationDocumentFindAction $specificationDocumentFindAction
     * @param \App\UseCases\SpecificationDocument\SpecificationDocumentUpdateAction $specificationDocumentUpdateAction
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(
        SpecificationDocumentRequest $request,
        SpecificationDocumentFindAction $specificationDocumentFindAction,
        SpecificationDocumentUpdateAction $specificationDocumentUpdateAction,
    ): RedirectResponse {
        /** @var int */
        $projectId = $request->input('projectId');
        /** @var int */
        $specDocId = $request->input('specDocId');
        /** @var string */
        $title = $request->validated('title');
        /** @var string */
        $summary = $request->validated('summary');

        $dto          = $specificationDocumentFindAction->findById($specDocId);
        $dto->title   = $title;
        $dto->summary = $summary;

        try {
            $specificationDocumentUpdateAction->update($dto);
        } catch (Exception $e) {
            Log::error('Failed to update spec doc:' . $e->getMessage() . PHP_EOL . $e->getTraceAsString());

            return redirect()->back()->with('error', 'Please, reload.');
        }

        return redirect()->route('specDocs.edit', ['projectId' => $projectId, 'specDocId' => $specDocId])
            ->with('success', 'Specification document updated success.');
    }

    /**
     * 論理削除
     *
     * @param Request $request
     * @param SpecificationDocumentDeleteAction $specificationDocumentDeleteAction
     * @return RedirectResponse
     */
    public function softDelete(
        Request $request,
        SpecificationDocumentDeleteAction $specificationDocumentDeleteAction,
    ): RedirectResponse {
        /** @var int */
        $projectId = $request->input('projectId');
        /** @var int */
        $specDocId = $request->input('specDocId');

        try {
            $specificationDocumentDeleteAction->delete($specDocId);
        } catch (Exception $e) {
            Log::error('Failed to soft delete specification document: ' . $e->getMessage() . PHP_EOL . $e->getTraceAsString());

            return redirect()->back()->with('error', 'Failed to delete.');
        }

        return redirect()->route('specDocs.index', ['projectId' => $projectId])
            ->with('success', 'Specification document delete success');
    }
}
