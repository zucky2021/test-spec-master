<?php

namespace App\Http\Controllers;

use App\Domain\Project\ProjectFactory;
use App\UseCases\Project\ProjectFindAction;
use Inertia\Inertia;
use Inertia\Response;

class ProjectController extends Controller
{
    /**
     * プロジェクト一覧画面
     *
     * @param \App\UseCases\Project\ProjectFindAction $projectFindAction
     * @return \Inertia\Response
     */
    public function index(ProjectFindAction $projectFindAction): Response
    {
        $projectDtoArr = $projectFindAction->findAll();
        $projects      = array_map(function ($dto) {
            $entity = ProjectFactory::create($dto);

            return $entity->toArray();
        }, $projectDtoArr);

        return Inertia::render('Project/Index', [
            'projects' => $projects,
        ]);
    }
}
