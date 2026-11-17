<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Project;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::with(['client', 'industry'])
            ->orderBy('sort_order')
            ->paginate(9);

        return view('frontend.pages.projects.index')->with(['projects' => $projects]);
    }

    public function show(Project $project)
    {
        $project->load(['client', 'industry', 'services', 'caseStudies', 'seo']);

        return view('frontend.pages.projects.single')->with(['project' => $project]);
    }
}
