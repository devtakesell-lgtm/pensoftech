<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the admin main dashboard.
     */
    public function index(): View
    {
        return view('admin.pages.dashboard');
    }
}
