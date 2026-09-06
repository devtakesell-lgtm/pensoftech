<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        return view('frontend.pages.home');
    }
}
