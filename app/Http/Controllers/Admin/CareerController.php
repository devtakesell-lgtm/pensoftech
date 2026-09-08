<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class CareerController extends Controller
{
    /**
     * Display a listing of career opportunities and applications.
     */
    public function index(): View
    {
        return view('admin.pages.careers');
    }
}
