@extends('admin.layouts.admin-master')

@section('title', 'Client Details - ' . $client->company_name)

@section('content')
    <div class="heading d-flex justify-content-between align-items-center">
        <div>
            <a href="{{ route('admin.clients') }}" class="text-decoration-none text-muted mb-2 d-inline-block">
                <i class="bi bi-arrow-left me-1"></i> Back to Clients
            </a>
            <h1>{{ $client->company_name }}</h1>
            <p>Client Profile & Statistics</p>
        </div>
        <div>
            @can('edit-clients')
                <a href="{{ route('admin.clients.edit', $client) }}" class="btn primary">
                    <i class="bi bi-pencil-square me-1"></i> Edit Client
                </a>
            @endcan
        </div>
    </div>

    @if (session('success'))
        <div class="alert-custom alert-custom-success">
            <i class="bi bi-check-circle-fill"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <div class="row">
        <!-- Client Details Sidebar -->
        <div class="col-md-4 mb-4">
            <div class="card p-4">
                <h5 class="fw-bold mb-4">Contact Information</h5>
                
                <div class="mb-3">
                    <span class="d-block text-muted small fw-semibold text-uppercase">Primary Contact</span>
                    <span class="fs-6">{{ $client->contact_person }}</span>
                </div>

                <div class="mb-3">
                    <span class="d-block text-muted small fw-semibold text-uppercase">Email Address</span>
                    @if ($client->user?->email)
                        <a href="mailto:{{ $client->user->email }}" class="text-decoration-none">
                            {{ $client->user->email }}
                        </a>
                    @else
                        <span class="text-muted italic">—</span>
                    @endif
                </div>

                <div class="mb-3">
                    <span class="d-block text-muted small fw-semibold text-uppercase">Phone Number</span>
                    @if ($client->phone)
                        <a href="tel:{{ $client->phone }}" class="text-decoration-none text-dark">
                            {{ $client->phone }}
                        </a>
                    @else
                        <span class="text-muted italic">—</span>
                    @endif
                </div>

                <div class="mb-3">
                    <span class="d-block text-muted small fw-semibold text-uppercase">Website</span>
                    @if ($client->website)
                        <a href="{{ str_starts_with($client->website, 'http') ? $client->website : 'https://' . $client->website }}" target="_blank" class="text-decoration-none">
                            {{ $client->website }} <i class="bi bi-box-arrow-up-right ms-1"></i>
                        </a>
                    @else
                        <span class="text-muted italic">—</span>
                    @endif
                </div>

                <div class="mb-3">
                    <span class="d-block text-muted small fw-semibold text-uppercase">Location</span>
                    @if ($client->address || $client->city || $client->country)
                        <span>
                            {{ $client->address }}<br>
                            {{ $client->city }}{{ $client->city && $client->country ? ',' : '' }} {{ $client->country }}
                        </span>
                    @else
                        <span class="text-muted italic">—</span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Client Statistics & Data -->
        <div class="col-md-8">
            <div class="lead-stats-grid mb-4">
                <div class="lead-stat-card">
                    <div class="lead-stat-icon icon-primary">
                        <i class="bi bi-briefcase-fill"></i>
                    </div>
                    <div class="lead-stat-content">
                        <h4>{{ $client->projects()->count() }}</h4>
                        <span>Total Projects</span>
                    </div>
                </div>

                <div class="lead-stat-card">
                    <div class="lead-stat-icon icon-info">
                        <i class="bi bi-funnel-fill"></i>
                    </div>
                    <div class="lead-stat-content">
                        <h4>{{ $client->leads()->count() }}</h4>
                        <span>Converted Leads</span>
                    </div>
                </div>
                
                <div class="lead-stat-card">
                    <div class="lead-stat-icon icon-success">
                        <i class="bi bi-check-circle-fill"></i>
                    </div>
                    <div class="lead-stat-content">
                        <h4>{{ $client->is_active ? 'Active' : 'Inactive' }}</h4>
                        <span>Account Status</span>
                    </div>
                </div>
            </div>

            <div class="card list-card">
                <div class="card-header bg-white border-bottom py-3">
                    <h5 class="fw-bold mb-0">Recent Projects</h5>
                </div>
                <div class="tablewrap">
                    <table>
                        <thead>
                            <tr>
                                <th>PROJECT NAME</th>
                                <th>STATUS</th>
                                <th>CREATED</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($client->projects as $project)
                                <tr>
                                    <td><strong>{{ $project->name }}</strong></td>
                                    <td>{{ $project->status }}</td>
                                    <td>{{ $project->created_at->format('M d, Y') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted py-4">
                                        No projects associated with this client yet.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
