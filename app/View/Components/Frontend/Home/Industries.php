<?php

namespace App\View\Components\Frontend\Home;

use App\Models\Industry;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Industries extends Component
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
        $industries = Industry::where('is_active', true)
            ->orderBy('sort_order', 'asc')
            ->get();

        return view('frontend.components.home.industries', [
            'industries' => $industries,
        ]);
    }
}
