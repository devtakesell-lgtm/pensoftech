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
                <a href="{{ route('admin.users.create') }}" class="btn primary">
                    <i class="bi bi-plus-lg me-1"></i> Add New User
                </a>
            @endcan
        </div>
    </div>

    {{-- Flash Alerts --}}
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

    {{-- Team Users Table --}}
    <div class="card list-card">
        <div class="toolbar">
            <form method="GET" action="{{ route('admin.users') }}" class="toolbar-filters">
                <input type="text" name="search" value="{{ $currentSearch ?? '' }}"
                    placeholder="Search by name, email, or phone..." class="filter-search-input">
                <select name="role" onchange="this.form.submit()" class="filter-select">
                    <option value="">All Roles</option>
                    @foreach ($roles ?? [] as $role)
                        <option value="{{ $role->name }}" {{ ($currentRole ?? '') === $role->name ? 'selected' : '' }}>
                            {{ ucwords(str_replace('-', ' ', $role->name)) }}
                        </option>
                    @endforeach
                </select>
                <select name="status" onchange="this.form.submit()" class="filter-select">
                    <option value="">All Status</option>
                    <option value="active" {{ ($currentStatus ?? '') === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ ($currentStatus ?? '') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
                <button type="submit" class="btn light">Filter</button>
                @if (!empty($currentSearch) || !empty($currentRole) || !empty($currentStatus))
                    <a href="{{ route('admin.users') }}" class="btn light filter-btn-reset">
                        Reset
                    </a>
                @endif
            </form>

            <a href="{{ route('admin.roles.index') }}" class="btn light">
                Manage Roles <i class="bi bi-arrow-right ms-1"></i>
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
                        <th class="text-end-align">ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users ?? [] as $user)
                        <tr>
                            <td>
                                <div class="user-cell">
                                    <div class="user-avatar-circle">
                                        {{ strtoupper(substr($user->name, 0, 2)) }}
                                    </div>
                                    <div>
                                        <strong class="user-meta-name">
                                            {{ $user->name }}
                                            @if (auth()->id() === $user->id)
                                                <small class="badge-you">(You)</small>
                                            @endif
                                        </strong>
                                        <small class="user-meta-id">ID: #{{ $user->id }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="user-contact-email">{{ $user->email }}</div>
                                <small class="user-contact-phone">{{ $user->phone ?: 'No phone provided' }}</small>
                            </td>
                            <td>
                                @forelse($user->roles as $role)
                                    @if ($role->name === 'administrator')
                                        <span class="role-badge role-badge-admin">
                                            <i class="bi bi-star-fill me-1"></i> Administrator
                                        </span>
                                    @elseif($role->name === 'client')
                                        <span class="role-badge role-badge-client">
                                            Client Account
                                        </span>
                                    @else
                                        <span class="role-badge role-badge-staff">
                                            {{ ucwords(str_replace('-', ' ', $role->name)) }}
                                        </span>
                                    @endif
                                @empty
                                    <span class="role-badge-unassigned">Unassigned</span>
                                @endforelse
                            </td>
                            <td>
                                @if ($user->is_active)
                                    <span class="status-badge status-badge-active">
                                        <span class="status-dot status-dot-active"></span>
                                        Active
                                    </span>
                                @else
                                    <span class="status-badge status-badge-inactive">
                                        <span class="status-dot status-dot-inactive"></span>
                                        Inactive
                                    </span>
                                @endif
                            </td>
                            <td>
                                {{ $user->created_at ? $user->created_at->format('M d, Y') : '—' }}
                            </td>
                            <td class="text-end-align nowrap-cell">
                                <div class="table-actions">
                                    @can('edit-users')
                                        <a href="{{ route('admin.users.edit', $user) }}" class="btn-action btn-action-edit"
                                            title="Edit user & role">
                                            <i class="bi bi-pencil-square"></i>
                                            <span>Edit</span>
                                        </a>
                                    @endcan

                                    @can('delete-users')
                                        @if (auth()->id() !== $user->id)
                                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                                                class="d-inline"
                                                onsubmit="return confirm('Are you sure you want to delete user \'{{ $user->name }}\'?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-action btn-action-delete btn-action-icon"
                                                    title="Delete User">
                                                    <i class="bi bi-trash3"></i>
                                                </button>
                                            </form>
                                        @endif
                                    @endcan

                                    @cannot('edit-users')
                                        @cannot('delete-users')
                                            <span class="text-muted">—</span>
                                        @endcannot
                                    @endcannot
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                No team members found matching criteria.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($users->hasPages())
            <div class="p-3 border-top d-flex justify-content-end">
                {{ $users->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>
@endsection
