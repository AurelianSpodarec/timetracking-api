<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectStoreRequest;
use App\Http\Requests\ProjectUpdateRequest;
use App\Models\Project;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Inertia\Response;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $projects = Project::all();

        return inertia('project/index', [
            'projects' =>  $projects,
        ]);
    }

    public function create(Request $request): Response
    {
        return inertia('project/create');
    }

    public function store(ProjectStoreRequest $request): RedirectResponse
    {
        $project = Project::create($request->validated());

        $request->session()->flash('project.id', $project->id);

        return redirect()->route('projects.index');
    }

    public function show(Request $request, Project $project): Response
    {
        return inertia('project/index', [
            'project' =>  $project,
        ]);
    }

    public function edit(Request $request, Project $project): Response
    {
        return inertia('project/edit', [
            'project' =>  $project,
        ]);
    }

    public function update(ProjectUpdateRequest $request, Project $project): RedirectResponse
    {
        $project->update($request->validated());

        $request->session()->flash('project.id', $project->id);

        return redirect()->route('projects');
    }

    public function destroy(Request $request, Project $project): RedirectResponse
    {
        $project->delete();

        return redirect()->route('projects');
    }
}
