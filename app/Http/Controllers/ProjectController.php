<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\View\View;

class ProjectController extends Controller
{
    public function index(): View
    {
        return view('projects', ['projects' => Project::latest()->get()]);
    }

    public function show(Project $project): View
    {
        return view('project-detail', compact('project'));
    }
}
