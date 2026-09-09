<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class PageController extends Controller
{
    /**
     * Display a listing of CMS pages.
     */
    public function index(): View
    {
        Gate::authorize('view-pages');

        $pages = Page::latest()->get();

        return view('admin.pages.pages')->with([
            'pages' => $pages,
        ]);
    }
}
