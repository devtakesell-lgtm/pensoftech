@extends('admin.layouts.admin-master')

@section('title', 'Edit Role: ' . $role->name)

@section('content')
<div class="heading">
    <div>
        <small>ACCESS CONTROL</small>
        <h1>Edit Role: {{ ucwords(str_replace('-', ' ', $role->name)) }}</h1>
        <p>Update role details and adjust assigned module permissions.</p>
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

@if($role->name === 'administrator')
    <div style="background: rgba(16, 185, 129, 0.12); border: 1px solid #10b981; color: #065f46; padding: 14px 18px; border-radius: 8px; margin-bottom: 24px;">
        ★ <strong>Super Admin Notice:</strong> The Administrator role automatically possesses universal bypass access to all current and future modules.
    </div>
@endif

<form action="{{ route('admin.roles.update', $role) }}" method="POST">
    @csrf
    @method('PUT')

    {{-- Role Details Card --}}
    <div class="card" style="padding: 24px; margin-bottom: 24px; background: #fff; border-radius: 12px; border: 1px solid #edf0f7;">
        <h3 style="font-size: 16px; font-weight: 700; margin-bottom: 16px; color: #101426;">Role Information</h3>
        
        <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 20px; margin-bottom: 16px;">
            <div>
                <label style="display: block; font-weight: 600; margin-bottom: 6px; font-size: 13px;">Role Name *</label>
                <input type="text" name="name" value="{{ old('name', $role->name) }}" required
                    {{ in_array($role->name, ['administrator', 'client'], true) ? 'readonly' : '' }}
                    style="width: 100%; padding: 10px 14px; border: 1px solid #d1d5db; border-radius: 8px; font-size: 14px; {{ in_array($role->name, ['administrator', 'client'], true) ? 'background: #f1f5f9; cursor: not-allowed;' : '' }}">
                @if(in_array($role->name, ['administrator', 'client'], true))
                    <small style="color: #64748b; font-size: 12px; display: block; margin-top: 4px;">System role name is protected.</small>
                @endif
            </div>
            <div>
                <label style="display: block; font-weight: 600; margin-bottom: 6px; font-size: 13px;">Description</label>
                <input type="text" name="description" value="{{ old('description', $role->description) }}" placeholder="Role responsibilities..."
                    style="width: 100%; padding: 10px 14px; border: 1px solid #d1d5db; border-radius: 8px; font-size: 14px;">
            </div>
        </div>

        {{-- Core Dashboard Access Toggle --}}
        @if($role->name !== 'administrator')
            <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 14px 16px; display: flex; align-items: center; gap: 12px;">
                <input type="checkbox" name="permissions[]" value="access-admin" id="perm_access_admin"
                    {{ in_array('access-admin', old('permissions', $rolePermissionNames)) ? 'checked' : '' }}
                    style="width: 18px; height: 18px; accent-color: #6d4aff; cursor: pointer;">
                <div>
                    <label for="perm_access_admin" style="font-weight: 700; color: #101426; cursor: pointer; display: block; font-size: 14px;">
                        🔑 Grant Staff Dashboard Access (access-admin)
                    </label>
                    <small style="color: #64748b; font-size: 12px;">
                        Enable this checkbox to allow users with this role to enter the agency admin dashboard.
                    </small>
                </div>
            </div>
        @endif
    </div>

    @if($role->name !== 'administrator')
        {{-- Module Permissions Picker --}}
        <div style="margin-bottom: 16px; display: flex; justify-content: space-between; align-items: center;">
            <h3 style="font-size: 16px; font-weight: 700; color: #101426; margin: 0;">Module Permissions</h3>
            <span style="font-size: 12px; color: #64748b;">Toggle abilities for this role</span>
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
                                        {{ in_array($permission->name, old('permissions', $rolePermissionNames)) ? 'checked' : '' }}
                                        style="width: 16px; height: 16px; accent-color: #6d4aff; cursor: pointer;">
                                    <span>{{ $permission->name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    @endif

    <div style="display: flex; justify-content: flex-end; gap: 12px;">
        <a href="{{ route('admin.roles.index') }}" class="btn light" style="text-decoration: none;">Cancel</a>
        <button type="submit" class="btn primary">✓ Save Changes</button>
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
