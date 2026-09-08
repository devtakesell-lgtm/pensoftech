@extends('admin.layouts.admin-master')

@section('title', 'Analytics')

@section('content')
    <div class="heading">
        <div><small>AGENCY ADMIN</small>
            <h1>Marketing Analytics</h1>
            <p>Manage your PenSoftTech agency operations from one place.</p>
        </div>
        <div><button class="btn light">⇩ Export</button></div>
    </div>
    <div class="stats">
        <div class="card stat">
            <div><span>Visitors</span><strong>38,420</strong><small>↗ 14.2% <i>this month</i></small></div>
        </div>
        <div class="card stat">
            <div><span>Conversion Rate</span><strong>4.82%</strong><small>↗ 0.8% <i>this month</i></small></div>
        </div>
        <div class="card stat">
            <div><span>Ad Spend</span><strong>$12,480</strong><small>↘ 6.4% <i>this month</i></small></div>
        </div>
        <div class="card stat">
            <div><span>ROAS</span><strong>3.92x</strong><small>↗ 11.1% <i>this month</i></small></div>
        </div>
    </div>
    <div class="two">
        <div class="card">
            <div class="panelhead">
                <div>
                    <h3>Traffic & Conversions</h3>
                    <p>Illustrative agency analytics</p>
                </div>
            </div>
            <div class="big-placeholder">Analytics chart area</div>
        </div>
        <div class="card">
            <div class="panelhead">
                <div>
                    <h3>Campaign Performance</h3>
                    <p>Top acquisition channels</p>
                </div>
            </div>
            <div class="metric-list">
                <p><b>Meta Ads</b><span>42%</span></p>
                <p><b>Google Ads</b><span>28%</span></p>
                <p><b>Organic</b><span>18%</span></p>
                <p><b>Referral</b><span>12%</span></p>
            </div>
        </div>
    </div>
@endsection
