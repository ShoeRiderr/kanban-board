<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\View\View;

class ProjectController extends Controller
{
    public function index(): View
    {
        return view('modules.projects.index');
    }

    public function create(): View
    {
        return view('modules.projects.create');
    }

    public function edit(Project $project): View
    {
        return view('modules.projects.edit', [
            'project' => $project,
        ]);
    }
}
