@extends('admin.layouts.admin-master')

@section('title', 'Dashboard')

@section('content')
<div class="heading">
    <div>
        <small>AGENCY ADMIN</small>
        <h1>Dashboard Overview</h1>
        <p>Manage your PenSoftTech agency operations from one place.</p>
    </div>
    <div>
        <button class="btn light">⇩ Export</button>
        <button class="btn primary">＋ Create New</button>
    </div>
</div>
<div class="stats">
    <div class="card stat">
        <div>
            <span>Total Leads</span>
            <strong>1,284</strong>
            <small>↗ 12.8% <i>vs last month</i></small>
        </div>
        <b class="ico purple"><i class="bi bi-people"></i></b>
    </div>
    <div class="card stat">
        <div>
            <span>Active Clients</span>
            <strong>86</strong>
            <small>↗ 8.2% <i>vs last month</i></small>
        </div>
        <b class="ico blue"><i class="bi bi-building"></i></b>
    </div>
    <div class="card stat">
        <div>
            <span>Projects</span>
            <strong>42</strong>
            <small>↗ 5.4% <i>vs last month</i></small>
        </div>
        <b class="ico green"><i class="bi bi-kanban"></i></b>
    </div>
    <div class="card stat">
        <div>
            <span>Revenue</span>
            <strong>$48,920</strong>
            <small>↗ 18.6% <i>vs last month</i></small>
        </div>
        <b class="ico orange"><i class="bi bi-currency-dollar"></i></b>
    </div>
</div>
<div class="two">
    <div class="card">
        <div class="panelhead">
            <div>
                <h3>Revenue Overview</h3>
                <p>Monthly revenue performance</p>
            </div>
            <select><option>Last 6 months</option></select>
        </div>
        <div class="chart">
            <div class="y">
                <span>$60k</span><span>$45k</span><span>$30k</span><span>$15k</span><span>$0</span>
            </div>
            <div class="graph">
                <div class="lines"></div>
                <svg viewBox="0 0 700 250" preserveAspectRatio="none">
                    <path class="area" d="M0 190L100 160L200 178L300 110L400 132L500 75L600 98L700 42V250H0Z"/>
                    <polyline points="0,190 100,160 200,178 300,110 400,132 500,75 600,98 700,42"/>
                </svg>
                <div class="months">
                    <span>Apr</span><span>May</span><span>Jun</span><span>Jul</span><span>Aug</span><span>Sep</span><span>Oct</span><span>Nov</span>
                </div>
            </div>
        </div>
    </div>
    <div class="card source">
        <div class="panelhead">
            <div>
                <h3>Lead Sources</h3>
                <p>Where your leads come from</p>
            </div>
            <b>•••</b>
        </div>
        <div class="donut">
            <div>
                <strong>1,284</strong>
                <small>Total</small>
            </div>
        </div>
        <div class="legend">
            <div>● Meta Ads <b>42%</b></div>
            <div>● Google Ads <b>28%</b></div>
            <div>● Organic <b>18%</b></div>
            <div>● Referral <b>12%</b></div>
        </div>
    </div>
</div>
<div class="two lower">
    <div class="card">
        <div class="panelhead">
            <div>
                <h3>Recent Leads</h3>
                <p>Latest inquiries from potential clients</p>
            </div>
            <a href="leads.html">View all →</a>
        </div>
        <div class="tablewrap">
            <table>
                <thead>
                    <tr>
                        <th>LEAD</th>
                        <th>SERVICE</th>
                        <th>SOURCE</th>
                        <th>STATUS</th>
                        <th>DATE</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><b>Sarah Rahman</b><small>sarah@techwave.com</small></td>
                        <td>Web Development</td>
                        <td>Meta Ads</td>
                        <td><mark class="new">New</mark></td>
                        <td>Today</td>
                    </tr>
                    <tr>
                        <td><b>Mark Khan</b><small>mark@novalabs.io</small></td>
                        <td>SEO & Marketing</td>
                        <td>Google</td>
                        <td><mark class="qualified">Qualified</mark></td>
                        <td>Today</td>
                    </tr>
                    <tr>
                        <td><b>James Ahmed</b><small>james@brightco.co</small></td>
                        <td>Mobile App</td>
                        <td>Organic</td>
                        <td><mark class="proposal">Proposal</mark></td>
                        <td>Yesterday</td>
                    </tr>
                    <tr>
                        <td><b>Nadia Malik</b><small>nadia@finserve.com</small></td>
                        <td>Digital Marketing</td>
                        <td>Referral</td>
                        <td><mark class="won">Won</mark></td>
                        <td>Yesterday</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="card">
        <div class="panelhead">
            <div>
                <h3>Recent Activity</h3>
                <p>Latest updates</p>
            </div>
            <b>•••</b>
        </div>
        <div class="activity">
            <div>
                <b>New lead received</b>
                <p>Sarah Rahman submitted a quote request.</p>
                <small>12 minutes ago</small>
            </div>
            <div>
                <b>Project completed</b>
                <p>Nova Labs website marked as completed.</p>
                <small>1 hour ago</small>
            </div>
            <div>
                <b>Quote sent</b>
                <p>Quote #QT-1048 sent to BrightCo.</p>
                <small>3 hours ago</small>
            </div>
            <div>
                <b>New message</b>
                <p>Client replied to project discussion.</p>
                <small>5 hours ago</small>
            </div>
        </div>
    </div>
</div>
@endsection
