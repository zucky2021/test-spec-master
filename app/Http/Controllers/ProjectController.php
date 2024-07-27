<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\UseCases\Project\ProjectFindAction;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ProjectFindAction $projectFindAction)
    {
        $projectEntities = $projectFindAction->findAll();
        $projects        = array_map(function ($project) {
            return $project->toArray();
        }, $projectEntities);

        return Inertia::render('Project/Index', [
            'projects' => $projects,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    // public function show(Project $project)
    // {
    //     //
    // }

    /**
     * Show the form for editing the specified resource.
     */
    // public function edit(Project $project)
    // {
    //     //
    // }

    /**
     * Update the specified resource in storage.
     */
    // public function update(Request $request, Project $project)
    // {
    //     //
    // }

    /**
     * Remove the specified resource from storage.
     */
    // public function destroy(Project $project)
    // {
    //     //
    // }
}
