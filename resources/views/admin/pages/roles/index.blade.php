@extends('admin.layouts.admin-master')

@section('title', 'Roles Management')

@section('content')
    <div class="heading">
        <div>
            <small>ACCESS CONTROL</small>
            <h1>Roles & Access Levels</h1>
            <p>Define agency staff roles and assign granular permissions to control access to each module.</p>
        </div>
        <div>
            <a href="{{ route('admin.permissions.index') }}" class="btn light me-2">
                <i class="bi bi-shield-check me-1"></i> View Permissions Audit
            </a>
            <a href="{{ route('admin.roles.create') }}" class="btn primary">
                <i class="bi bi-plus-lg me-1"></i> Create New Role
            </a>
        </div>
    </div>

    @if (session('success'))
        <div class="alert-custom alert-custom-success">
            <i class="bi bi-check-circle-fill"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if (session('error'))
        <div class="alert-custom alert-custom-danger">
            <i class="bi bi-exclamation-triangle-fill"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <div class="card list-card">
        <div class="tablewrap">
            <table>
                <thead>
                    <tr>
                        <th class="col-role-name">ROLE NAME</th>
                        <th>DESCRIPTION</th>
                        <th>ASSIGNED USERS</th>
                        <th>PERMISSIONS</th>
                        <th>TYPE</th>
                        <th class="text-end-align">ACTION</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($roles as $role)
                        <tr>
                            <td>
                                <strong class="user-meta-name">
                                    {{ ucwords(str_replace('-', ' ', $role->name)) }}
                                </strong>
                                <small class="user-meta-id font-monospace">
                                    slug: {{ $role->name }}
                                </small>
                            </td>
                            <td class="text-secondary cell-desc">
                                {{ $role->description ?: 'No description provided.' }}
                            </td>
                            <td>
                                <span class="d-inline-flex align-items-center gap-2 fw-semibold text-secondary">
                                    <i class="bi bi-people"></i> {{ $role->users_count }} members
                                </span>
                            </td>
                            <td>
                                @if ($role->name === 'administrator')
                                    <span class="role-badge role-badge-admin">
                                        <i class="bi bi-star-fill me-1"></i> Full Access (All Abilities)
                                    </span>
                                @elseif($role->permissions->count() > 0)
                                    <span class="role-badge role-badge-admin">
                                        {{ $role->permissions->count() }} permissions granted
                                    </span>
                                @else
                                    <span class="text-muted fs-7">No admin permissions</span>
                                @endif
                            </td>
                            <td>
                                @if (in_array($role->name, ['administrator', 'client'], true))
                                    <span class="badge-tag-system">
                                        System
                                    </span>
                                @else
                                    <span class="badge-tag-custom">
                                        Custom
                                    </span>
                                @endif
                            </td>
                            <td class="text-end-align nowrap-cell">
                                <div class="table-actions">
                                    <a href="{{ route('admin.roles.edit', $role) }}" class="btn-action btn-action-edit"
                                        title="Edit Permissions">
                                        <i class="bi bi-pencil-square"></i>
                                        <span>Edit Permissions</span>
                                    </a>

                                    @if (!in_array($role->name, ['administrator', 'client'], true) && $role->users_count === 0)
                                        <form action="{{ route('admin.roles.destroy', $role) }}" method="POST"
                                            class="d-inline"
                                            onsubmit="return confirm('Are you sure you want to delete role {{ $role->name }}?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-action btn-action-delete btn-action-icon"
                                                title="Delete Role">
                                                <i class="bi bi-trash3"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                No roles defined.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
