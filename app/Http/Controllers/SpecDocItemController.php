<?php

namespace App\Http\Controllers;

use App\Domain\SpecDocItem\SpecDocItemDto;
use App\Domain\SpecDocItem\ValueObject\StatusId;
use App\Http\Requests\SpecDocItemRequest;
use App\UseCases\SpecDocItem\SpecDocItemDeleteAction;
use App\UseCases\SpecDocItem\SpecDocItemFindAction;
use App\UseCases\SpecDocItem\SpecDocItemStoreAction;
use App\UseCases\SpecDocItem\SpecDocItemUpdateAction;
use App\UseCases\SpecDocSheet\SpecDocSheetFindAction;
use App\UseCases\SpecDocSheet\SpecDocSheetUpdateAction;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SpecDocItemController extends Controller
{
    /**
     * 更新(削除＆新規作成)処理
     *
     * @param \App\Http\Requests\SpecDocItemRequest $request
     * @param \App\UseCases\SpecDocSheet\SpecDocSheetFindAction $specDocSheetFindAction
     * @param \App\UseCases\SpecDocSheet\SpecDocSheetUpdateAction $specDocSheetUpdateAction
     * @param \App\UseCases\SpecDocItem\SpecDocItemDeleteAction $specDocItemDeleteAction
     * @param \App\UseCases\SpecDocItem\SpecDocItemStoreAction $specDocItemStoreAction
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(
        SpecDocItemRequest $request,
        SpecDocSheetFindAction $specDocSheetFindAction,
        SpecDocSheetUpdateAction $specDocSheetUpdateAction,
        SpecDocItemDeleteAction $specDocItemDeleteAction,
        SpecDocItemStoreAction $specDocItemStoreAction,
    ): RedirectResponse {
        /** @var int */
        $specDocSheetId = $request->input('specDocSheetId');

        /** @var array{ targetArea: string, checkDetail: string, remark: ?string }[] */
        $inputItems = $request->input('items');

        $specDocSheetDto = $specDocSheetFindAction->findById($specDocSheetId);

        $specDocItemDtoArr = array_map(function ($value) use ($specDocSheetId) {
            return new SpecDocItemDto(
                id: null,
                specDocSheetId: $specDocSheetId,
                targetArea: $value['targetArea'],
                checkDetail: $value['checkDetail'],
                remark: $value['remark'],
                statusId: StatusId::PENDING,
            );
        }, $inputItems);

        try {
            DB::transaction(function () use (
                $specDocItemDeleteAction,
                $specDocSheetId,
                $specDocItemStoreAction,
                $specDocItemDtoArr,
                $specDocSheetUpdateAction,
                $specDocSheetDto
            ) {
                $specDocItemDeleteAction->deleteAllBySheetId($specDocSheetId);
                $specDocItemStoreAction->store($specDocItemDtoArr);
                $specDocSheetUpdateAction->update($specDocSheetDto);
            });
        } catch (Exception $e) {
            Log::error($e->getMessage());

            return redirect()->back()->with([
                'error' => 'Failed to save.',
            ]);
        }

        return redirect()->back()->with([
            'success' => 'Success save.',
        ]);
    }

    /**
     * 単一更新処理
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\UseCases\SpecDocItem\SpecDocItemFindAction $specDocItemFindAction
     * @param \App\UseCases\SpecDocItem\SpecDocItemUpdateAction $specDocItemUpdateAction
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(
        Request $request,
        SpecDocItemFindAction $specDocItemFindAction,
        SpecDocItemUpdateAction $specDocItemUpdateAction,
    ): JsonResponse {
        /** @var int */
        $specDocItemId = $request->input('specDocItemId');

        $specDocItemDto = $specDocItemFindAction->findById($specDocItemId);

        $newStatusId = ($specDocItemDto->statusId + 1) % count(StatusId::STATUSES);

        $specDocItemDto->statusId = $newStatusId;

        try {
            $specDocItemUpdateAction->update($specDocItemDto);
        } catch (Exception $e) {
            Log::error('Failed to toggle status:' . $e->getMessage());

            return response()->json([], 500);
        }

        return response()->json([
            'newStatusId' => $newStatusId,
        ], 200);
    }
}
