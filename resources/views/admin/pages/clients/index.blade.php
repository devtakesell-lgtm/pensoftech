@extends('admin.layouts.admin-master')

@section('title', 'Clients Management')

@section('content')
    {{-- Page Header --}}
    <div class="heading">
        <div>
            <small>AGENCY ADMIN</small>
            <h1>Client Management</h1>
            <p>Manage your PenSoftTech agency clients, their accounts, and associated operations.</p>
        </div>
        <div>
            @can('create-clients')
                <button type="button" class="btn primary" data-bs-toggle="modal" data-bs-target="#clientCreateModal">
                    <i class="bi bi-plus-lg me-1"></i> Add Client
                </button>
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

    {{-- KPI Cards --}}
    <div class="lead-stats-grid">
        <div class="lead-stat-card">
            <div class="lead-stat-icon icon-primary">
                <i class="bi bi-people-fill"></i>
            </div>
            <div class="lead-stat-content">
                <h4>{{ number_format($totalCount) }}</h4>
                <span>Total Clients</span>
            </div>
        </div>

        <div class="lead-stat-card">
            <div class="lead-stat-icon icon-success">
                <i class="bi bi-check-circle-fill"></i>
            </div>
            <div class="lead-stat-content">
                <h4>{{ number_format($activeCount) }}</h4>
                <span>Active Clients</span>
            </div>
        </div>
    </div>

    {{-- Clients Table Card --}}
    <div class="card list-card">
        {{-- Search & Filters --}}
        <div class="toolbar">
            <form method="GET" action="{{ route('admin.clients') }}" class="toolbar-filters flex-wrap">
                <input type="text" name="search" value="{{ $currentSearch ?? '' }}"
                    placeholder="Search company, name, email..." class="filter-search-input">

                <select name="status" onchange="this.form.submit()" class="filter-select">
                    <option value="">All Statuses</option>
                    <option value="active" {{ ($currentStatus ?? '') === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ ($currentStatus ?? '') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>

                <button type="submit" class="btn light">Filter</button>

                @if (!empty($currentSearch) || !empty($currentStatus))
                    <a href="{{ route('admin.clients') }}" class="btn light filter-btn-reset">
                        Reset
                    </a>
                @endif
            </form>
        </div>

        <div class="tablewrap">
            <table>
                <thead>
                    <tr>
                        <th>CLIENT / COMPANY</th>
                        <th>PRIMARY CONTACT</th>
                        <th>EMAIL</th>
                        <th>PROJECTS</th>
                        <th>STATUS</th>
                        <th>DATE ADDED</th>
                        <th class="text-end-align">ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($clients as $client)
                        @php
                            $initials = collect(explode(' ', $client->company_name ?? $client->contact_person))
                                ->map(fn($w) => mb_substr($w, 0, 1))
                                ->take(2)
                                ->join('');
                        @endphp
                        <tr>
                            <td>
                                <div class="lead-cell-contact">
                                    <div class="lead-avatar-circle">
                                        {{ strtoupper($initials ?: 'C') }}
                                    </div>
                                    <div class="lead-name-box">
                                        <div class="d-inline-flex align-items-center gap-1">
                                            <a href="{{ route('admin.clients.show', $client) }}" class="text-decoration-none">
                                                <strong>{{ $client->company_name }}</strong>
                                            </a>
                                        </div>
                                        @if ($client->website)
                                            <a href="{{ str_starts_with($client->website, 'http') ? $client->website : 'https://' . $client->website }}" target="_blank" class="lead-company text-decoration-none">
                                                <i class="bi bi-globe me-1"></i>{{ $client->website }}
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="d-block fw-semibold text-dark">{{ $client->contact_person }}</span>
                                @if ($client->phone)
                                    <small class="text-muted"><i class="bi bi-telephone me-1"></i>{{ $client->phone }}</small>
                                @endif
                            </td>
                            <td>
                                @if ($client->user?->email)
                                    <a href="mailto:{{ $client->user->email }}" class="text-decoration-none text-secondary">
                                        <i class="bi bi-envelope me-1"></i>{{ $client->user->email }}
                                    </a>
                                @else
                                    <span class="text-muted small">—</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-secondary rounded-pill px-2 py-1">{{ $client->projects_count ?? 0 }}</span>
                            </td>
                            <td>
                                @if($client->is_active)
                                    <span class="status-badge status-won">
                                        <i class="bi bi-check-circle-fill me-1"></i> Active
                                    </span>
                                @else
                                    <span class="status-badge status-lost">
                                        <i class="bi bi-x-circle-fill me-1"></i> Inactive
                                    </span>
                                @endif
                            </td>
                            <td>
                                <span class="fw-semibold text-dark small d-block">
                                    {{ $client->created_at->format('M d, Y') }}
                                </span>
                            </td>
                            <td class="text-end-align nowrap-cell">
                                <div class="table-actions">
                                    @can('view-clients')
                                        <a href="{{ route('admin.clients.show', $client) }}"
                                            class="btn-action btn-action-view btn-action-icon" title="View Client">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                    @endcan

                                    @can('edit-clients')
                                        <a href="{{ route('admin.clients.edit', $client) }}"
                                            class="btn-action btn-action-edit btn-action-icon" title="Edit Client">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                    @endcan

                                    @can('delete-clients')
                                        <form action="{{ route('admin.clients.destroy', $client) }}" method="POST"
                                            class="d-inline"
                                            onsubmit="return confirm('Are you sure you want to delete client \'{{ $client->company_name }}\'?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-action btn-action-delete btn-action-icon"
                                                title="Delete Client">
                                                <i class="bi bi-trash3"></i>
                                            </button>
                                        </form>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-5">
                                <div class="py-3">
                                    <i class="bi bi-buildings text-secondary" style="font-size: 2.5rem;"></i>
                                    <h5 class="mt-2 text-dark">No Clients Found</h5>
                                    <p class="text-muted small">No clients match your search criteria.</p>
                                    @can('create-clients')
                                        <button type="button" class="btn primary btn-sm mt-2" data-bs-toggle="modal" data-bs-target="#clientCreateModal">
                                            <i class="bi bi-plus-lg me-1"></i> Add New Client
                                        </button>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($clients->hasPages())
            <div class="p-3 border-top d-flex justify-content-end">
                {{ $clients->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>

    {{-- Create Client Modal --}}
    @can('create-clients')
        <x-admin.components.modals.client-create-modal 
            formAction="{{ route('admin.clients.store') }}" 
            modalId="clientCreateModal"
        />
    @endcan

@endsection
