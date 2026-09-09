<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Industry;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class IndustryController extends Controller
{
    /**
     * Display a listing of client business industries.
     */
    public function index(): View
    {
        Gate::authorize('view-industries');

        $industries = Industry::withCount('projects')->latest()->get();

        return view('admin.pages.industries')->with([
            'industries' => $industries,
        ]);
    }
}
