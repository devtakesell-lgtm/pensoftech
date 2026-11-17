<?php

namespace App\Http\Controllers\Frontend;

use App\Enums\LeadType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\StoreLeadRequest;
use App\Models\Currency;
use App\Models\Lead;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Notification;
use Illuminate\View\View;

class LeadController extends Controller
{
    public function create(): View
    {
        $leadTypes = LeadType::options();
        $defaultCurrency = Currency::where('is_default', true)->first();

        return view('frontend.pages.start-project')->with([
            'leadTypes' => $leadTypes,
            'defaultCurrency' => $defaultCurrency,
        ]);
    }

    public function store(StoreLeadRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $data['ip_address'] = $request->ip();
        $data['lead_source'] = 'Website Form';

        if ($request->hasFile('attachment')) {
            $data['attachment_path'] = $request->file('attachment')->store('leads/attachments', 'public');
        }

        $lead = Lead::create($data);

        // $recipients = User::query()
        //     ->permission('view-leads')
        //     ->get();

        // $adminEmail = setting('system_admin_email', 'hello@pensoftech.com');
        // \Illuminate\Support\Facades\Notification::route('mail', $adminEmail)
        //     ->notify(new \App\Notifications\NewLeadNotification($lead));

        // if ($recipients->isNotEmpty()) {
        //     Notification::send($recipients, new \App\Notifications\NewLeadNotification($lead));
        // }

        return redirect()->route('start-project')->with('success', 'Thank you! Your project inquiry has been received. We will contact you soon.');
    }
}
