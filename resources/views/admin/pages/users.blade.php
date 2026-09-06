@extends('admin.layouts.admin-master')

@section('title', 'Users & Roles')

@section('content')
<div class="heading"><div><small>AGENCY ADMIN</small><h1>Team Access Management</h1><p>Manage your PenSoftTech agency operations from one place.</p></div><div><button class="btn light">⇩ Export</button><button class="btn primary">＋ Create New</button></div></div><div class="card list-card"><div class="toolbar"><div class="filters"><input placeholder="Search users & roles..."><select><option>All Status</option></select></div><button class="btn primary">＋ Add Users & Role</button></div><div class="tablewrap"><table><thead><tr><th>USER</th><th>EMAIL</th><th>ROLE</th><th>PERMISSIONS</th><th>STATUS</th><th>ACTION</th></tr></thead><tbody><tr><td>Admin</td><td>admin@pensofttech.com</td><td>Super Admin</td><td>All Access</td><td>Active</td><td><button class="rowbtn">•••</button></td></tr><tr><td>Ayesha Rahman</td><td>ayesha@pensofttech.com</td><td>Sales</td><td>Leads, Quotes</td><td>Active</td><td><button class="rowbtn">•••</button></td></tr><tr><td>Rakib Hasan</td><td>rakib@pensofttech.com</td><td>Content Manager</td><td>Blog, Pages</td><td>Active</td><td><button class="rowbtn">•••</button></td></tr><tr><td>Nabil Ahmed</td><td>nabil@pensofttech.com</td><td>Developer</td><td>Projects</td><td>Active</td><td><button class="rowbtn">•••</button></td></tr></tbody></table></div></div>
@endsection
