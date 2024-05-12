<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectStoreRequest;
use App\Http\Requests\ProjectUpdateRequest;
use App\Models\Project;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $projects = Project::all();

        return inertia('project/index', [
            'projects' =>  $projects,
        ]);
    }

    public function create(Request $request): View
    {
        return view('project.create');
    }

    public function store(ProjectStoreRequest $request): RedirectResponse
    {
        $project = Project::create($request->validated());

        $request->session()->flash('project.id', $project->id);

        return redirect()->route('projects.index');
    }

    public function show(Request $request, Project $project): View
    {
        return inertia('project/index', [
            'projects' =>  $projects,
        ]);
    }

    public function edit(Request $request, Project $project): View
    {
        return inertia('project/edit', [
            'projects' =>  $projects,
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
