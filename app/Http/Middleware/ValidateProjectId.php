<?php

namespace App\Http\Middleware;

use App\UseCases\Project\ProjectFindAction;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ValidateProjectId
{
    protected ProjectFindAction $projectFindAction;

    public function __construct(ProjectFindAction $projectFindAction)
    {
        $this->projectFindAction = $projectFindAction;
    }

    /**
     * Handle an incoming request.
     *
     * @param  Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $projectId = $request->route('projectId');

        if (
            is_null($projectId)
            || !is_numeric($projectId)
            || !$this->projectFindAction->exists((int) $projectId)
        ) {
            abort(404, 'Project not found');
        }

        $request->merge(['projectId' => (int) $projectId]);

        return $next($request);
    }
}
