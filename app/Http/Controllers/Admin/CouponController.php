<?php

namespace App\Http\Controllers\Admin;

use App\Enums\CouponDiscountType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreCouponRequest;
use App\Http\Requests\Admin\UpdateCouponRequest;
use App\Models\Coupon;
use App\Models\Course;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class CouponController extends Controller
{
    public function index(Request $request): View
    {
        Gate::authorize('view-coupons');

        $filters = $request->only(['search', 'course_id', 'is_active']);

        $query = Coupon::with('course')->latest();

        if (! empty($filters['search'])) {
            $search = $filters['search'];
            $query->where('code', 'like', "%{$search}%");
        }

        if (! empty($filters['course_id'])) {
            $query->where('course_id', $filters['course_id']);
        }

        if ($request->filled('is_active')) {
            $query->where('is_active', $filters['is_active'] === '1');
        }

        $coupons = $query->paginate(10)->withQueryString();

        return view('admin.pages.coupons.index')->with([
            'coupons' => $coupons,
            'courses' => Course::select('id', 'title', 'batch_no')->orderBy('title')->get(),
            'currentSearch' => $filters['search'] ?? '',
            'currentCourse' => $filters['course_id'] ?? '',
            'currentActive' => $filters['is_active'] ?? '',
        ]);
    }

    private function getFormData(): array
    {
        return [
            'courses' => Course::select('id', 'title', 'batch_no')->orderBy('title')->get(),
            'discountTypes' => CouponDiscountType::cases(),
        ];
    }

    public function create(): View
    {
        Gate::authorize('create-coupons');

        return view('admin.pages.coupons.create')->with($this->getFormData());
    }

    public function store(StoreCouponRequest $request): RedirectResponse
    {
        $coupon = Coupon::create($request->validated());

        return redirect()->route('admin.coupons.index')
            ->with('success', "Coupon '{$coupon->code}' created successfully.");
    }

    public function edit(Coupon $coupon): View
    {
        Gate::authorize('edit-coupons');

        return view('admin.pages.coupons.edit')->with(
            array_merge($this->getFormData(), ['coupon' => $coupon])
        );
    }

    public function update(UpdateCouponRequest $request, Coupon $coupon): RedirectResponse
    {
        $coupon->update($request->validated());

        return redirect()->route('admin.coupons.index')
            ->with('success', "Coupon '{$coupon->code}' updated successfully.");
    }

    public function destroy(Coupon $coupon): RedirectResponse
    {
        Gate::authorize('delete-coupons');

        $code = $coupon->code;
        $coupon->delete();

        return redirect()->route('admin.coupons.index')
            ->with('success', "Coupon '{$code}' deleted successfully.");
    }
}
