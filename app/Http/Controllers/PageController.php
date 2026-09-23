<?php

namespace App\Http\Controllers;

use App\Enums\ContentStatus;
use App\Models\Page;
use App\Models\Service;
use App\Models\ServiceCategory;

class PageController extends Controller
{
    public function about()
    {
        return view('frontend.pages.about');
    }

    public function contact()
    {
        return view('frontend.pages.contact');
    }

    public function digitalMarketing()
    {
        return view('frontend.pages.digital-marketing');
    }

    public function softwareDevelopment()
    {
        return view('frontend.pages.software-development');
    }

    public function services()
    {
        $page = Page::with('seo')->where('slug', 'services')->first();
        $categories = ServiceCategory::with(['services' => function ($q) {
            $q->where('status', ContentStatus::Published)->orderBy('sort_order');
        }])->where('is_active', true)->orderBy('sort_order')->get();

        return view('frontend.pages.services', compact('page', 'categories'));
    }

    public function serviceCategory($slug)
    {
        $category = ServiceCategory::with(['services' => function ($q) {
            $q->where('status', ContentStatus::Published)->orderBy('sort_order');
        }])->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        return view('frontend.pages.service-category', compact('category'));
    }

    public function singleService($category_slug, $service_slug)
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
