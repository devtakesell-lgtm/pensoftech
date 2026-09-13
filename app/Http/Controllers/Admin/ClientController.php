<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class ClientController extends Controller
{
    /**
     * Display a listing of agency clients.
     */
    public function index(): View
    {
        Gate::authorize('view-clients');

        $clients = Client::with('user')->withCount('projects')->latest()->paginate(10);

        return view('admin.pages.clients')->with([
            'clients' => $clients,
        ]);
    }
}
