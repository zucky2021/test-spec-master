<?php

namespace App\Http\Controllers;

use App\UseCases\SpecificationDocument\SpecificationDocumentFindAction;
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
    public function index(string $projectId, SpecificationDocumentFindAction $specificationDocumentFindAction): Response
    {
        $specDocEntities        = $specificationDocumentFindAction->findAllByProjectId((int) $projectId);
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
