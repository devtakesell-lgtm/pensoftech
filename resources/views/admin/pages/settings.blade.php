@extends('admin.layouts.admin-master')

@section('title', 'Settings')

@section('content')
    <div class="heading">
        <div><small>AGENCY ADMIN</small>
            <h1>Website Settings</h1>
            <p>Manage your PenSoftTech agency operations from one place.</p>
        </div>
        <div><button class="btn light">⇩ Export</button></div>
    </div>
    <div class="card settings-card">
        <div class="settings-nav"><a class="selected">General</a><a>SEO</a><a>Tracking</a><a>Social
                Links</a><a>Notifications</a></div>
        <div class="form-area">
            <h3>Website Settings</h3>
            <p>Manage your agency website configuration.</p><label>Company Name<input
                    value="PenSoftTech"></label><label>Website Email<input value="hello@pensofttech.com"></label><label>Phone
                Number<input value="+880 1XXX-XXXXXX"></label><label>Meta Pixel ID<input
                    placeholder="Enter Meta Pixel ID"></label><label>Google Analytics ID<input
                    placeholder="G-XXXXXXXXXX"></label><button class="btn primary">Save Changes</button>
        </div>
    </div>
@endsection
