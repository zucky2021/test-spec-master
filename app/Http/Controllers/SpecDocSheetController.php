<?php

namespace App\Http\Controllers;

use App\Domain\SpecDocItem\SpecDocItemFactory;
use App\Domain\SpecDocSheet\SpecDocSheetDto;
use App\Domain\SpecDocSheet\SpecDocSheetFactory;
use App\Domain\SpecificationDocument\SpecificationDocumentFactory;
use App\Http\Requests\SpecDocSheetRequest;
use App\UseCases\SpecDocItem\SpecDocItemFindAction;
use App\UseCases\SpecDocSheet\SpecDocSheetDeleteAction;
use App\UseCases\SpecDocSheet\SpecDocSheetFindAction;
use App\UseCases\SpecDocSheet\SpecDocSheetStoreAction;
use App\UseCases\SpecificationDocument\SpecificationDocumentFindAction;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;

class SpecDocSheetController extends Controller
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

        $specDocSheetDtoArr = $specDocSheetFindAction->findAllBySpecDocId($specDocId);
        $specDocSheets      = array_map(function ($dto) {
            $entity = SpecDocSheetFactory::create($dto);

            return $entity->toArray();
        }, $specDocSheetDtoArr);

        return Inertia::render('SpecDocSheet/Index', [
            'specDoc'       => SpecificationDocumentFactory::create($specDocDto)->toArray(),
            'specDocSheets' => $specDocSheets,
        ]);
    }

    public function store(
        // Request $request,
        SpecDocSheetRequest $request,
        SpecDocSheetStoreAction $specDocSheetStoreAction,
    ): JsonResponse {
        /** @var int */
        $specDocId = $request->input('specDocId');
        /** @var int */
        $execEnvId = $request->validated('exec_env_id');

        $dto = new SpecDocSheetDto(
            id: null,
            specDocId: $specDocId,
            execEnvId: $execEnvId,
            statusId: 0,
            updatedAt: 'now',
        );
        try {
            $newSheetId = $specDocSheetStoreAction->store($dto);
        } catch (Exception $e) {
            Log::error('Failed to create spec doc:' . $e->getMessage() . PHP_EOL . $e->getTraceAsString());

            return response()->json(
                [
                    'message' => 'Failed to create spec doc sheet.',
                ],
                500,
            );
        }

        return response()->json([
            'message'           => 'Success create spec doc sheet.',
            'newSpecDocSheetId' => $newSheetId,
        ], 200);
    }

    /**
     * シート編集画面
     *
     * @param Request $request
     * @param SpecificationDocumentFindAction $specificationDocumentFindAction
     * @param SpecDocSheetFindAction $specDocSheetFindAction
     * @return Response
     */
    public function edit(
        Request $request,
        SpecificationDocumentFindAction $specificationDocumentFindAction,
        SpecDocSheetFindAction $specDocSheetFindAction,
        SpecDocItemFindAction $specDocItemFindAction,
    ): Response {
        /** @var int */
        $specDocId = $request->input('specDocId');
        /** @var int */
        $specDocSheetId = $request->input('specDocSheetId');

        $specDocDto        = $specificationDocumentFindAction->findById($specDocId);
        $specDocSheetDto   = $specDocSheetFindAction->findById($specDocSheetId);
        $specDocItemDtoArr = $specDocItemFindAction->findAllBySpecDocSheetId($specDocSheetId);

        $specDocItems = array_map(function ($dto) {
            return SpecDocItemFactory::create($dto)->toArray();
        }, $specDocItemDtoArr);

        return Inertia::render('SpecDocSheet/Edit', [
            'specDoc'      => SpecificationDocumentFactory::create($specDocDto)->toArray(),
            'specDocSheet' => SpecDocSheetFactory::create($specDocSheetDto)->toArray(),
            'specDocItems' => $specDocItems,
        ]);
    }

    /**
     * シート削除処理
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\UseCases\SpecDocSheet\SpecDocSheetDeleteAction $specDocSheetDeleteAction
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(
        Request $request,
        SpecDocSheetDeleteAction $specDocSheetDeleteAction,
    ): JsonResponse {
        /** @var int */
        $specDocSheetId = $request->input('specDocSheetId');

        try {
            $specDocSheetDeleteAction->deleteById($specDocSheetId);
        } catch (Exception $e) {
            Log::error('Failed to delete spec doc:' . $e->getMessage() . PHP_EOL . $e->getTraceAsString());

            return response()->json([
                'message' => 'Failed to delete spec soc sheet.',
            ], 500);
        }

        return response()->json([
            'message' => 'Success delete spec doc sheet.',
        ], 200);
    }
}
