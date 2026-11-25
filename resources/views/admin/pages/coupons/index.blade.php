@extends('admin.layouts.admin-master')

@section('title', 'Discount Coupons')

@section('content')
    <div class="heading">
        <div>
            <small>ACADEMY MODULE</small>
            <h1>Discount Coupons</h1>
            <p>Create and manage course-specific or global discount coupon codes.</p>
        </div>
        <div>
            @can('create-coupons')
                <a href="{{ route('admin.coupons.create') }}" class="btn primary">
                    <i class="bi bi-plus-lg me-1"></i> Add Coupon
                </a>
            @endcan
        </div>
    </div>

    {{-- Flash Alerts --}}
    @if (session('success'))
        <div class="alert-custom alert-custom-success mb-3">
            <i class="bi bi-check-circle-fill"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <div class="card list-card">
        <div class="toolbar">
            <form method="GET" action="{{ route('admin.coupons.index') }}" class="toolbar-filters">
                <input type="text" name="search" value="{{ $currentSearch ?? '' }}"
                    placeholder="Search coupon code..." class="filter-search-input">

                <select name="course_id" onchange="this.form.submit()" class="filter-select">
                    <option value="">All Courses</option>
                    @foreach ($courses ?? [] as $c)
                        <option value="{{ $c->id }}" {{ (string) ($currentCourse ?? '') === (string) $c->id ? 'selected' : '' }}>
                            {{ $c->title }}
                        </option>
                    @endforeach
                </select>

                <select name="is_active" onchange="this.form.submit()" class="filter-select">
                    <option value="">All Status</option>
                    <option value="1" {{ ($currentActive ?? '') === '1' ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ ($currentActive ?? '') === '0' ? 'selected' : '' }}>Inactive</option>
                </select>

                <button type="submit" class="btn light">Filter</button>
                @if (!empty($currentSearch) || !empty($currentCourse) || ($currentActive ?? '') !== '')
                    <a href="{{ route('admin.coupons.index') }}" class="btn light filter-btn-reset">Reset</a>
                @endif
            </form>
        </div>

        <div class="tablewrap">
            <table>
                <thead>
                    <tr>
                        <th>COUPON CODE</th>
                        <th>APPLICABLE COURSE</th>
                        <th>DISCOUNT</th>
                        <th>USAGE</th>
                        <th>VALIDITY</th>
                        <th>STATUS</th>
                        <th class="text-end-align">ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($coupons ?? [] as $coupon)
                        <tr>
                            <td><code class="fw-bold fs-6">{{ $coupon->code }}</code></td>
                            <td>
                                @if ($coupon->course)
                                    <span>{{ $coupon->course->title }}</span>
                                @else
                                    <span class="badge bg-info-subtle text-info border">All Paid Courses</span>
                                @endif
                            </td>
                            <td>
                                @if ($coupon->discount_type === \App\Enums\CouponDiscountType::Percentage)
                                    <strong>{{ number_format($coupon->discount_value, 0) }}% OFF</strong>
                                    @if ($coupon->max_discount)
                                        <div class="text-muted small">Max: {{ $defaultCurrency?->symbol ?? '৳' }}{{ number_format($coupon->max_discount, 2) }}</div>
                                    @endif
                                @else
                                    <strong>{{ $defaultCurrency?->symbol ?? '৳' }}{{ number_format($coupon->discount_value, 2) }} OFF</strong>
                                @endif
                            </td>
                            <td>
                                <span>{{ $coupon->used_count }} / {{ $coupon->usage_limit ?? '∞' }}</span>
                            </td>
                            <td>
                                @if ($coupon->expires_at)
                                    <div class="small">Expires: {{ $coupon->expires_at->format('d M Y') }}</div>
                                @else
                                    <span class="text-muted small">No expiry</span>
                                @endif
                            </td>
                            <td>
                                @if ($coupon->is_active)
                                    <span class="badge bg-success-subtle text-success border border-success-subtle">Active</span>
                                @else
                                    <span class="badge bg-secondary-subtle text-secondary border">Inactive</span>
                                @endif
                            </td>
                            <td class="text-end-align">
                                <div class="d-inline-flex gap-1">
                                    @can('edit-coupons')
                                        <a href="{{ route('admin.coupons.edit', $coupon) }}" class="btn light icon-btn" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                    @endcan
                                    @can('delete-coupons')
                                        <form action="{{ route('admin.coupons.destroy', $coupon) }}" method="POST"
                                            onsubmit="return confirm('Delete this coupon?');" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn light icon-btn text-danger" title="Delete">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">No coupons found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if (isset($coupons) && $coupons->hasPages())
            <div class="p-3">{{ $coupons->links() }}</div>
        @endif
    </div>
@endsection
