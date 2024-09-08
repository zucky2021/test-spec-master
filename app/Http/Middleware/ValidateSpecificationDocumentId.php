<?php

namespace App\Http\Middleware;

use App\UseCases\SpecificationDocument\SpecificationDocumentFindAction;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ValidateSpecificationDocumentId
{
    private SpecificationDocumentFindAction $specificationDocumentFindAction;

    public function __construct(SpecificationDocumentFindAction $specificationDocumentFindAction)
    {
        $this->specificationDocumentFindAction = $specificationDocumentFindAction;
    }

    /**
     * Handle an incoming request.
     *
     * @param  Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $specDocId = $request->route('specDocId');

        if (
            is_null($specDocId)
            || !is_numeric($specDocId)
            || !$this->specificationDocumentFindAction->exists((int) $specDocId)
        ) {
            abort(404, 'Project not found');
        }

        $request->merge(['specDocId' => (int) $specDocId]);

        return $next($request);
    }
}
