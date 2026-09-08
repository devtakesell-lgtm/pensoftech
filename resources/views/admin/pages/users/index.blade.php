@extends('admin.layouts.admin-master')

@section('title', 'Users Management')

@section('content')
<div class="heading">
    <div>
        <small>AGENCY ADMIN</small>
        <h1>Team & Users Management</h1>
        <p>Manage all staff accounts, client accounts, and their assigned roles.</p>
    </div>
    <div>
        @can('create-users')
            <a href="{{ route('admin.users.create') }}" class="btn primary" style="text-decoration: none;">
                ＋ Add New User
            </a>
        @endcan
    </div>
</div>

{{-- Flash Alerts --}}
@if(session('success'))
    <div style="background: rgba(16, 185, 129, 0.12); border: 1px solid #10b981; color: #065f46; padding: 14px 18px; border-radius: 8px; margin-bottom: 20px; font-weight: 500;">
        ✓ {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div style="background: rgba(239, 68, 68, 0.12); border: 1px solid #ef4444; color: #991b1b; padding: 14px 18px; border-radius: 8px; margin-bottom: 20px; font-weight: 500;">
        ⚠ {{ session('error') }}
    </div>
@endif

{{-- Team Users Table --}}
<div class="card list-card">
    <div class="toolbar">
        <form method="GET" action="{{ route('admin.users') }}" class="filters" style="display: flex; gap: 12px; align-items: center; flex-wrap: wrap;">
            <input type="text" name="search" value="{{ $currentSearch ?? '' }}" placeholder="Search by name, email, or phone..." style="min-width: 250px;">
            <select name="role" onchange="this.form.submit()">
                <option value="">All Roles</option>
                @foreach($roles ?? [] as $role)
                    <option value="{{ $role->name }}" {{ ($currentRole ?? '') === $role->name ? 'selected' : '' }}>
                        {{ ucwords(str_replace('-', ' ', $role->name)) }}
                    </option>
                @endforeach
            </select>
            <select name="status" onchange="this.form.submit()">
                <option value="">All Status</option>
                <option value="active" {{ ($currentStatus ?? '') === 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ ($currentStatus ?? '') === 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
            <button type="submit" class="btn light" style="padding: 8px 14px; font-size: 13px;">Filter</button>
            @if(!empty($currentSearch) || !empty($currentRole) || !empty($currentStatus))
                <a href="{{ route('admin.users') }}" class="btn light" style="text-decoration: none; padding: 8px 14px; font-size: 13px; color: #ef4444;">
                    Reset
                </a>
            @endif
        </form>

        <a href="{{ route('admin.roles.index') }}" class="btn light" style="text-decoration: none; font-size: 13px;">
            🛡️ Manage Roles &rarr;
        </a>
    </div>

    <div class="tablewrap">
        <table>
            <thead>
                <tr>
                    <th>USER</th>
                    <th>EMAIL & CONTACT</th>
                    <th>ASSIGNED ROLE</th>
                    <th>ACCOUNT STATUS</th>
                    <th>JOINED</th>
                    <th style="text-align: right;">ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users ?? [] as $user)
                    <tr>
                        <td>
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <div style="width: 38px; height: 38px; border-radius: 50%; background: linear-gradient(135deg, #6d4aff, #8b6fff); color: #fff; display: grid; place-items: center; font-weight: 700; font-size: 13px; flex-shrink: 0;">
                                    {{ strtoupper(substr($user->name, 0, 2)) }}
                                </div>
                                <div>
                                    <strong style="display: block; color: #101426;">
                                        {{ $user->name }}
                                        @if(auth()->id() === $user->id)
                                            <small style="color: #6d4aff; font-weight: 600; font-size: 11px;">(You)</small>
                                        @endif
                                    </strong>
                                    <small style="color: #737c91; font-size: 12px;">ID: #{{ $user->id }}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div style="color: #1e293b; font-weight: 500;">{{ $user->email }}</div>
                            <small style="color: #737c91;">{{ $user->phone ?: 'No phone provided' }}</small>
                        </td>
                        <td>
                            @forelse($user->roles as $role)
                                @if($role->name === 'administrator')
                                    <span style="display: inline-block; background: rgba(109, 74, 255, 0.12); color: #6d4aff; padding: 4px 10px; border-radius: 6px; font-weight: 700; font-size: 12px;">
                                        ★ Administrator
                                    </span>
                                @elseif($role->name === 'client')
                                    <span style="display: inline-block; background: rgba(59, 130, 246, 0.12); color: #3b82f6; padding: 4px 10px; border-radius: 6px; font-weight: 600; font-size: 12px;">
                                        Client Account
                                    </span>
                                @else
                                    <span style="display: inline-block; background: #edf0f7; color: #334155; padding: 4px 10px; border-radius: 6px; font-weight: 600; font-size: 12px;">
                                        {{ ucwords(str_replace('-', ' ', $role->name)) }}
                                    </span>
                                @endif
                            @empty
                                <span style="color: #9da5b8; font-size: 12px;">Unassigned</span>
                            @endforelse
                        </td>
                        <td>
                            @if($user->is_active)
                                <span style="display: inline-flex; align-items: center; gap: 5px; background: rgba(16, 185, 129, 0.12); color: #10b981; padding: 4px 10px; border-radius: 12px; font-size: 11px; font-weight: 600;">
                                    <span style="width: 6px; height: 6px; border-radius: 50%; background: #10b981;"></span>
                                    Active
                                </span>
                            @else
                                <span style="display: inline-flex; align-items: center; gap: 5px; background: rgba(239, 68, 68, 0.12); color: #ef4444; padding: 4px 10px; border-radius: 12px; font-size: 11px; font-weight: 600;">
                                    <span style="width: 6px; height: 6px; border-radius: 50%; background: #ef4444;"></span>
                                    Inactive
                                </span>
                            @endif
                        </td>
                        <td style="color: #737c91; font-size: 13px;">
                            {{ $user->created_at ? $user->created_at->format('M d, Y') : '—' }}
                        </td>
                        <td style="text-align: right; white-space: nowrap;">
                            <div style="display: inline-flex; gap: 6px; align-items: center;">
                                @can('edit-users')
                                    <a href="{{ route('admin.users.edit', $user) }}" class="btn light" style="padding: 5px 12px; font-size: 12px; text-decoration: none;" title="Edit user & role">
                                        ✏️ Edit
                                    </a>
                                @endcan

                                @can('delete-users')
                                    @if(auth()->id() !== $user->id)
                                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('Are you sure you want to delete user \'{{ $user->name }}\'?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn light" style="padding: 5px 10px; font-size: 12px; color: #ef4444;" title="Delete User">
                                                🗑️
                                            </button>
                                        </form>
                                    @endif
                                @endcan

                                @cannot('edit-users')
                                    @cannot('delete-users')
                                        <span style="color: #9da5b8; font-size: 12px;">—</span>
                                    @endcannot
                                @endcannot
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align: center; color: #9da5b8; padding: 36px;">
                            No team members found matching criteria.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
