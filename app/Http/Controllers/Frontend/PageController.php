<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\User;

class PageController extends Controller
{
    public function about()
    {
        $teamMemberExists = User::hasTeamMembers();
        $page = \App\Models\Page::where('slug', 'about-us')->firstOrFail();
        
        return view('frontend.pages.about')->with([
            'teamMemberExists' => $teamMemberExists,
            'page' => $page,
        ]);
    }

    public function contact()
    {
        $page = \App\Models\Page::where('slug', 'contact')->firstOrFail();
        
        return view('frontend.pages.contact')->with([
            'page' => $page,
        ]);
    }

    public function digitalMarketing()
    {
        return view('frontend.pages.digital-marketing');
    }

    public function softwareDevelopment()
    {
        return view('frontend.pages.software-development');
    }
}
