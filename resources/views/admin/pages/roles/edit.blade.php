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
            <a href="{{ route('admin.roles.index') }}" class="btn light">
                <i class="bi bi-arrow-left me-1"></i> Back to Roles
            </a>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert-custom alert-custom-danger">
            <div>
                <strong>Please fix the following errors:</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    @if ($role->name === 'administrator')
        <div class="alert-custom alert-custom-info">
            <i class="bi bi-star-fill text-warning"></i>
            <div>
                <strong>Super Admin Notice:</strong> The Administrator role automatically possesses universal bypass access to
                all current and future modules.
            </div>
        </div>
    @endif

    <form action="{{ route('admin.roles.update', $role) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Role Details Card --}}
        <div class="card form-card">
            <h3 class="form-card-title">Role Information</h3>

            <div class="form-grid-role-info">
                <div class="form-group">
                    <label class="form-label">Role Name *</label>
                    <input type="text" name="name" value="{{ old('name', $role->name) }}" required
                        {{ in_array($role->name, ['administrator', 'client'], true) ? 'readonly' : '' }}
                        class="form-input {{ in_array($role->name, ['administrator', 'client'], true) ? 'form-input-disabled' : '' }}">
                    @if (in_array($role->name, ['administrator', 'client'], true))
                        <small class="form-help-text">System role name is protected.</small>
                    @endif
                </div>
                <div class="form-group">
                    <label class="form-label">Description</label>
                    <input type="text" name="description" value="{{ old('description', $role->description) }}"
                        placeholder="Role responsibilities..." class="form-input">
                </div>
            </div>

            {{-- Core Dashboard Access Toggle --}}
            @if ($role->name !== 'administrator')
                <div class="form-toggle-card">
                    <input type="checkbox" name="permissions[]" value="access-admin" id="perm_access_admin"
                        {{ in_array('access-admin', old('permissions', $rolePermissionNames)) ? 'checked' : '' }}
                        class="form-toggle-input">
                    <div>
                        <label for="perm_access_admin" class="form-toggle-label">
                            Grant Staff Dashboard Access (access-admin)
                        </label>
                        <small class="form-toggle-desc">
                            Enable this checkbox to allow users with this role to enter the agency admin dashboard.
                        </small>
                    </div>
                </div>
            @endif
        </div>

        @if ($role->name !== 'administrator')
            {{-- Module Permissions Picker --}}
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3 class="form-card-title mb-0">Module Permissions</h3>
                <span class="form-card-subtitle mb-0">Toggle abilities for this role</span>
            </div>

            <div class="perm-matrix-grid">
                @foreach ($permissionsByModule as $module => $modulePermissions)
                    @if ($module !== 'general')
                        <div class="card perm-module-card">
                            <div class="perm-module-header">
                                <strong class="perm-module-title">
                                    {{ $module }}
                                </strong>
                                <button type="button" onclick="toggleModuleCheckboxes('{{ $module }}')"
                                    class="perm-select-all-btn">
                                    Select / Deselect All
                                </button>
                            </div>

                            <div class="perm-item-list">
                                @foreach ($modulePermissions as $permission)
                                    <label class="perm-checkbox-label">
                                        <input type="checkbox" name="permissions[]" value="{{ $permission->name }}"
                                            class="module-perm-{{ $module }} perm-checkbox-input"
                                            {{ in_array($permission->name, old('permissions', $rolePermissionNames)) ? 'checked' : '' }}>
                                        <span>{{ $permission->name }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        @endif

        <div class="form-actions-end">
            <a href="{{ route('admin.roles.index') }}" class="btn light">Cancel</a>
            <button type="submit" class="btn primary">
                <i class="bi bi-check2 me-1"></i> Save Changes
            </button>
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
