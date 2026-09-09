<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Quote;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class QuoteController extends Controller
{
    /**
     * Display a listing of client quotes and proposals.
     */
    public function index(): View
    {
        Gate::authorize('view-quotes');

        $quotes = Quote::with(['lead', 'currency'])->latest()->get();

        return view('admin.pages.quotes')->with([
            'quotes' => $quotes,
        ]);
    }
}
