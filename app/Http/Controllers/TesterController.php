<?php

namespace App\Http\Controllers;

use App\Domain\Tester\TesterDto;
use App\Domain\Tester\TesterFactory;
use App\Models\User;
use App\UseCases\Tester\TesterDeleteAction;
use App\UseCases\Tester\TesterFindAction;
use App\UseCases\Tester\TesterStoreAction;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TesterController extends Controller
{
    /**
     * 一覧取得
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\UseCases\Tester\TesterFindAction $testerFindAction
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(
        Request $request,
        TesterFindAction $testerFindAction,
    ): JsonResponse {
        /** @var int */
        $specDocSheetId = $request->input('specDocSheetId');

        $testerDtoArr = $testerFindAction->findAllBySpecDocSheetId($specDocSheetId);
        $testers      = array_map(function ($dto) {
            return TesterFactory::create($dto)->toArray();
        }, $testerDtoArr);

        return response()->json([
            'testers' => $testers,
        ], 200);
    }

    /**
     * 新規登録
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\UseCases\Tester\TesterStoreAction $testerStoreAction
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(
        Request $request,
        TesterStoreAction $testerStoreAction,
    ): JsonResponse {
        $user = $request->user();
        assert($user instanceof User);

        /** @var int */
        $specDocSheetId = $request->input('specDocSheetId');

        $testerDto = new TesterDto(
            id: null,
            userId: $user->id,
            specDocSheetId: $specDocSheetId,
            createdAt: 'now',
        );

        try {
            $newTesterId = $testerStoreAction->store($testerDto);
        } catch (Exception $e) {
            Log::error("Failed to store tester: " . $e->getMessage());

            return response()->json([], 400);
        }

        return response()->json([
            'newTesterId' => $newTesterId,
        ], 200);
    }

    /**
     * 物理削除
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\UseCases\Tester\TesterDeleteAction $testerDeleteAction
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(
        Request $request,
        TesterDeleteAction $testerDeleteAction,
    ): JsonResponse {
        /** @var int */
        $testerId = $request->input('testerId');

        try {
            $testerDeleteAction->deleteById($testerId);
        } catch (Exception $e) {
            Log::error('Failed to delete tester: ' . $e->getMessage());

            return response()->json([], 400);
        }

        return response()->json([], 200);
    }
}
