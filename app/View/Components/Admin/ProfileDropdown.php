<?php

namespace App\View\Components\Admin;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

class ProfileDropdown extends Component
{
    public string $name;

    public string $email;

    public string $role;

    public string $initials;

    /**
     * Create a new component instance.
     */
    public function __construct(
        ?string $name = null,
        ?string $email = null,
        ?string $role = null,
        ?string $initials = null
    ) {
        $user = Auth::user();

        $this->name = $name ?? $user?->name ?? 'Admin';
        $this->email = $email ?? $user?->email ?? 'admin@pensoftech.com';
        $this->role = $role ?? $user?->role?->name ?? 'Staff';

        if ($initials) {
            $this->initials = $initials;
        } else {
            $words = preg_split('/\s+/', trim($this->name));
            if (is_array($words) && count($words) >= 2) {
                $this->initials = strtoupper(mb_substr($words[0], 0, 1).mb_substr($words[1], 0, 1));
            } else {
                $this->initials = strtoupper(mb_substr($this->name, 0, 2));
            }
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('admin.components.profile-dropdown');
    }
}
