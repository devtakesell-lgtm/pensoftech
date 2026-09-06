@extends('admin.layouts.admin-master')

@section('title', 'Blog')

@section('content')
<div class="heading"><div><small>AGENCY ADMIN</small><h1>Blog Management</h1><p>Manage your PenSoftTech agency operations from one place.</p></div><div><button class="btn light">⇩ Export</button><button class="btn primary">＋ Create New</button></div></div><div class="card list-card"><div class="toolbar"><div class="filters"><input placeholder="Search blog..."><select><option>All Status</option></select></div><button class="btn primary">＋ Add Blog</button></div><div class="tablewrap"><table><thead><tr><th>TITLE</th><th>CATEGORY</th><th>STATUS</th><th>PUBLISHED</th><th>ACTION</th></tr></thead><tbody><tr><td>How AI is Changing Digital Marketing</td><td>Marketing</td><td>Published</td><td>Sep 03, 2026</td><td><button class="rowbtn">•••</button></td></tr><tr><td>Laravel Performance Optimization Guide</td><td>Development</td><td>Published</td><td>Aug 29, 2026</td><td><button class="rowbtn">•••</button></td></tr><tr><td>SEO Trends for 2027</td><td>SEO</td><td>Draft</td><td>Aug 24, 2026</td><td><button class="rowbtn">•••</button></td></tr><tr><td>Building Scalable SaaS Products</td><td>Development</td><td>Published</td><td>Aug 18, 2026</td><td><button class="rowbtn">•••</button></td></tr></tbody></table></div></div>
@endsection
