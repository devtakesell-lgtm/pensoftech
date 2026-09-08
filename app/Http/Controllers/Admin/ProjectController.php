<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\View\View;

class ProjectController extends Controller
{
    /**
     * Display a listing of agency client projects.
     */
    public function index(): View
    {
        $projects = Project::with(['client', 'services'])->latest()->get();

        return view('admin.pages.projects')->with([
            'projects' => $projects,
        ]);
    }
}
