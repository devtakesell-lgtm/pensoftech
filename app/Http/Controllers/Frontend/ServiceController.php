<?php

namespace App\Http\Controllers\Frontend;

use App\Enums\ContentStatus;
use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\Service;
use App\Models\ServiceCategory;

class ServiceController extends Controller
{
    public function index()
    {
        $page = Page::with('seo')->where('slug', 'services')->first();
        $categories = ServiceCategory::with(['services' => function ($q) {
            $q->where('status', ContentStatus::Published)->orderBy('sort_order');
        }])->where('is_active', true)->orderBy('sort_order')->get();

        return view('frontend.pages.services')->with([
            'page' => $page,
            'categories' => $categories
        ]);
    }

    public function category($slug)
    {
        $category = ServiceCategory::with(['services' => function ($q) {
            $q->where('status', ContentStatus::Published)->orderBy('sort_order');
        }])->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        return view('frontend.pages.service-category')->with([
            'category' => $category
        ]);
    }

    public function show($category_slug, $service_slug)
    {
        $category = ServiceCategory::where('slug', $category_slug)
            ->where('is_active', true)
            ->firstOrFail();

        $service = Service::with('seo')
            ->where('service_category_id', $category->id)
            ->where('slug', $service_slug)
            ->where('status', ContentStatus::Published)
            ->firstOrFail();

        $relatedServices = Service::where('service_category_id', $category->id)
            ->where('id', '!=', $service->id)
            ->where('status', ContentStatus::Published)
            ->orderBy('sort_order')
            ->take(6)
            ->get();

        return view('frontend.pages.service-single')->with([
            'category' => $category,
            'service' => $service,
            'relatedServices' => $relatedServices,
        ]);
    }
}
