<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\StoreContactLeadRequest;
use App\Models\Lead;
use App\Models\Page;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PageController extends Controller
{
    public function about(): View
    {
        $teamMemberExists = User::hasTeamMembers();
        $page = Page::where('slug', 'about-us')->firstOrFail();

        return view('frontend.pages.about')->with([
            'teamMemberExists' => $teamMemberExists,
            'page' => $page,
        ]);
    }

    public function contact(): View
    {
        $page = Page::where('slug', 'contact')->firstOrFail();

        return view('frontend.pages.contact')->with([
            'page' => $page,
        ]);
    }

    public function storeContact(StoreContactLeadRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        Lead::create([
            'name' => trim($validated['first_name'].' '.$validated['last_name']),
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'company_name' => $validated['company'] ?? null,
            'message' => $validated['message'],
            'lead_source' => 'Contact Page',
            'status' => 'new',
            'ip_address' => $request->ip(),
        ]);

        return redirect()->route('contact')->with('success', 'Thank you! Your message has been sent successfully. We will be in touch shortly.');
    }

    public function digitalMarketing(): View
    {
        return view('frontend.pages.digital-marketing');
    }

    public function softwareDevelopment(): View
    {
        return view('frontend.pages.software-development');
    }
}
