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
            ->get();

        return view('frontend.pages.home', compact('ecosystems'));
    }
}
