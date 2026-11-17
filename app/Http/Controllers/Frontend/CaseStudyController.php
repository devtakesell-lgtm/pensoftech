<?php

namespace App\Http\Controllers\Frontend;

use App\Enums\ContentStatus;
use App\Http\Controllers\Controller;
use App\Models\CaseStudy;
use App\Models\Industry;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CaseStudyController extends Controller
{
    /**
     * Display a listing of published case studies.
     */
    public function index(Request $request): View
    {
        $selectedIndustry = $request->input('industry');

        $query = CaseStudy::with([
            'project.client',
            'project.industry',
            'project.services',
            'metrics',
        ])->where('status', ContentStatus::Published);

        if ($selectedIndustry) {
            $query->whereHas('project.industry', function ($q) use ($selectedIndustry) {
                $q->where('slug', $selectedIndustry);
            });
        }

        $caseStudies = $query->latest('published_at')->paginate(10)->withQueryString();

        $industries = Industry::where('is_active', true)
            ->whereHas('projects.caseStudies', function ($q) {
                $q->where('status', ContentStatus::Published);
            })
            ->orderBy('name')
            ->get();

        return view('frontend.pages.case-studies.index')->with([
            'caseStudies' => $caseStudies,
            'industries' => $industries,
            'selectedIndustry' => $selectedIndustry,
        ]);
    }

    /**
     * Display the specified case study.
     */
    public function show(CaseStudy $caseStudy): View
    {
        if ($caseStudy->status !== ContentStatus::Published) {
            abort(404);
        }

        $caseStudy->load([
            'project.client',
            'project.industry',
            'project.services',
            'metrics',
            'challenges.solutions',
            'seo',
        ]);

        $relatedCaseStudies = CaseStudy::with(['project.client', 'project.industry', 'metrics'])
            ->where('status', ContentStatus::Published)
            ->where('id', '!=', $caseStudy->id)
            ->when($caseStudy->project?->industry_id, function ($q, $industryId) {
                $q->whereHas('project', function ($p) use ($industryId) {
                    $p->where('industry_id', $industryId);
                });
            })
            ->latest('published_at')
            ->take(2)
            ->get();

        if ($relatedCaseStudies->count() < 2) {
            $extra = CaseStudy::with(['project.client', 'project.industry', 'metrics'])
                ->where('status', ContentStatus::Published)
                ->where('id', '!=', $caseStudy->id)
                ->whereNotIn('id', $relatedCaseStudies->pluck('id'))
                ->latest('published_at')
                ->take(2 - $relatedCaseStudies->count())
                ->get();
            $relatedCaseStudies = $relatedCaseStudies->merge($extra);
        }

        return view('frontend.pages.case-studies.show')->with([
            'caseStudy' => $caseStudy,
            'relatedCaseStudies' => $relatedCaseStudies,
        ]);
    }
}
