<?php

namespace App\Http\Controllers;

use App\UseCases\Project\ProjectFindAction;
use Inertia\Inertia;
use Inertia\Response;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(ProjectFindAction $projectFindAction): Response
    {
        $projectEntities = $projectFindAction->findAll();
        $projects        = array_map(function ($project) {
            return $project->toArray();
        }, $projectEntities);

        return Inertia::render('Project/Index', [
            'projects' => $projects,
        ]);
    }
}
