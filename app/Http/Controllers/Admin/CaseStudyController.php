<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CaseStudy;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class CaseStudyController extends Controller
{
    /**
     * Display a listing of client case studies.
     */
    public function index(): View
    {
        Gate::authorize('view-case-studies');

        $caseStudies = CaseStudy::with('project')->latest()->get();

        return view('admin.pages.case-studies')->with([
            'caseStudies' => $caseStudies,
        ]);
    }
}
