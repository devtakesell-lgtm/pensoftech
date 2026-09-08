<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\View\View;

class ClientController extends Controller
{
    /**
     * Display a listing of agency clients.
     */
    public function index(): View
    {
        $clients = Client::with('user')->withCount('projects')->latest()->get();

        return view('admin.pages.clients')->with([
            'clients' => $clients,
        ]);
    }
}
