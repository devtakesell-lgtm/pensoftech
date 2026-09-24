<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = \App\Models\Project::with(['client', 'industry'])
            ->orderBy('sort_order')
            ->paginate(9);

        return view('frontend.pages.projects.index')->with(['projects' => $projects]);
    }

    public function show(\App\Models\Project $project)
    {
        $project->load(['client', 'industry', 'services', 'caseStudies', 'seo']);
        
        return view('frontend.pages.projects.single')->with(['project' => $project]);
    }
}
