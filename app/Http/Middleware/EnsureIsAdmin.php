<?php

namespace App\Http\Middleware;

use App\UseCases\User\UserFindAction;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * 管理者権限の確認
 */
class EnsureIsAdmin
{
    private UserFindAction $userFindAction;

    public function __construct(UserFindAction $userFindAction)
    {
        $this->userFindAction = $userFindAction;
    }

    /**
     * Handle an incoming request.
     *
     * @param  Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            abort(401, '認証が必要です');
        }

        if (!isset(auth()->user()->id)) {
            abort(500, 'ユーザーIDが見つかりません');
        }

        if (!$this->userFindAction->isAdmin(auth()->user()->id)) {
            abort(403, '管理者権限が必要です');
        }


        return $next($request);
    }
}
