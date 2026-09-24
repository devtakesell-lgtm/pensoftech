<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        $ecosystems = \App\Models\ServiceCategory::where('is_ecosystem', true)
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->limit(6)
            ->get();

        $serviceCategories = \App\Models\ServiceCategory::with(['services' => function ($query) {
            $query->where('status', \App\Enums\ContentStatus::Published)
                  ->orderBy('sort_order');
        }])
        ->where('is_active', true)
        ->orderBy('sort_order')
        ->get();

        $blogs = \App\Models\Blog::with(['category', 'author'])
            ->where('status', \App\Enums\ContentStatus::Published)
            ->latest('published_at')
            ->take(3)
            ->get();

        $featuredProjects = \App\Models\Project::with(['industry', 'services'])
            ->where('is_featured', true)
            ->orderBy('sort_order')
            ->get();

        return view('frontend.pages.home')->with([
            'ecosystems' => $ecosystems,
            'serviceCategories' => $serviceCategories,
            'blogs' => $blogs,
            'featuredProjects' => $featuredProjects,
        ]);
    }
}
