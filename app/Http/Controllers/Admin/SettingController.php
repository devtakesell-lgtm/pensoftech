<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class SettingController extends Controller
{
    /**
     * Display the agency and system settings page.
     */
    public function index(): View
    {
        Gate::authorize('view-settings');

        return view('admin.pages.settings');
    }
}
