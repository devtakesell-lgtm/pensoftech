<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class PageController extends Controller
{
    public function digitalMarketing(): View
    {
        return view('frontend.pages.digital-marketing');
    }

    public function softwareDevelopment(): View
    {
        return view('frontend.pages.software-development');
    }
}
