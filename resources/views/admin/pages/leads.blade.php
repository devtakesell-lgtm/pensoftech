@extends('admin.layouts.admin-master')

@section('title', 'Leads')

@section('content')
    <div class="heading">
        <div><small>AGENCY ADMIN</small>
            <h1>Lead Management</h1>
            <p>Manage your PenSoftTech agency operations from one place.</p>
        </div>
        <div><button class="btn light">⇩ Export</button><button class="btn primary">＋ Create New</button></div>
    </div>
    <div class="card list-card">
        <div class="toolbar">
            <div class="filters"><input placeholder="Search leads..."><select>
                    <option>All Status</option>
                </select></div><button class="btn primary">＋ Add Lead</button>
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
                        <th>ACTION</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Sarah Rahman</td>
                        <td>sarah@techwave.com</td>
                        <td>Web Development</td>
                        <td>Meta Ads</td>
                        <td>New</td>
                        <td><button class="rowbtn">•••</button></td>
                    </tr>
                    <tr>
                        <td>Mark Khan</td>
                        <td>mark@novalabs.io</td>
                        <td>SEO & Marketing</td>
                        <td>Google Ads</td>
                        <td>Qualified</td>
                        <td><button class="rowbtn">•••</button></td>
                    </tr>
                    <tr>
                        <td>James Ahmed</td>
                        <td>james@brightco.co</td>
                        <td>Mobile App</td>
                        <td>Organic</td>
                        <td>Proposal</td>
                        <td><button class="rowbtn">•••</button></td>
                    </tr>
                    <tr>
                        <td>Nadia Malik</td>
                        <td>nadia@finserve.com</td>
                        <td>Digital Marketing</td>
                        <td>Referral</td>
                        <td>Won</td>
                        <td><button class="rowbtn">•••</button></td>
                    </tr>
                    <tr>
                        <td>David Chen</td>
                        <td>david@cloudcore.io</td>
                        <td>E-commerce</td>
                        <td>Meta Ads</td>
                        <td>Contacted</td>
                        <td><button class="rowbtn">•••</button></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
