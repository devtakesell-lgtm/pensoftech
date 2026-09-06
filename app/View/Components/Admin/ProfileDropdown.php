<?php

namespace App\View\Components\Admin;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ProfileDropdown extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $name = 'Admin',
        public string $email = 'admin@pensoftech.com',
        public string $role = 'Super Admin',
        public string $initials = 'AD'
    ) {}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('admin.components.profile-dropdown');
    }
}
