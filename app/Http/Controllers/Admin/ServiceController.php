<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class ServiceController extends Controller
{
    /**
     * Display a listing of agency services.
     */
    public function index(): View
    {
        Gate::authorize('view-services');

        $services = Service::with('category')->latest()->get();

        return view('admin.pages.services')->with([
            'services' => $services,
        ]);
    }
}
