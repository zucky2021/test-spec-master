<?php

namespace App\Http\Middleware;

use App\UseCases\SpecDocSheet\SpecDocSheetFindAction;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ValidateSpecDocSheetId
{
    private SpecDocSheetFindAction $specDocSheetFindAction;

    public function __construct(SpecDocSheetFindAction $specDocSheetFindAction)
    {
        $this->specDocSheetFindAction = $specDocSheetFindAction;
    }

    /**
     * Handle an incoming request.
     *
     * @param  Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $specDocSheetId = $request->route('specDocSheetId');

        if (
            is_null($specDocSheetId)
            || !is_numeric($specDocSheetId)
            || !$this->specDocSheetFindAction->exists((int) $specDocSheetId)
        ) {
            abort(404, 'Specification document sheet not found.');
        }

        $request->merge(['specDocSheetId' => (int) $specDocSheetId]);

        return $next($request);
    }
}
