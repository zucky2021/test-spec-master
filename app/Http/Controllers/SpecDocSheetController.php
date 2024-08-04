<?php

namespace App\Http\Controllers;

use App\UseCases\SpecDocSheet\SpecDocSheetFindAction;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class SpecDocSheetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request, SpecDocSheetFindAction $specDocSheetFindAction): Response
    {
        /** @var int 検証済仕様書ID */
        $specDocId = $request->input('specDocId');

        $specDocSheetEntities = $specDocSheetFindAction->findAllBySpecDocId($specDocId);
        $specDocSheets        = array_map(function ($specDocSheet) {
            return $specDocSheet->toArray();
        }, $specDocSheetEntities);

        return Inertia::render('SpecDocSheet/Index', [
            'specDocSheets' => $specDocSheets,
        ]);
    }
}
