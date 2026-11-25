@extends('admin.layouts.admin-master')

@section('title', 'Create Coupon')

@section('content')
    <div class="heading">
        <div>
            <small>ACADEMY MODULE</small>
            <h1>Create Discount Coupon</h1>
            <p>Configure discount codes for specific courses or all courses.</p>
        </div>
        <div>
            <a href="{{ route('admin.coupons.index') }}" class="btn light">
                <i class="bi bi-arrow-left me-1"></i> Back to Coupons
            </a>
        </div>
    </div>

    <div class="card form-card">
        <form action="{{ route('admin.coupons.store') }}" method="POST">
            @csrf

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label" for="code">Coupon Code <span class="text-danger">*</span></label>
                    <input type="text" id="code" name="code"
                        class="form-control text-uppercase @error('code') is-invalid @enderror"
                        value="{{ old('code') }}" placeholder="e.g. PSTEARLY20" required autofocus>
                    @error('code')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label" for="course_id">Target Course <span class="text-muted">(Leave blank for all courses)</span></label>
                    <select id="course_id" name="course_id" class="form-select @error('course_id') is-invalid @enderror">
                        <option value="">All Paid Courses</option>
                        @foreach ($courses ?? [] as $c)
                            <option value="{{ $c->id }}" {{ (string) old('course_id') === (string) $c->id ? 'selected' : '' }}>
                                {{ $c->title }} {{ $c->batch_no ? "({$c->batch_no})" : '' }}
                            </option>
                        @endforeach
                    </select>
                    @error('course_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label" for="discount_type">Discount Type <span class="text-danger">*</span></label>
                    <select id="discount_type" name="discount_type" class="form-select @error('discount_type') is-invalid @enderror" required>
                        @foreach ($discountTypes ?? [] as $dt)
                            <option value="{{ $dt->value }}" {{ old('discount_type') === $dt->value ? 'selected' : '' }}>
                                {{ $dt->label() }}
                            </option>
                        @endforeach
                    </select>
                    @error('discount_type')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label" for="discount_value">Discount Value <span class="text-danger">*</span></label>
                    <input type="number" step="0.01" id="discount_value" name="discount_value"
                        class="form-control @error('discount_value') is-invalid @enderror"
                        value="{{ old('discount_value') }}" placeholder="e.g. 20 or 500" required>
                    @error('discount_value')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label" for="max_discount">Max Discount Cap <span class="text-muted">(Optional)</span></label>
                    <input type="number" step="0.01" id="max_discount" name="max_discount"
                        class="form-control @error('max_discount') is-invalid @enderror"
                        value="{{ old('max_discount') }}" placeholder="For percentage coupons">
                    @error('max_discount')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label" for="usage_limit">Usage Limit <span class="text-muted">(Optional)</span></label>
                    <input type="number" id="usage_limit" name="usage_limit" min="1"
                        class="form-control @error('usage_limit') is-invalid @enderror"
                        value="{{ old('usage_limit') }}" placeholder="Unlimited if empty">
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label" for="start_date">Valid From <span class="text-muted">(Optional)</span></label>
                    <input type="datetime-local" id="start_date" name="start_date"
                        class="form-control @error('start_date') is-invalid @enderror"
                        value="{{ old('start_date') }}">
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label" for="expires_at">Expires At <span class="text-muted">(Optional)</span></label>
                    <input type="datetime-local" id="expires_at" name="expires_at"
                        class="form-control @error('expires_at') is-invalid @enderror"
                        value="{{ old('expires_at') }}">
                </div>

                <div class="col-12 mb-3">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1"
                            {{ old('is_active', true) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">Active</label>
                    </div>
                </div>
            </div>

            <hr class="my-4">

            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('admin.coupons.index') }}" class="btn light">Cancel</a>
                <button type="submit" class="btn primary">
                    <i class="bi bi-check-lg me-1"></i> Create Coupon
                </button>
            </div>
        </form>
    </div>
@endsection
