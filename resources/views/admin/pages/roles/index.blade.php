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
        <a href="{{ route('admin.permissions.index') }}" class="btn light" style="text-decoration: none; margin-right: 8px;">
            🔑 View Permissions Audit
        </a>
        <a href="{{ route('admin.roles.create') }}" class="btn primary" style="text-decoration: none;">
            ＋ Create New Role
        </a>
    </div>
</div>

@if(session('success'))
    <div style="background: rgba(16, 185, 129, 0.12); border: 1px solid #10b981; color: #065f46; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; font-weight: 500;">
        ✓ {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div style="background: rgba(239, 68, 68, 0.12); border: 1px solid #ef4444; color: #991b1b; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; font-weight: 500;">
        ⚠️ {{ session('error') }}
    </div>
@endif

<div class="card list-card">
    <div class="tablewrap">
        <table>
            <thead>
                <tr>
                    <th style="min-width: 180px;">ROLE NAME</th>
                    <th>DESCRIPTION</th>
                    <th>ASSIGNED USERS</th>
                    <th>PERMISSIONS</th>
                    <th>TYPE</th>
                    <th style="text-align: right;">ACTION</th>
                </tr>
            </thead>
            <tbody>
                @forelse($roles as $role)
                    <tr>
                        <td>
                            <strong style="font-size: 15px; color: #101426;">
                                {{ ucwords(str_replace('-', ' ', $role->name)) }}
                            </strong>
                            <small style="display: block; color: #9da5b8; font-size: 12px; font-family: monospace;">
                                slug: {{ $role->name }}
                            </small>
                        </td>
                        <td style="color: #475569; max-width: 280px;">
                            {{ $role->description ?: 'No description provided.' }}
                        </td>
                        <td>
                            <span style="display: inline-flex; align-items: center; gap: 6px; font-weight: 600; color: #334155;">
                                <i class="bi bi-people"></i> {{ $role->users_count }} members
                            </span>
                        </td>
                        <td>
                            @if($role->name === 'administrator')
                                <span style="display: inline-block; background: rgba(16, 185, 129, 0.12); color: #10b981; padding: 3px 8px; border-radius: 6px; font-size: 12px; font-weight: 700;">
                                    ★ Full Access (All Abilities)
                                </span>
                            @elseif($role->permissions->count() > 0)
                                <span style="display: inline-block; background: rgba(109, 74, 255, 0.1); color: #6d4aff; padding: 3px 8px; border-radius: 6px; font-size: 12px; font-weight: 600;">
                                    {{ $role->permissions->count() }} permissions granted
                                </span>
                            @else
                                <span style="color: #9da5b8; font-size: 12px;">No admin permissions</span>
                            @endif
                        </td>
                        <td>
                            @if(in_array($role->name, ['administrator', 'client'], true))
                                <span style="display: inline-block; background: #e2e8f0; color: #475569; padding: 2px 7px; border-radius: 4px; font-size: 11px; font-weight: 700; text-transform: uppercase;">
                                    System
                                </span>
                            @else
                                <span style="display: inline-block; background: #f1f5f9; color: #64748b; padding: 2px 7px; border-radius: 4px; font-size: 11px; font-weight: 600; text-transform: uppercase;">
                                    Custom
                                </span>
                            @endif
                        </td>
                        <td style="text-align: right;">
                            <div style="display: inline-flex; gap: 6px; align-items: center;">
                                <a href="{{ route('admin.roles.edit', $role) }}" class="btn light" style="padding: 6px 12px; font-size: 12px; text-decoration: none;">
                                    Edit Permissions
                                </a>

                                @if(!in_array($role->name, ['administrator', 'client'], true) && $role->users_count === 0)
                                    <form action="{{ route('admin.roles.destroy', $role) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete role {{ $role->name }}?');" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn light" style="padding: 6px 10px; font-size: 12px; color: #ef4444;" title="Delete Role">
                                            Delete
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align: center; color: #9da5b8; padding: 32px;">
                            No roles defined.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
