<?php

namespace App\Http\Controllers;

use App\UseCases\SpecificationDocument\SpecificationDocumentFindAction;
use App\UseCases\SpecificationDocument\SpecificationFindAction;
use Illuminate\Http\Request;
use Inertia\Inertia;

/**
 * 仕様書Controller
 */
class SpecificationDocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(string $projectId, SpecificationDocumentFindAction $specificationDocumentFindAction)
    {
        $specDocEntities = $specificationDocumentFindAction->findAllByProjectId((int) $projectId);
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
    public function show(Project $project)
    {
        //
    }
}
