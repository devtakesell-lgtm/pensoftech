<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\User;

class PageController extends Controller
{
    public function about()
    {
        $teamMemberExists = User::hasTeamMembers();
        return view('frontend.pages.about')->with([
            'teamMemberExists' => $teamMemberExists,
        ]);
    }

    public function contact()
    {
        return view('frontend.pages.contact');
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
