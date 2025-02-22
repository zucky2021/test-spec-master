<?php

namespace App\Http\Controllers\Ajax\Admin;

use App\Domain\User\UserFactory;
use App\Http\Controllers\Controller;
use App\UseCases\User\UserFindAction;
use App\UseCases\User\UserUpdateAction;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

final class UserController extends Controller
{
    /**
     * ユーザーの一覧を取得
     *
     * @return JsonResponse
     */
    public function index(UserFindAction $userFindAction): JsonResponse
    {
        $userDtoArr = $userFindAction->findAll();
        $users      = array_map(function ($dto) {
            return UserFactory::create($dto)->toArray();
        }, $userDtoArr);

        return response()->json(['users' => $users], 200);
    }

    public function update(Request $request, UserUpdateAction $userUpdateAction): JsonResponse
    {
        /** @var int */
        $userId = $request->input('user_id');
        /** @var bool */
        $newIsAdmin = $request->input('is_admin');

        try {
            $userUpdateAction->updateIsAdmin($userId, $newIsAdmin);
        } catch (Exception $err) {
            Log::error($err->getMessage());

            return response()->json([], 400);
        }

        return response()->json([], 200);
    }
}
