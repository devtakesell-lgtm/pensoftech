<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        return view('admin.pages.dashboard');
    }

    public function leads(): View
    {
        return view('admin.pages.leads');
    }

    public function clients(): View
    {
        return view('admin.pages.clients');
    }

    public function quotes(): View
    {
        return view('admin.pages.quotes');
    }

    public function services(): View
    {
        return view('admin.pages.services');
    }

    public function projects(): View
    {
        return view('admin.pages.projects');
    }

    public function caseStudies(): View
    {
        return view('admin.pages.case-studies');
    }

    public function industries(): View
    {
        return view('admin.pages.industries');
    }

    public function pages(): View
    {
        return view('admin.pages.pages');
    }

    public function blog(): View
    {
        return view('admin.pages.blog');
    }

    public function careers(): View
    {
        return view('admin.pages.careers');
    }

    public function users(): View
    {
        return view('admin.pages.users');
    }

    public function analytics(): View
    {
        return view('admin.pages.analytics');
    }

    public function settings(): View
    {
        return view('admin.pages.settings');
    }
}
