<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Quote;
use Illuminate\View\View;

class QuoteController extends Controller
{
    /**
     * Display a listing of client quotes and proposals.
     */
    public function index(): View
    {
        $quotes = Quote::with(['lead', 'currency'])->latest()->get();

        return view('admin.pages.quotes')->with([
            'quotes' => $quotes,
        ]);
    }
}
