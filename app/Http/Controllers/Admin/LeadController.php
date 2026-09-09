<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class LeadController extends Controller
{
    /**
     * Display a listing of sales leads.
     */
    public function index(): View
    {
        Gate::authorize('view-leads');

        $leads = Lead::with(['client', 'services'])->latest()->get();

        return view('admin.pages.leads')->with([
            'leads' => $leads,
        ]);
    }
}
