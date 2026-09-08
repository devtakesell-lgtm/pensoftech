@extends('admin.layouts.guest-master')

@section('title', 'Staff Sign In')

@section('content')
<div class="auth-card">
    <!-- Brand Header -->
    <a href="{{ route('home') }}" class="auth-brand">
        <div class="auth-logo">
            <i class="bi bi-shield-lock-fill"></i>
        </div>
        <div class="auth-brand-text">
            <h1>PenSoftTech</h1>
            <span>Agency Staff Portal</span>
        </div>
    </a>

    <!-- Headline -->
    <div class="auth-header">
        <h2>Sign In</h2>
        <p>Enter your agency credentials to access the admin workspace.</p>
    </div>

    <!-- Success/Status Alert -->
    @if (session('status'))
        <div class="alert alert-success d-flex align-items-center py-2 px-3 mb-3 border-0 rounded-3" style="font-size: 13px; background-color: #ecfdf5; color: #065f46;">
            <i class="bi bi-check-circle-fill me-2 fs-6"></i>
            <div>{{ session('status') }}</div>
        </div>
    @endif

    <!-- Error Summary Alert -->
    @if ($errors->any())
        <div class="alert alert-danger py-2 px-3 mb-3 border-0 rounded-3" style="font-size: 13px; background-color: #fef2f2; color: #991b1b;">
            <div class="d-flex align-items-center mb-1">
                <i class="bi bi-exclamation-triangle-fill me-2 fs-6"></i>
                <strong>Authentication Error</strong>
            </div>
            <ul class="mb-0 ps-3">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Form -->
    <form method="POST" action="{{ route('admin.login.submit') }}" novalidate>
        @csrf

        <!-- Email Field -->
        <div class="mb-3">
            <label for="email" class="form-label">Work Email Address</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                <input
                    type="email"
                    class="form-control @error('email') is-invalid @enderror"
                    id="email"
                    name="email"
                    value="{{ old('email') }}"
                    placeholder="staff@pensoftech.com"
                    required
                    autofocus
                >
            </div>
        </div>

        <!-- Password Field -->
        <div class="mb-3">
            <div class="d-flex justify-content-between align-items-center mb-1">
                <label for="password" class="form-label mb-0">Password</label>
            </div>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                <input
                    type="password"
                    class="form-control @error('password') is-invalid @enderror"
                    id="password"
                    name="password"
                    placeholder="••••••••"
                    required
                >
                <button class="btn input-group-text password-toggle" type="button" id="togglePasswordBtn" aria-label="Toggle password visibility">
                    <i class="bi bi-eye" id="togglePasswordIcon"></i>
                </button>
            </div>
        </div>

        <!-- Remember Me -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="remember" id="remember" value="1" {{ old('remember') ? 'checked' : '' }}>
                <label class="form-check-label" for="remember">
                    Remember this device
                </label>
            </div>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-submit">
            <span>Sign In to Admin</span>
            <i class="bi bi-arrow-right"></i>
        </button>
    </form>

    <div class="text-center">
        <div class="security-badge">
            <i class="bi bi-shield-check text-success"></i>
            <span>Authorized Agency Personnel Only</span>
        </div>
    </div>

    <div class="auth-footer">
        <a href="{{ route('home') }}">
            <i class="bi bi-box-arrow-up-left me-1"></i> Return to Main Website
        </a>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const toggleBtn = document.getElementById('togglePasswordBtn');
    const passwordInput = document.getElementById('password');
    const toggleIcon = document.getElementById('togglePasswordIcon');

    if (toggleBtn && passwordInput && toggleIcon) {
        toggleBtn.addEventListener('click', function () {
            const isPassword = passwordInput.getAttribute('type') === 'password';
            passwordInput.setAttribute('type', isPassword ? 'text' : 'password');
            toggleIcon.className = isPassword ? 'bi bi-eye-slash' : 'bi bi-eye';
        });
    }
</script>
@endpush
