<?php

namespace App\Http\Controllers;

use App\Domain\Project\ProjectFactory;
use App\Domain\SpecificationDocument\SpecificationDocumentFactory;
use App\UseCases\Project\ProjectFindAction;
use App\UseCases\SpecificationDocument\SpecificationDocumentFindAction;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

/**
 * 仕様書Controller
 */
class SpecificationDocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(
        Request $request,
        ProjectFindAction $projectFindAction,
        SpecificationDocumentFindAction $specificationDocumentFindAction,
    ): Response {
        /** @var int 検証済プロジェクトID */
        $projectId = $request->input('projectId');

        $projectDto    = $projectFindAction->findById($projectId);
        $projectEntity = !empty($projectDto) ? ProjectFactory::create($projectDto) : null;

        $specDocDtoArr          = $specificationDocumentFindAction->findAllByProjectId($projectId);
        $specificationDocuments = array_map(function ($dto) {
            $entity = SpecificationDocumentFactory::create($dto);

            return $entity->toArray();
        }, $specDocDtoArr);

        return Inertia::render('SpecificationDocument/Index', [
            'project'                => $projectEntity?->toArray(),
            'specificationDocuments' => $specificationDocuments,
        ]);
    }

    /**
     * Display the specified resource.
     */
    // public function show(Project $project)
    // {
    //     //
    // }
}
