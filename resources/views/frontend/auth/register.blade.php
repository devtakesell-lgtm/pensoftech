@extends('frontend.layouts.front-master')

@section('title', 'Client Registration')

@section('content')
<section class="section client-auth-section">
    <div class="container client-auth-container">
        
        <div class="client-auth-card">
            
            <!-- Header -->
            <div class="client-auth-header">
                <div class="kicker">Get Started</div>
                <h1 class="client-auth-title">Create a Client Account</h1>
                <p class="client-auth-subtitle">Collaborate on software projects, track quotes, and view services.</p>
            </div>

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
            <form method="POST" action="{{ route('register.submit') }}" novalidate>
                @csrf

                <!-- Name Field -->
                <div class="field @error('name') has-error @enderror">
                    <label for="name">Full Name *</label>
                    <input 
                        type="text" 
                        id="name" 
                        name="name" 
                        value="{{ old('name') }}" 
                        placeholder="John Doe" 
                        required 
                        autofocus
                    >
                    @error('name')
                        <span class="err-msg">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Email Field -->
                <div class="field @error('email') has-error @enderror">
                    <label for="email">Work Email *</label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        value="{{ old('email') }}" 
                        placeholder="john@yourcompany.com" 
                        required 
                    >
                    @error('email')
                        <span class="err-msg">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Company and Phone 2-column grid -->
                <div class="form-row">
                    <div class="field @error('company_name') has-error @enderror">
                        <label for="company_name">Company (Optional)</label>
                        <input 
                            type="text" 
                            id="company_name" 
                            name="company_name" 
                            value="{{ old('company_name') }}" 
                            placeholder="Acme Corp" 
                        >
                        @error('company_name')
                            <span class="err-msg">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="field @error('phone') has-error @enderror">
                        <label for="phone">Phone (Optional)</label>
                        <input 
                            type="tel" 
                            id="phone" 
                            name="phone" 
                            value="{{ old('phone') }}" 
                            placeholder="+1 555-0100" 
                        >
                        @error('phone')
                            <span class="err-msg">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Password and Confirm Password -->
                <div class="form-row">
                    <div class="field @error('password') has-error @enderror">
                        <label for="password">Password *</label>
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            placeholder="Min 8 characters" 
                            required 
                        >
                        @error('password')
                            <span class="err-msg">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="field">
                        <label for="password_confirmation">Confirm *</label>
                        <input 
                            type="password" 
                            id="password_confirmation" 
                            name="password_confirmation" 
                            placeholder="Repeat password" 
                            required 
                        >
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-ink btn-auth-full">
                    Create Account
                </button>
            </form>

            <!-- Sign In Link Footer -->
            <div class="client-auth-footer">
                Already have an account? 
                <a href="{{ route('login') }}" class="client-auth-link">Sign in</a>
            </div>

        </div>

        <div class="client-auth-subfooter">
            Agency staff member? <a href="{{ route('admin.login') }}">Staff login here</a>
        </div>

    </div>
</section>
@endsection
