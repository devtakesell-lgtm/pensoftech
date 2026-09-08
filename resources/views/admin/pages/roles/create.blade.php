@extends('admin.layouts.admin-master')

@section('title', 'Create New Role')

@section('content')
<div class="heading">
    <div>
        <small>ACCESS CONTROL</small>
        <h1>Create New Role</h1>
        <p>Define a new agency role and select the permissions granted to members with this role.</p>
    </div>
    <div>
        <a href="{{ route('admin.roles.index') }}" class="btn light" style="text-decoration: none;">
            &larr; Back to Roles
        </a>
    </div>
</div>

@if($errors->any())
    <div style="background: rgba(239, 68, 68, 0.12); border: 1px solid #ef4444; color: #991b1b; padding: 14px 18px; border-radius: 8px; margin-bottom: 24px;">
        <strong>Please fix the following errors:</strong>
        <ul style="margin: 8px 0 0 20px;">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('admin.roles.store') }}" method="POST">
    @csrf

    {{-- Role Details Card --}}
    <div class="card" style="padding: 24px; margin-bottom: 24px; background: #fff; border-radius: 12px; border: 1px solid #edf0f7;">
        <h3 style="font-size: 16px; font-weight: 700; margin-bottom: 16px; color: #101426;">Role Information</h3>
        
        <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 20px; margin-bottom: 16px;">
            <div>
                <label style="display: block; font-weight: 600; margin-bottom: 6px; font-size: 13px;">Role Name *</label>
                <input type="text" name="name" value="{{ old('name') }}" placeholder="e.g. Sales Executive" required
                    style="width: 100%; padding: 10px 14px; border: 1px solid #d1d5db; border-radius: 8px; font-size: 14px;">
                <small style="color: #737c91; font-size: 12px; display: block; margin-top: 4px;">Will be formatted as a slug (e.g. sales-executive).</small>
            </div>
            <div>
                <label style="display: block; font-weight: 600; margin-bottom: 6px; font-size: 13px;">Description</label>
                <input type="text" name="description" value="{{ old('description') }}" placeholder="Brief description of the responsibilities..."
                    style="width: 100%; padding: 10px 14px; border: 1px solid #d1d5db; border-radius: 8px; font-size: 14px;">
            </div>
        </div>

        {{-- Core Dashboard Access Toggle --}}
        <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 14px 16px; display: flex; align-items: center; gap: 12px;">
            <input type="checkbox" name="permissions[]" value="access-admin" id="perm_access_admin"
                {{ in_array('access-admin', old('permissions', ['access-admin'])) ? 'checked' : '' }}
                style="width: 18px; height: 18px; accent-color: #6d4aff; cursor: pointer;">
            <div>
                <label for="perm_access_admin" style="font-weight: 700; color: #101426; cursor: pointer; display: block; font-size: 14px;">
                    🔑 Grant Staff Dashboard Access (access-admin)
                </label>
                <small style="color: #64748b; font-size: 12px;">
                    Required for this role to log in and view the agency administrative panel.
                </small>
            </div>
        </div>
    </div>

    {{-- Module Permissions Picker --}}
    <div style="margin-bottom: 16px; display: flex; justify-content: space-between; align-items: center;">
        <h3 style="font-size: 16px; font-weight: 700; color: #101426; margin: 0;">Module Permissions</h3>
        <span style="font-size: 12px; color: #64748b;">Select granular abilities for this role</span>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 20px; margin-bottom: 32px;">
        @foreach($permissionsByModule as $module => $modulePermissions)
            @if($module !== 'general')
                <div class="card" style="padding: 20px; background: #fff; border-radius: 12px; border: 1px solid #edf0f7;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px; padding-bottom: 8px; border-bottom: 1px solid #f1f5f9;">
                        <strong style="text-transform: uppercase; font-size: 13px; color: #334155; letter-spacing: 0.5px;">
                            {{ $module }}
                        </strong>
                        <button type="button" onclick="toggleModuleCheckboxes('{{ $module }}')" 
                            style="background: none; border: none; color: #6d4aff; font-size: 12px; font-weight: 600; cursor: pointer;">
                            Select / Deselect All
                        </button>
                    </div>

                    <div style="display: flex; flex-direction: column; gap: 8px;">
                        @foreach($modulePermissions as $permission)
                            <label style="display: flex; align-items: center; gap: 10px; cursor: pointer; font-size: 13px; color: #1e293b;">
                                <input type="checkbox" name="permissions[]" value="{{ $permission->name }}"
                                    class="module-perm-{{ $module }}"
                                    {{ in_array($permission->name, old('permissions', [])) ? 'checked' : '' }}
                                    style="width: 16px; height: 16px; accent-color: #6d4aff; cursor: pointer;">
                                <span>{{ $permission->name }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
            @endif
        @endforeach
    </div>

    <div style="display: flex; justify-content: flex-end; gap: 12px;">
        <a href="{{ route('admin.roles.index') }}" class="btn light" style="text-decoration: none;">Cancel</a>
        <button type="submit" class="btn primary">＋ Save & Create Role</button>
    </div>
</form>

<script>
function toggleModuleCheckboxes(moduleName) {
    const checkboxes = document.querySelectorAll('.module-perm-' + moduleName);
    const allChecked = Array.from(checkboxes).every(cb => cb.checked);
    checkboxes.forEach(cb => cb.checked = !allChecked);
}
</script>
@endsection
