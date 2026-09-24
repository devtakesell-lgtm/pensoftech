<?php

namespace App\View\Components\Frontend;

use App\Models\User;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Team extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $teamMembers = User::with(['profile', 'roles'])
            ->whereHas('profile', function ($q) {
                $q->where('show_on_team_page', true);
            })
            ->whereDoesntHave('roles', function ($q) {
                $q->where('name', 'client');
            })
            ->join('user_profiles', 'users.id', '=', 'user_profiles.user_id')
            ->orderBy('user_profiles.sort_order', 'asc')
            ->select('users.*')
            ->get();

        return view('frontend.components.global.team', [
            'teamMembers' => $teamMembers,
        ]);
    }
}
