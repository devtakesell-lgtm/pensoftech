<?php

namespace App\Http\Controllers\Frontend;

use App\Enums\ContentStatus;
use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Project;
use App\Models\ServiceCategory;
use App\Models\User;

class HomeController extends Controller
{
    public function index()
    {
        $ecosystems = ServiceCategory::where('is_ecosystem', true)
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->limit(6)
            ->get();

        $serviceCategories = ServiceCategory::with(['services' => function ($query) {
            $query->where('status', ContentStatus::Published)
                ->orderBy('sort_order');
        }])
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $blogs = Blog::with(['category', 'author'])
            ->where('status', ContentStatus::Published)
            ->latest('published_at')
            ->take(3)
            ->get();

        $featuredProjects = Project::with(['industry', 'services'])
            ->where('is_featured', true)
            ->orderBy('sort_order')
            ->get();

        $teamMemberExists = User::hasTeamMembers();

        return view('frontend.pages.home')->with([
            'ecosystems' => $ecosystems,
            'serviceCategories' => $serviceCategories,
            'blogs' => $blogs,
            'featuredProjects' => $featuredProjects,
            'teamMemberExists' => $teamMemberExists,
        ]);
    }
}
