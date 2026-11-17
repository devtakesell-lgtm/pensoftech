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
            <a href="{{ route('admin.users') }}" class="btn light">
                <i class="bi bi-arrow-left me-1"></i> Back to Users
            </a>
        </div>
    </div>

    {{-- Validation Errors --}}
    @if ($errors->any())
        <div class="alert-custom alert-custom-danger">
            <div>
                <strong>Please resolve the following issues:</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- Card 1: Basic Information --}}
        <div class="card form-card">
            <h3 class="form-card-title">
                User Profile Information
            </h3>

            <div class="row">
                <div class="col-md-3 mb-4 mb-md-0">
                    <x-admin.components.forms.image-upload name="avatar" label="Profile Avatar" aspect="square" />
                </div>
                <div class="col-md-9">
                    <div class="form-grid-2">
                        <div class="form-group">
                            <label class="form-label">Full Name *</label>
                            <input type="text" name="name" value="{{ old('name') }}" placeholder="e.g. Sarah Jenkins"
                                required class="form-input">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Email Address *</label>
                            <input type="email" name="email" value="{{ old('email') }}" placeholder="sarah@pensoftech.com"
                                required class="form-input">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Phone Number</label>
                            <input type="text" name="phone" value="{{ old('phone') }}" placeholder="+880 1700-000000"
                                class="form-input">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Card 2: Team Profile Information --}}
        <div class="card form-card">
            <div class="d-flex justify-content-between align-items-start mb-4 flex-wrap gap-2">
                <div class="d-flex flex-column">
                    <h3 class="form-card-title mb-1">Team Profile Information <span
                            style="font-weight:normal; font-size:14px; color:#6b7280;">(Optional)</span></h3>
                    <p class="form-card-subtitle mb-0">Visible on the frontend Leadership/Team page and Blog Author
                        sections.</p>
                </div>
            </div>

            <div class="form-group mb-4">
                <label class="form-label">Job Title / Designation</label>
                <input type="text" name="designation" value="{{ old('designation') }}"
                    placeholder="e.g. Chief Executive Officer" class="form-input">
            </div>

            <div class="form-group mb-4">
                <label class="form-label">Short Bio</label>
                <textarea name="short_bio" rows="3" class="form-input" placeholder="Brief professional biography...">{{ old('short_bio') }}</textarea>
            </div>

            <div class="form-grid-2 mb-4">
                <div class="form-group">
                    <label class="form-label">LinkedIn URL</label>
                    <input type="url" name="social_links[linkedin]" value="{{ old('social_links.linkedin') }}"
                        placeholder="https://linkedin.com/in/username" class="form-input">
                </div>
                <div class="form-group">
                    <label class="form-label">Twitter/X URL</label>
                    <input type="url" name="social_links[twitter]" value="{{ old('social_links.twitter') }}"
                        placeholder="https://twitter.com/username" class="form-input">
                </div>
                <div class="form-group">
                    <label class="form-label">Facebook URL</label>
                    <input type="url" name="social_links[facebook]" value="{{ old('social_links.facebook') }}"
                        placeholder="https://facebook.com/username" class="form-input">
                </div>
                <div class="form-group">
                    <label class="form-label">GitHub URL</label>
                    <input type="url" name="social_links[github]" value="{{ old('social_links.github') }}"
                        placeholder="https://github.com/username" class="form-input">
                </div>
            </div>

            <div class="form-toggle-card">
                <input type="hidden" name="show_on_team_page" value="0">
                <input type="checkbox" name="show_on_team_page" value="1" id="show_on_team_page"
                    {{ old('show_on_team_page') == '1' ? 'checked' : '' }} class="form-toggle-input">
                <div>
                    <label for="show_on_team_page" class="form-toggle-label">Show on Frontend Team Page</label>
                    <small class="form-toggle-desc">If enabled, this profile will be publicly listed on the leadership/team
                        page.</small>
                </div>
            </div>
        </div>

        {{-- Card 2: Professional Role Assignment --}}
        <div class="card form-card">
            <div class="d-flex justify-content-between align-items-start mb-3 flex-wrap gap-2">
                <div class="d-flex flex-column">
                    <h3 class="form-card-title mb-1">
                        Assign Agency Role *
                    </h3>
                    <p class="form-card-subtitle mb-0">
                        Select the role that governs this user's permissions and access privileges.
                    </p>
                </div>
                <a href="{{ route('admin.roles.index') }}" target="_blank" class="btn light">
                    View Roles Matrix <i class="bi bi-box-arrow-up-right ms-1"></i>
                </a>
            </div>

            <div class="role-radio-grid">
                @foreach ($roles ?? [] as $role)
                    @php
                        $isSelected = (int) old('role_id') === (int) $role->id;
                        $isSuperAdmin = $role->name === 'administrator';
                    @endphp
                    <label class="role-radio-card {{ $isSelected ? 'selected' : '' }}">
                        <div class="role-radio-card-body">
                            <input type="radio" name="role_id" value="{{ $role->id }}"
                                {{ $isSelected ? 'checked' : '' }} required class="role-radio-input">
                            <div class="flex-grow-1">
                                <div class="role-radio-title-row">
                                    <strong class="role-radio-name">
                                        {{ ucwords(str_replace('-', ' ', $role->name)) }}
                                    </strong>
                                    @if ($isSuperAdmin)
                                        <span class="role-badge role-badge-admin">
                                            <i class="bi bi-star-fill me-1"></i> Full Access
                                        </span>
                                    @else
                                        <span class="badge-tag-custom">
                                            Staff Role
                                        </span>
                                    @endif
                                </div>
                                <p class="role-radio-desc">
                                    {{ $role->description ?: 'Standard agency staff permissions.' }}
                                </p>
                            </div>
                        </div>
                    </label>
                @endforeach
            </div>
        </div>

        {{-- Card 3: Password & Security --}}
        <div class="card form-card">
            <h3 class="form-card-title">
                Credentials & Security
            </h3>

            <div class="form-grid-2">
                <div class="form-group">
                    <label class="form-label">Password *</label>
                    <input type="password" name="password" required placeholder="Minimum 8 characters"
                        class="form-input">
                </div>

                <div class="form-group">
                    <label class="form-label">Confirm Password *</label>
                    <input type="password" name="password_confirmation" required placeholder="Re-type password"
                        class="form-input">
                </div>
            </div>
        </div>

        {{-- Card 4: Account Status --}}
        <div class="card form-card">
            <div class="form-toggle-card">
                <input type="hidden" name="is_active" value="0">
                <input type="checkbox" name="is_active" value="1" id="is_active"
                    {{ old('is_active', '1') == '1' ? 'checked' : '' }} class="form-toggle-input">
                <div>
                    <label for="is_active" class="form-toggle-label">
                        Active Account Status
                    </label>
                    <small class="form-toggle-desc">
                        Active members can authenticate and access the panel according to their assigned role.
                    </small>
                </div>
            </div>
        </div>

        {{-- Actions --}}
        <div class="form-actions">
            <button type="submit" class="btn primary">
                <i class="bi bi-check2 me-1"></i> Create User
            </button>
            <a href="{{ route('admin.users') }}" class="btn light">
                Cancel
            </a>
        </div>
    </form>
@endsection
