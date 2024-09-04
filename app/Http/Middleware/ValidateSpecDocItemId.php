<?php

namespace App\Http\Middleware;

use App\UseCases\SpecDocItem\SpecDocItemFindAction;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ValidateSpecDocItemId
{
    private SpecDocItemFindAction $specDocItemFindAction;

    public function __construct(SpecDocItemFindAction $specDocItemFindAction)
    {
        $this->specDocItemFindAction = $specDocItemFindAction;
    }

    /**
     * Handle an incoming request.
     *
     * @param  Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $specDocItemId = $request->route('specDocItemId');

        if (
            is_null($specDocItemId)
            || !is_numeric($specDocItemId)
            || !$this->specDocItemFindAction->exists((int) $specDocItemId)
        ) {
            abort(404, 'Specification document item not found.');
        }

        $request->merge(['specDocItemId' => (int) $specDocItemId]);

        return $next($request);
    }
}
