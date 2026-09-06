<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;

class SoftwareDevelopmentController extends Controller
{
    public function index()
    {
        return view('frontend.pages.software-development');
    }
}
