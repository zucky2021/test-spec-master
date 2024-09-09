<?php

namespace App\Http\Middleware;

use App\UseCases\Tester\TesterFindAction;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ValidateTesterId
{
    private TesterFindAction $testerFindAction;

    public function __construct(TesterFindAction $testerFindAction)
    {
        $this->testerFindAction = $testerFindAction;
    }

    /**
     * Handle an incoming request.
     *
     * @param  Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $testerId = $request->route('testerId');

        if (
            is_null($testerId)
            || !is_numeric($testerId)
            || !$this->testerFindAction->exists((int) $testerId)
        ) {
            abort(404, 'Tester not found');
        }

        $request->merge(['testerId' => (int) $testerId]);

        return $next($request);
    }
}
