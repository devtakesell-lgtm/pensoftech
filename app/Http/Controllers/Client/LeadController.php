<?php

namespace App\Http\Controllers\Client;

use App\Enums\ContentStatus;
use App\Enums\LeadStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Client\StoreClientLeadRequest;
use App\Models\Client;
use App\Models\Lead;
use App\Models\Service;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class LeadController extends Controller
{
    /**
     * Display a listing of client's inquiries and requests.
     */
    public function index(Request $request): View
    {
        /** @var User $user */
        $user = $request->user();
        $client = $this->resolveClient($user);

        $leads = $client->leads()
            ->with(['services', 'quotes'])
            ->latest()
            ->paginate(10);

        return view('client.leads.index', compact('client', 'leads'));
    }

    /**
     * Show the form for requesting a new service/project.
     */
    public function create(Request $request): View
    {
        /** @var User $user */
        $user = $request->user();
        $client = $this->resolveClient($user);

        $services = Service::where('status', ContentStatus::Published)
            ->orderBy('name')
            ->get();

        return view('client.leads.create', compact('client', 'services'));
    }

    /**
     * Store a newly created service inquiry/request.
     */
    public function store(StoreClientLeadRequest $request): RedirectResponse
    {
        /** @var User $user */
        $user = $request->user();
        $client = $this->resolveClient($user);

        $validated = $request->validated();

        $lead = Lead::create([
            'client_id' => $client->id,
            'name' => $user->name,
            'company_name' => $client->company_name ?? $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
            'lead_source' => 'client_portal',
            'lead_type' => 'client_request',
            'message' => "Subject: {$validated['project_title']}\n\nRequirements:\n{$validated['message']}",
            'budget' => $validated['budget'] ?? null,
            'status' => LeadStatus::New,
        ]);

        if (! empty($validated['service_ids'])) {
            $lead->services()->sync($validated['service_ids']);
        }

        return redirect()
            ->route('client.leads.index')
            ->with('success', 'Your service request has been submitted successfully. Our team will review it and get back to you shortly.');
    }

    /**
     * Resolve or initialize the client record for the user.
     */
    protected function resolveClient(User $user): Client
    {
        return $user->client ?? Client::firstOrCreate(
            ['user_id' => $user->id],
            [
                'contact_person' => $user->name,
                'company_name' => $user->name,
                'is_active' => true,
            ]
        );
    }
}
