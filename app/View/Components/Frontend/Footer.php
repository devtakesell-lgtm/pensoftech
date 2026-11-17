<?php

namespace App\View\Components\Frontend;

use App\Models\ServiceCategory;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Footer extends Component
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

        $serviceCategories = ServiceCategory::where('is_active', true)
            ->orWhere('is_ecosystem', true)
            ->orderBy('sort_order')
            ->limit(5)
            ->get();

        return view('frontend.components.global.footer')->with([
            'serviceCategories' => $serviceCategories,
        ]);
    }
}
