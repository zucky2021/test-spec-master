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
        if (!auth()->check() || !isset(auth()->user()->id) || !$this->userFindAction->isAdmin(auth()->user()->id)) {
            abort(404, 'Invalid user');
        }

        return $next($request);
    }
}
