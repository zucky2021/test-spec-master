<?php

namespace App\Http\Controllers;

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
    public function index(Request $request, SpecificationDocumentFindAction $specificationDocumentFindAction): Response
    {
        /** @var int 検証済プロジェクトID */
        $projectId = $request->input('projectId');

        $specDocEntities        = $specificationDocumentFindAction->findAllByProjectId($projectId);
        $specificationDocuments = array_map(function ($specDoc) {
            return $specDoc->toArray();
        }, $specDocEntities);

        return Inertia::render('SpecificationDocument/Index', [
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
