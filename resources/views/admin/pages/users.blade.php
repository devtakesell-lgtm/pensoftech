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
        <button class="btn light">⇩ Export</button>
        <button class="btn primary">＋ Add New User</button>
    </div>
</div>

{{-- Team Users Table --}}
<div class="card list-card">
    <div class="toolbar">
        <div class="filters">
            <input type="text" placeholder="Search team members by name or email...">
            <select>
                <option value="">All Roles</option>
                @foreach($roles ?? [] as $role)
                    <option value="{{ $role->name }}">{{ ucwords(str_replace('-', ' ', $role->name)) }}</option>
                @endforeach
            </select>
            <select>
                <option value="">All Status</option>
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
            </select>
        </div>
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
                    <th style="text-align: right;">ACTION</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users ?? [] as $user)
                    <tr>
                        <td>
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <div style="width: 36px; height: 36px; border-radius: 50%; background: linear-gradient(135deg, #6d4aff, #8b6fff); color: #fff; display: grid; place-items: center; font-weight: 700; font-size: 13px;">
                                    {{ strtoupper(substr($user->name, 0, 2)) }}
                                </div>
                                <div>
                                    <strong style="display: block; color: #101426;">{{ $user->name }}</strong>
                                    <small style="color: #737c91; font-size: 12px;">ID: #{{ $user->id }}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div>{{ $user->email }}</div>
                            <small style="color: #737c91;">{{ $user->phone ?: 'No phone provided' }}</small>
                        </td>
                        <td>
                            @forelse($user->roles as $role)
                                @if($role->name === 'administrator')
                                    <span style="display: inline-block; background: rgba(109, 74, 255, 0.12); color: #6d4aff; padding: 3px 10px; border-radius: 6px; font-weight: 700; font-size: 12px;">
                                        ★ Administrator
                                    </span>
                                @elseif($role->name === 'client')
                                    <span style="display: inline-block; background: rgba(59, 130, 246, 0.12); color: #3b82f6; padding: 3px 10px; border-radius: 6px; font-weight: 600; font-size: 12px;">
                                        Client Account
                                    </span>
                                @else
                                    <span style="display: inline-block; background: #edf0f7; color: #334155; padding: 3px 10px; border-radius: 6px; font-weight: 600; font-size: 12px;">
                                        {{ ucwords(str_replace('-', ' ', $role->name)) }}
                                    </span>
                                @endif
                            @empty
                                <span style="color: #9da5b8; font-size: 12px;">Unassigned</span>
                            @endforelse
                        </td>
                        <td>
                            @if($user->is_active)
                                <span style="display: inline-flex; align-items: center; gap: 5px; background: rgba(16, 185, 129, 0.12); color: #10b981; padding: 3px 9px; border-radius: 12px; font-size: 11px; font-weight: 600;">
                                    <span style="width: 6px; height: 6px; border-radius: 50%; background: #10b981;"></span>
                                    Active
                                </span>
                            @else
                                <span style="display: inline-flex; align-items: center; gap: 5px; background: rgba(239, 68, 68, 0.12); color: #ef4444; padding: 3px 9px; border-radius: 12px; font-size: 11px; font-weight: 600;">
                                    <span style="width: 6px; height: 6px; border-radius: 50%; background: #ef4444;"></span>
                                    Inactive
                                </span>
                            @endif
                        </td>
                        <td style="color: #737c91; font-size: 13px;">
                            {{ $user->created_at ? $user->created_at->format('M d, Y') : '—' }}
                        </td>
                        <td style="text-align: right;">
                            <button class="rowbtn" title="Actions">•••</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align: center; color: #9da5b8; padding: 32px;">
                            No users registered yet.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
