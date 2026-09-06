@extends('admin.layouts.admin-master')

@section('title', 'Careers')

@section('content')
<div class="heading"><div><small>AGENCY ADMIN</small><h1>Jobs & Applications</h1><p>Manage your PenSoftTech agency operations from one place.</p></div><div><button class="btn light">⇩ Export</button><button class="btn primary">＋ Create New</button></div></div><div class="card list-card"><div class="toolbar"><div class="filters"><input placeholder="Search careers..."><select><option>All Status</option></select></div><button class="btn primary">＋ Add Career</button></div><div class="tablewrap"><table><thead><tr><th>JOB TITLE</th><th>DEPARTMENT</th><th>LOCATION</th><th>VACANCY</th><th>STATUS</th><th>ACTION</th></tr></thead><tbody><tr><td>Senior Laravel Developer</td><td>Engineering</td><td>Dhaka</td><td>3</td><td>Published</td><td><button class="rowbtn">•••</button></td></tr><tr><td>Performance Marketing Manager</td><td>Marketing</td><td>Dhaka</td><td>2</td><td>Published</td><td><button class="rowbtn">•••</button></td></tr><tr><td>UI/UX Designer</td><td>Design</td><td>Remote</td><td>1</td><td>Published</td><td><button class="rowbtn">•••</button></td></tr><tr><td>Sales Executive</td><td>Sales</td><td>Dhaka</td><td>5</td><td>Draft</td><td><button class="rowbtn">•••</button></td></tr></tbody></table></div></div>
@endsection
