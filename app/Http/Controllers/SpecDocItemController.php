<?php

namespace App\Http\Controllers;

use App\Domain\SpecDocItem\SpecDocItemDto;
use App\Domain\SpecDocItem\ValueObject\StatusId;
use App\Http\Requests\SpecDocItemRequest;
use App\UseCases\SpecDocItem\SpecDocItemDeleteAction;
use App\UseCases\SpecDocItem\SpecDocItemStoreAction;
use App\UseCases\SpecDocSheet\SpecDocSheetFindAction;
use App\UseCases\SpecDocSheet\SpecDocSheetUpdateAction;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SpecDocItemController extends Controller
{
    /**
     * 実施画面
     */
    // public function index(): void
    // {
    //     //
    // }

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
    public function update(
        SpecDocItemRequest $request,
        SpecDocSheetFindAction $specDocSheetFindAction,
        SpecDocSheetUpdateAction $specDocSheetUpdateAction,
        SpecDocItemDeleteAction $specDocItemDeleteAction,
        SpecDocItemStoreAction $specDocItemStoreAction,
    ): RedirectResponse {
        $projectId = $request->input('projectId');
        /** @var int */
        $specDocId = $request->input('specDocId');
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
                statusId: array_key_first(StatusId::STATUSES),
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
}
