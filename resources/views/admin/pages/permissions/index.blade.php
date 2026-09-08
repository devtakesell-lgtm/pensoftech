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
        <a href="{{ route('admin.roles.index') }}" class="btn primary" style="text-decoration: none;">
            🛡️ Manage Roles &rarr;
        </a>
    </div>
</div>

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(360px, 1fr)); gap: 20px;">
    {{-- Global Dashboard Access Card --}}
    @if(isset($permissionsByModule['general']))
        <div class="card" style="grid-column: 1 / -1; padding: 20px; background: #fff; border-radius: 12px; border: 1px solid #edf0f7;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px; padding-bottom: 8px; border-bottom: 1px solid #f1f5f9;">
                <strong style="text-transform: uppercase; font-size: 13px; color: #6d4aff; letter-spacing: 0.5px;">
                    🔑 General Admin Authorization
                </strong>
            </div>
            @foreach($permissionsByModule['general'] as $perm)
                <div style="display: flex; justify-content: space-between; align-items: center; padding: 10px 0;">
                    <div>
                        <strong style="font-size: 14px; color: #101426;">{{ $perm->name }}</strong>
                        <small style="display: block; color: #64748b; font-size: 12px;">{{ $perm->description }}</small>
                    </div>
                    <div style="display: flex; gap: 6px; flex-wrap: wrap; justify-content: flex-end;">
                        @forelse($perm->roles as $role)
                            <span style="background: rgba(109, 74, 255, 0.1); color: #6d4aff; padding: 3px 8px; border-radius: 6px; font-size: 11px; font-weight: 600;">
                                {{ ucwords(str_replace('-', ' ', $role->name)) }}
                            </span>
                        @empty
                            <span style="color: #9da5b8; font-size: 12px;">No roles assigned</span>
                        @endforelse
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    {{-- Module Permissions Cards --}}
    @foreach($permissionsByModule as $module => $modulePermissions)
        @if($module !== 'general')
            <div class="card" style="padding: 20px; background: #fff; border-radius: 12px; border: 1px solid #edf0f7;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px; padding-bottom: 8px; border-bottom: 1px solid #f1f5f9;">
                    <strong style="text-transform: uppercase; font-size: 13px; color: #334155; letter-spacing: 0.5px;">
                        {{ $module }}
                    </strong>
                    <span style="font-size: 11px; color: #64748b; background: #f1f5f9; padding: 2px 7px; border-radius: 4px; font-weight: 600;">
                        {{ $modulePermissions->count() }} actions
                    </span>
                </div>

                <div style="display: flex; flex-direction: column; gap: 12px;">
                    @foreach($modulePermissions as $perm)
                        <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 12px; padding-bottom: 8px; border-bottom: 1px dashed #f1f5f9;">
                            <div>
                                <code style="font-size: 12px; background: #f8fafc; color: #0f172a; padding: 2px 6px; border-radius: 4px; font-weight: 600;">
                                    {{ $perm->name }}
                                </code>
                                <small style="display: block; color: #64748b; font-size: 11px; margin-top: 2px;">
                                    {{ $perm->description }}
                                </small>
                            </div>
                            <div style="display: flex; gap: 4px; flex-wrap: wrap; justify-content: flex-end; max-width: 160px;">
                                @forelse($perm->roles as $role)
                                    <span style="background: #f1f5f9; color: #475569; padding: 2px 6px; border-radius: 4px; font-size: 10px; font-weight: 600;">
                                        {{ ucwords(str_replace('-', ' ', $role->name)) }}
                                    </span>
                                @empty
                                    <span style="color: #cbd5e1; font-size: 11px;">Admin only</span>
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
