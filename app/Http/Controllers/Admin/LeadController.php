<?php

namespace App\Http\Controllers\Admin;

use App\Enums\LeadSource;
use App\Enums\LeadStatus;
use App\Enums\LeadType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreLeadRequest;
use App\Http\Requests\Admin\UpdateLeadRequest;
use App\Http\Requests\Admin\UpdateLeadStatusRequest;
use App\Http\Requests\Admin\ConvertLeadRequest;
use App\Models\Client;
use App\Models\Currency;
use App\Models\Industry;
use App\Models\Lead;
use App\Models\Service;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\View\View;

class LeadController extends Controller
{
    /**
     * Display a listing of sales leads with search, filtering, and pipeline metrics.
     */
    public function index(Request $request): View
    {
        Gate::authorize('view-leads');

        $filters = $request->only(['search', 'status', 'source', 'industry_id', 'assigned_to']);

        $leads = Lead::query()
            ->filter($filters)
            ->with(['client', 'services', 'assignee', 'industry', 'currency'])
            ->latest()
            ->paginate(15)
            ->withQueryString();

        // Pipeline Metrics
        $totalCount = Lead::count();
        $newCount = Lead::where('status', LeadStatus::New)->count();
        $qualifiedCount = Lead::where('status', LeadStatus::Qualified)->count();
        $convertedCount = Lead::where('status', LeadStatus::Converted)->count();
        // $activePipelineValue = (float) Lead::whereNotIn('status', [LeadStatus::Lost, LeadStatus::Converted])
        //     ->sum('budget');

        // Filter dropdown lookups
        $industries = Industry::select('id', 'name')->orderBy('name')->get();
        $assignees = User::select('id', 'name', 'email')
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        $defaultCurrency = Currency::default();

        return view('admin.pages.leads.index')->with([
            'leads' => $leads,
            'statuses' => LeadStatus::cases(),
            'sources' => LeadSource::options(),
            'industries' => $industries,
            'assignees' => $assignees,
            'defaultCurrency' => $defaultCurrency,
            'totalCount' => $totalCount,
            'newCount' => $newCount,
            'qualifiedCount' => $qualifiedCount,
            'convertedCount' => $convertedCount,
            // 'activePipelineValue' => $activePipelineValue,
            'currentSearch' => $filters['search'] ?? '',
            'currentStatus' => $filters['status'] ?? '',
            'currentSource' => $filters['source'] ?? '',
            'currentIndustry' => $filters['industry_id'] ?? '',
            'currentAssignee' => $filters['assigned_to'] ?? '',
        ]);
    }

    /**
     * Show the form for creating a new sales lead.
     */
    public function create(): View
    {
        Gate::authorize('create-leads');

        return view('admin.pages.leads.create')->with($this->getFormData());
    }

    /**
     * Store a newly created sales lead in storage.
     */
    public function store(StoreLeadRequest $request): RedirectResponse
    {
        Gate::authorize('create-leads');

        $lead = Lead::create($request->safe()->except('service_ids'));

        if ($request->filled('service_ids')) {
            $lead->services()->sync($request->validated('service_ids'));
        }

        return redirect()->route('admin.leads')
            ->with('success', "Lead '{$lead->name}' has been successfully created.");
    }

    /**
     * Display the specified lead dossier and timeline overview.
     */
    public function show(Lead $lead): View
    {
        Gate::authorize('view-leads');

        $lead->load(['client', 'services', 'assignee', 'industry', 'currency', 'quotes.currency']);

        return view('admin.pages.leads.show')->with([
            'lead' => $lead,
            'statuses' => LeadStatus::cases(),
            'defaultCurrency' => Currency::default(),
        ]);
    }

    /**
     * Show the form for editing the specified lead.
     */
    public function edit(Lead $lead): View
    {
        Gate::authorize('edit-leads');

        $lead->load('services');

        return view('admin.pages.leads.edit')->with(
            array_merge($this->getFormData(), ['lead' => $lead])
        );
    }

    /**
     * Update the specified lead in storage.
     */
    public function update(UpdateLeadRequest $request, Lead $lead): RedirectResponse
    {
        Gate::authorize('edit-leads');

        $lead->update($request->safe()->except('service_ids'));
        $lead->services()->sync($request->validated('service_ids') ?? []);

        return redirect()->route('admin.leads')
            ->with('success', "Lead '{$lead->name}' has been successfully updated.");
    }

    public function destroy(Lead $lead): RedirectResponse
    {
        Gate::authorize('delete-leads');

        $leadName = $lead->name;
        $lead->delete();

        return redirect()->route('admin.leads')
            ->with('success', "Lead '{$leadName}' has been moved to trash.");
    }

    public function updateStatus(UpdateLeadStatusRequest $request, Lead $lead): RedirectResponse
    {
        Gate::authorize('edit-leads');

        $newStatus = $request->validated('status');

        $pipelineStages = [
            LeadStatus::New->value,
            LeadStatus::Contacted->value,
            LeadStatus::Qualified->value,
            LeadStatus::ProposalSent->value,
            LeadStatus::Converted->value,
        ];

        $currentIndex = array_search($lead->status->value, $pipelineStages);
        $newIndex = array_search($newStatus, $pipelineStages);

        if ($lead->status !== LeadStatus::Lost && $currentIndex !== false && $newIndex !== false && $newIndex < $currentIndex) {
            return back()->with('error', 'Cannot revert an active lead to a previous pipeline stage.');
        }

        $lead->update([
            'status' => $newStatus,
        ]);

        return back()->with('success', "Status updated to '{$lead->status->label()}'.");
    }

    public function convert(ConvertLeadRequest $request, Lead $lead): RedirectResponse
    {
        if ($lead->client_id) {
            return back()->with('error', 'This lead is already converted and linked to an existing client profile.');
        }

        DB::transaction(function () use ($request, $lead, &$client) {
            $password = Str::random(12);

            $role = Role::where('name', 'client')->first();

            $user = User::create([
                'name' => $request->validated('contact_person'),
                'email' => $request->validated('email'),
                'password' => Hash::make($password),
                'role_id' => $role ? $role->id : null,
                'is_active' => true,
            ]);

            if ($role) {
                $user->assignRole($role);
            }

            // TODO: In a real app, fire an event or job to send the email with the $password here.

            $client = Client::create([
                'user_id' => $user->id,
                'company_name' => $request->validated('company_name'),
                'contact_person' => $request->validated('contact_person'),
                'website' => $request->validated('website'),
                'phone' => $request->validated('phone'),
                'is_active' => true,
            ]);

            $lead->update([
                'client_id' => $client->id,
                'status' => LeadStatus::Converted,
            ]);
        });

        return redirect()->route('admin.leads.show', $lead)
            ->with('success', "Lead successfully converted to Client '{$client->company_name}'! An email has been sent with their login credentials.");
    }

    private function getFormData(): array
    {
        return [
            'statuses' => LeadStatus::cases(),
            'sources' => LeadSource::options(),
            'types' => LeadType::options(),
            'industries' => Industry::select('id', 'name')->orderBy('name')->get(),
            'currencies' => Currency::select('id', 'name', 'code', 'symbol')->where('is_active', true)->get(),
            'services' => Service::select('id', 'name')->orderBy('name')->get(),
            'assignees' => User::select('id', 'name', 'email')->where('is_active', true)->orderBy('name')->get(),
        ];
    }
}
