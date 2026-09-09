@extends('admin.layouts.admin-master')

@section('title', 'Permissions Overview')

@section('content')
    <div class="heading">
        <div>
            <small>ACCESS CONTROL</small>
            <h1>System Permissions & Audit</h1>
            <p>Comprehensive audit of all module-level abilities and the roles currently assigned to them.</p>
        </div>
        <div>
            <a href="{{ route('admin.roles.index') }}" class="btn primary">
                <i class="bi bi-shield-lock me-1"></i> Manage Roles <i class="bi bi-arrow-right ms-1"></i>
            </a>
        </div>
    </div>

    {{-- Global Dashboard Access Card --}}
    @if (isset($permissionsByModule['general']))
        <div class="card perm-module-card mb-4">
            <div class="perm-module-header">
                <strong class="perm-module-title text-primary">
                    General Admin Authorization
                </strong>
            </div>
            @foreach ($permissionsByModule['general'] as $perm)
                <div class="perm-audit-row">
                    <div>
                        <strong class="user-meta-name">{{ $perm->name }}</strong>
                        <small class="user-meta-id">{{ $perm->description }}</small>
                    </div>
                    <div class="perm-role-tag-list">
                        @forelse($perm->roles as $role)
                            <span class="role-badge role-badge-admin">
                                {{ ucwords(str_replace('-', ' ', $role->name)) }}
                            </span>
                        @empty
                            <span class="role-badge-unassigned">No roles assigned</span>
                        @endforelse
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    {{-- Module Permissions Cards --}}
    <div class="perm-matrix-grid">
        @foreach ($permissionsByModule as $module => $modulePermissions)
            @if ($module !== 'general')
                <div class="card perm-module-card">
                    <div class="perm-module-header">
                        <strong class="perm-module-title">
                            {{ $module }}
                        </strong>
                        <span class="badge-tag-custom">
                            {{ $modulePermissions->count() }} actions
                        </span>
                    </div>

                    <div>
                        @foreach ($modulePermissions as $perm)
                            <div class="perm-audit-row">
                                <div>
                                    <code class="perm-code-pill">
                                        {{ $perm->name }}
                                    </code>
                                    <small class="user-meta-id mt-1">
                                        {{ $perm->description }}
                                    </small>
                                </div>
                                <div class="perm-role-tag-list">
                                    @forelse($perm->roles as $role)
                                        <span class="badge-tag-custom">
                                            {{ ucwords(str_replace('-', ' ', $role->name)) }}
                                        </span>
                                    @empty
                                        <span class="text-muted fs-7">Admin only</span>
                                    @endforelse
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        @endforeach
    </div>
@endsection
