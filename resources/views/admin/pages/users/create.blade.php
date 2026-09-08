@extends('admin.layouts.admin-master')

@section('title', 'Create New User')

@section('content')
<div class="heading">
    <div>
        <small>TEAM MANAGEMENT</small>
        <h1>Create New Team Member</h1>
        <p>Add a new agency staff user, configure their credentials, and assign their agency role.</p>
    </div>
    <div>
        <a href="{{ route('admin.users') }}" class="btn light" style="text-decoration: none;">
            &larr; Back to Users
        </a>
    </div>
</div>

{{-- Validation Errors --}}
@if($errors->any())
    <div style="background: rgba(239, 68, 68, 0.12); border: 1px solid #ef4444; color: #991b1b; padding: 14px 18px; border-radius: 8px; margin-bottom: 24px;">
        <strong style="display: block; margin-bottom: 6px;">Please resolve the following issues:</strong>
        <ul style="margin: 0 0 0 20px;">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('admin.users.store') }}" method="POST">
    @csrf

    {{-- Card 1: Basic Information --}}
    <div class="card" style="padding: 24px; margin-bottom: 24px; background: #fff; border-radius: 12px; border: 1px solid #edf0f7;">
        <h3 style="font-size: 16px; font-weight: 700; margin-bottom: 16px; color: #101426;">
            User Profile Information
        </h3>
        
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px;">
            <div>
                <label style="display: block; font-weight: 600; margin-bottom: 6px; font-size: 13px;">Full Name *</label>
                <input type="text" name="name" value="{{ old('name') }}" placeholder="e.g. Sarah Jenkins" required
                    style="width: 100%; padding: 10px 14px; border: 1px solid #d1d5db; border-radius: 8px; font-size: 14px;">
            </div>

            <div>
                <label style="display: block; font-weight: 600; margin-bottom: 6px; font-size: 13px;">Email Address *</label>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="sarah@pensoftech.com" required
                    style="width: 100%; padding: 10px 14px; border: 1px solid #d1d5db; border-radius: 8px; font-size: 14px;">
            </div>

            <div>
                <label style="display: block; font-weight: 600; margin-bottom: 6px; font-size: 13px;">Phone Number</label>
                <input type="text" name="phone" value="{{ old('phone') }}" placeholder="+880 1700-000000"
                    style="width: 100%; padding: 10px 14px; border: 1px solid #d1d5db; border-radius: 8px; font-size: 14px;">
            </div>
        </div>
    </div>

    {{-- Card 2: Professional Role Assignment --}}
    <div class="card" style="padding: 24px; margin-bottom: 24px; background: #fff; border-radius: 12px; border: 1px solid #edf0f7;">
        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 16px; flex-wrap: wrap; gap: 8px;">
            <div>
                <h3 style="font-size: 16px; font-weight: 700; color: #101426; margin-bottom: 4px;">
                    Assign Agency Role *
                </h3>
                <span style="font-size: 13px; color: #64748b;">
                    Select the role that governs this user's permissions and access privileges.
                </span>
            </div>
            <a href="{{ route('admin.roles.index') }}" target="_blank" class="btn light" style="font-size: 12px; padding: 6px 12px; text-decoration: none;">
                View Roles Matrix &nearr;
            </a>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 14px;">
            @foreach($roles ?? [] as $role)
                @php
                    $isSelected = (int) old('role_id') === (int) $role->id;
                    $isSuperAdmin = $role->name === 'administrator';
                @endphp
                <label style="display: block; border: 2px solid {{ $isSelected ? '#6d4aff' : '#e2e8f0' }}; border-radius: 10px; padding: 16px; cursor: pointer; transition: all 0.2s ease; background: {{ $isSelected ? '#fcfaff' : '#fff' }};"
                    class="role-card">
                    <div style="display: flex; align-items: flex-start; gap: 12px;">
                        <input type="radio" name="role_id" value="{{ $role->id }}" {{ $isSelected ? 'checked' : '' }} required
                            style="width: 18px; height: 18px; accent-color: #6d4aff; cursor: pointer; margin-top: 2px;">
                        <div style="flex: 1;">
                            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 4px;">
                                <strong style="font-size: 14px; color: #101426;">
                                    {{ ucwords(str_replace('-', ' ', $role->name)) }}
                                </strong>
                                @if($isSuperAdmin)
                                    <span style="background: rgba(109, 74, 255, 0.12); color: #6d4aff; font-size: 11px; font-weight: 700; padding: 2px 8px; border-radius: 4px;">
                                        ★ Full Access
                                    </span>
                                @else
                                    <span style="background: #f1f5f9; color: #64748b; font-size: 11px; font-weight: 600; padding: 2px 8px; border-radius: 4px;">
                                        Staff Role
                                    </span>
                                @endif
                            </div>
                            <p style="font-size: 12px; color: #64748b; margin: 0; line-height: 1.4;">
                                {{ $role->description ?: 'Standard agency staff permissions.' }}
                            </p>
                        </div>
                    </div>
                </label>
            @endforeach
        </div>
    </div>

    {{-- Card 3: Password & Security --}}
    <div class="card" style="padding: 24px; margin-bottom: 24px; background: #fff; border-radius: 12px; border: 1px solid #edf0f7;">
        <h3 style="font-size: 16px; font-weight: 700; margin-bottom: 16px; color: #101426;">
            Credentials & Security
        </h3>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px;">
            <div>
                <label style="display: block; font-weight: 600; margin-bottom: 6px; font-size: 13px;">Password *</label>
                <input type="password" name="password" required placeholder="Minimum 8 characters"
                    style="width: 100%; padding: 10px 14px; border: 1px solid #d1d5db; border-radius: 8px; font-size: 14px;">
            </div>

            <div>
                <label style="display: block; font-weight: 600; margin-bottom: 6px; font-size: 13px;">Confirm Password *</label>
                <input type="password" name="password_confirmation" required placeholder="Re-type password"
                    style="width: 100%; padding: 10px 14px; border: 1px solid #d1d5db; border-radius: 8px; font-size: 14px;">
            </div>
        </div>
    </div>

    {{-- Card 4: Account Status --}}
    <div class="card" style="padding: 20px 24px; margin-bottom: 28px; background: #fff; border-radius: 12px; border: 1px solid #edf0f7;">
        <div style="display: flex; align-items: center; gap: 12px;">
            <input type="hidden" name="is_active" value="0">
            <input type="checkbox" name="is_active" value="1" id="is_active" {{ old('is_active', '1') == '1' ? 'checked' : '' }}
                style="width: 18px; height: 18px; accent-color: #6d4aff; cursor: pointer;">
            <div>
                <label for="is_active" style="font-weight: 700; color: #101426; cursor: pointer; display: block; font-size: 14px;">
                    Active Account Status
                </label>
                <small style="color: #64748b; font-size: 12px;">
                    Active members can authenticate and access the panel according to their assigned role.
                </small>
            </div>
        </div>
    </div>

    {{-- Actions --}}
    <div style="display: flex; gap: 12px;">
        <button type="submit" class="btn primary" style="padding: 12px 28px; font-size: 14px; font-weight: 600;">
            ✓ Create User
        </button>
        <a href="{{ route('admin.users') }}" class="btn light" style="padding: 12px 24px; font-size: 14px; text-decoration: none;">
            Cancel
        </a>
    </div>
</form>
@endsection
