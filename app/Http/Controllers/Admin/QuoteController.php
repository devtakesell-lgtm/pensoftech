<?php

namespace App\Http\Controllers\Admin;

use App\Enums\LeadStatus;
use App\Enums\QuoteStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreQuoteRequest;
use App\Http\Requests\Admin\UpdateQuoteRequest;
use App\Models\Currency;
use App\Models\Lead;
use App\Models\Quote;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Illuminate\View\View;

class QuoteController extends Controller
{
    /**
     * Display a listing of client quotes and proposals with filtering and metrics.
     */
    public function index(Request $request): View
    {
        Gate::authorize('view-quotes');

        $filters = $request->only(['search', 'status', 'lead_id']);

        $quotes = Quote::query()
            ->filter($filters)
            ->with(['lead.services', 'currency', 'creator', 'services.service'])
            ->latest()
            ->paginate(15)
            ->withQueryString();

        // Pipeline Metrics
        $totalCount = Quote::count();
        $draftCount = Quote::where('status', QuoteStatus::Draft)->count();
        $sentCount = Quote::where('status', QuoteStatus::Sent)->count();
        $acceptedCount = Quote::where('status', QuoteStatus::Accepted)->count();
        $totalPipelineValue = (float) Quote::whereIn('status', [QuoteStatus::Draft, QuoteStatus::Sent, QuoteStatus::Accepted])
            ->sum('budget_max');

        // Lookups
        $statuses = QuoteStatus::cases();
        $leads = Lead::select('id', 'name', 'company_name')->orderBy('name')->get();
        $defaultCurrency = Currency::default();

        return view('admin.pages.quotes.index')->with([
            'quotes' => $quotes,
            'statuses' => $statuses,
            'leads' => $leads,
            'defaultCurrency' => $defaultCurrency,
            'totalCount' => $totalCount,
            'draftCount' => $draftCount,
            'sentCount' => $sentCount,
            'acceptedCount' => $acceptedCount,
            'totalPipelineValue' => $totalPipelineValue,
            'currentSearch' => $filters['search'] ?? '',
            'currentStatus' => $filters['status'] ?? '',
            'currentLead' => $filters['lead_id'] ?? '',
        ]);
    }

    public function create(Request $request): View
    {
        Gate::authorize('create-quotes');

        $lead = null;
        if ($request->has('lead_id')) {
            $lead = Lead::find($request->input('lead_id'));
        }

        return view('admin.pages.quotes.create')->with($this->getFormData($lead, QuoteStatus::initialCases()));
    }

    public function store(StoreQuoteRequest $request): RedirectResponse
    {
        Gate::authorize('create-quotes');

        $lead = Lead::findOrFail($request->validated('lead_id'));

        $quote = DB::transaction(function () use ($request, $lead) {

            $quote = Quote::create(array_merge($request->validated(), [
                'quote_number' => 'Q-'.strtoupper(Str::random(6)),
                'created_by' => Auth::id(),
            ]));

            if ($quote->status === QuoteStatus::Sent && $lead->status !== LeadStatus::Converted) {
                $lead->update([
                    'status' => LeadStatus::ProposalSent,
                ]);
            }

            return $quote;
        });

        return redirect()->route('admin.quotes.show', $quote)
            ->with('success', "Quote '{$quote->quote_number}' has been successfully created.");
    }

    public function show(Quote $quote): View
    {
        Gate::authorize('view-quotes');

        $quote->load(['lead', 'currency', 'creator']);

        return view('admin.pages.quotes.show')->with([
            'quote' => $quote,
        ]);
    }

    public function edit(Quote $quote): View
    {
        Gate::authorize('edit-quotes');

        return view('admin.pages.quotes.edit')->with(
            array_merge($this->getFormData(), ['quote' => $quote])
        );
    }

    public function update(UpdateQuoteRequest $request, Quote $quote): RedirectResponse
    {
        Gate::authorize('edit-quotes');

        $quote->update($request->validated());

        return redirect()->route('admin.quotes.show', $quote)
            ->with('success', "Quote '{$quote->quote_number}' has been successfully updated.");
    }

    public function destroy(Quote $quote): RedirectResponse
    {
        Gate::authorize('delete-quotes');

        $quoteNumber = $quote->quote_number;
        $quote->delete();

        return redirect()->route('admin.quotes')
            ->with('success', "Quote '{$quoteNumber}' has been deleted.");
    }

    private function getFormData(?Lead $lead = null, ?array $statuses = null): array
    {
        $leads = Lead::select('id', 'name', 'company_name')->orderBy('name')->get();
        $currencies = Currency::select('id', 'name', 'code', 'symbol')->where('is_active', true)->get();

        return [
            'leads' => $leads,
            'currencies' => $currencies,
            'statuses' => $statuses?? QuoteStatus::cases(),
            'selectedLead' => $lead,
        ];
    }
}
