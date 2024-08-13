<?php

namespace App\Http\Controllers\SpecDocSheet;

use App\Domain\SpecificationDocument\SpecificationDocumentFactory;
use App\Http\Controllers\Controller;
use App\UseCases\SpecDocSheet\SpecDocSheetFindAction;
use App\UseCases\SpecificationDocument\SpecificationDocumentFindAction;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class IndexController extends Controller
{
    /**
     * シート一覧(仕様書詳細)画面
     *
     * @return Response
     */
    public function index(
        Request $request,
        SpecificationDocumentFindAction $specificationDocumentFindAction,
        SpecDocSheetFindAction $specDocSheetFindAction,
    ): Response {
        /** @var int 検証済仕様書ID */
        $specDocId = $request->input('specDocId');

        $specDocDto = $specificationDocumentFindAction->findById($specDocId);

        $specDocSheetEntities = $specDocSheetFindAction->findAllBySpecDocId($specDocId);
        $specDocSheets        = array_map(function ($specDocSheet) {
            return $specDocSheet->toArray();
        }, $specDocSheetEntities);

        return Inertia::render('SpecDocSheet/Index', [
            'specDoc'       => SpecificationDocumentFactory::create($specDocDto)->toArray(),
            'specDocSheets' => $specDocSheets,
        ]);
    }
}
