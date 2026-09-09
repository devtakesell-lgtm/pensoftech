<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class AnalyticsController extends Controller
{
    /**
     * Display the analytics and reporting dashboard.
     */
    public function index(): View
    {
        Gate::authorize('view-analytics');

        return view('admin.pages.analytics');
    }
}
