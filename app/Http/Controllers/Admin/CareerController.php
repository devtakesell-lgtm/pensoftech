<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class CareerController extends Controller
{
    /**
     * Display a listing of career opportunities and applications.
     */
    public function index(): View
    {
        Gate::authorize('view-jobs');

        return view('admin.pages.careers');
    }
}
