<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Display a listing of agency team members and users.
     */
    public function index(): View
    {
        $users = User::with('roles')->latest()->get();
        $roles = Role::where('name', '!=', 'client')->orderBy('name')->get();

        return view('admin.pages.users')->with([
            'users' => $users,
            'roles' => $roles,
        ]);
    }
}
