<?php

namespace App\Http\Controllers\Client;

use App\Enums\ProjectStatus;
use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Project;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of client's projects.
     */
    public function index(Request $request): View
    {
        /** @var User $user */
        $user = $request->user();
        $client = $this->resolveClient($user);

        $query = $client->projects()->with(['industry', 'services'])->latest();

        if ($statusFilter = $request->input('status')) {
            $query->where('status', $statusFilter);
        }

        $projects = $query->paginate(9)->withQueryString();
        $statusOptions = ProjectStatus::cases();

        return view('client.projects.index', compact('client', 'projects', 'statusOptions'));
    }

    /**
     * Display the specified client project.
     */
    public function show(Project $project, Request $request): View
    {
        /** @var User $user */
        $user = $request->user();
        $client = $this->resolveClient($user);

        // Security check: ensure the project belongs to this client
        if ($project->client_id !== $client->id) {
            abort(403, 'Unauthorized access to this project.');
        }

        $project->load(['industry', 'services', 'caseStudies']);

        return view('client.projects.show', compact('client', 'project'));
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
