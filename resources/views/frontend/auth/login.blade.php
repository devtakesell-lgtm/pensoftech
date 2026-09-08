@extends('frontend.layouts.front-master')

@section('title', 'Client Sign In')

@section('content')
<section class="section client-auth-section">
    <div class="container client-auth-container">
        
        <div class="client-auth-card">
            
            <!-- Header -->
            <div class="client-auth-header">
                <div class="kicker">Client Portal</div>
                <h1 class="client-auth-title">Sign In to Your Account</h1>
                <p class="client-auth-subtitle">Access your project updates, quotes, and agency services.</p>
            </div>

            <!-- Status Alert -->
            @if (session('status'))
                <div class="auth-alert-status">
                    {{ session('status') }}
                </div>
            @endif

            <!-- Error Alert -->
            @if ($errors->any())
                <div class="auth-alert-error">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Form -->
            <form method="POST" action="{{ route('login.submit') }}" novalidate>
                @csrf

                <!-- Email -->
                <div class="field @error('email') has-error @enderror">
                    <label for="email">Email Address</label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        value="{{ old('email') }}" 
                        placeholder="you@company.com" 
                        required 
                        autofocus
                    >
                    @error('email')
                        <span class="err-msg">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Password -->
                <div class="field @error('password') has-error @enderror">
                    <label for="password">Password</label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        placeholder="••••••••" 
                        required 
                    >
                    @error('password')
                        <span class="err-msg">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Remember Me -->
                <div class="auth-remember-row">
                    <label class="auth-remember-label">
                        <input type="checkbox" name="remember" value="1" {{ old('remember') ? 'checked' : '' }}>
                        Remember me
                    </label>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-ink btn-auth-full">
                    Sign In
                </button>
            </form>

            <!-- Register Link Footer -->
            <div class="client-auth-footer">
                Don't have a client account? 
                <a href="{{ route('register') }}" class="client-auth-link">Create one now</a>
            </div>

        </div>

        <div class="client-auth-subfooter">
            Agency staff member? <a href="{{ route('admin.login') }}">Staff login here</a>
        </div>

    </div>
</section>
@endsection
