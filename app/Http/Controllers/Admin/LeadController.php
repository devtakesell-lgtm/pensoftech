<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use Illuminate\View\View;

class LeadController extends Controller
{
    /**
     * Display a listing of sales leads.
     */
    public function index(): View
    {
        $leads = Lead::with(['client', 'services'])->latest()->get();

        return view('admin.pages.leads')->with([
            'leads' => $leads,
        ]);
    }
}
