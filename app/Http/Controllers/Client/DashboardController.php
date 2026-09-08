<?php

namespace App\Http\Controllers\Client;

use App\Enums\ProjectStatus;
use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display the client portal dashboard with statistics and recent items.
     */
    public function index(Request $request): View
    {
        /** @var User $user */
        $user = $request->user();
        $client = $this->resolveClient($user);

        $stats = [
            'total_projects' => $client->projects()->count(),
            'ongoing_projects' => $client->projects()->where('status', ProjectStatus::Ongoing)->count(),
            'completed_projects' => $client->projects()->where('status', ProjectStatus::Completed)->count(),
            'total_inquiries' => $client->leads()->count(),
        ];

        $recentProjects = $client->projects()
            ->with(['industry', 'services'])
            ->latest()
            ->take(4)
            ->get();

        $recentLeads = $client->leads()
            ->with('services')
            ->latest()
            ->take(5)
            ->get();

        return view('client.dashboard', compact('client', 'stats', 'recentProjects', 'recentLeads'));
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
