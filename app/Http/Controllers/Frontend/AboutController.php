<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\User;
use Illuminate\View\View;

class AboutController extends Controller
{
    public function index(): View
    {
        $teamMemberExists = User::hasTeamMembers();
        $page = Page::where('slug', 'about-us')->firstOrFail();

        return view('frontend.pages.about')->with([
            'teamMemberExists' => $teamMemberExists,
            'page' => $page,
        ]);
    }
}
