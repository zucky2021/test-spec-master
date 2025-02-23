<?php

namespace App\Http\Controllers\Admin;

use App\Domain\Project\ProjectDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProjectStoreRequest;
use App\Http\Requests\Admin\ProjectUpdateRequest;
use App\UseCases\Department\DepartmentFindAction;
use App\UseCases\Project\ProjectFindAction;
use App\UseCases\Project\ProjectStoreAction;
use App\UseCases\Project\ProjectUpdateAction;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;

/**
 * 管理者プロジェクト
 */
class ProjectController extends Controller
{
    /**
     * プロジェクト一覧
     *
     * @return Response
     */
    public function index(ProjectFindAction $projectFindAction, DepartmentFindAction $departmentFindAction): Response
    {
        return Inertia::render('Admin/Project/Index', [
            'projects'    => $projectFindAction->findAll(),
            'departments' => $departmentFindAction->findAll(),
        ]);
    }

    public function store(
        ProjectStoreRequest $request,
        ProjectStoreAction $projectStoreAction,
    ): RedirectResponse {
        /** @var int */
        $departmentId = $request->validated('departmentId');
        /** @var string */
        $name = $request->validated('name');
        /** @var string */
        $summary = $request->validated('summary');

        $dto = new ProjectDto(
            id: null,
            departmentId: $departmentId,
            name: $name,
            summary: $summary,
        );

        try {
            $projectStoreAction->store($dto);
        } catch (Exception $e) {
            Log::error('Failed to create project: ' . $e->getMessage() . PHP_EOL . $e->getTraceAsString());

            return redirect()->back()->with('error', 'Failed to create project');
        }

        return redirect()->back()->with('success', 'Created project');
    }

    public function update(
        ProjectUpdateRequest $request,
        ProjectUpdateAction $projectUpdateAction,
    ): RedirectResponse {
        /** @var int */
        $projectId = $request->validated('id');
        /** @var int */
        $departmentId = $request->validated('departmentId');
        /** @var string */
        $name = $request->validated('name');
        /** @var string */
        $summary = $request->validated('summary');

        $dto = new ProjectDto(
            id: $projectId,
            departmentId: $departmentId,
            name: $name,
            summary: $summary,
        );

        try {
            $projectUpdateAction->update($dto);
        } catch (Exception $e) {
            Log::error('Failed to create project: ' . $e->getMessage() . PHP_EOL . $e->getTraceAsString());

            return redirect()->back()->with('error', 'Failed to update project');
        }

        return redirect()->back()->with('success', 'Updated project');
    }
}
