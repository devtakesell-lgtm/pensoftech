@extends('admin.layouts.admin-master')

@section('title', 'Industries')

@section('content')
    <div class="heading">
        <div><small>AGENCY ADMIN</small>
            <h1>Industries Management</h1>
            <p>Manage your PenSoftTech agency operations from one place.</p>
        </div>
        <div><button class="btn light">⇩ Export</button><button class="btn primary">＋ Create New</button></div>
    </div>
    <div class="card list-card">
        <div class="toolbar">
            <div class="filters"><input placeholder="Search industries..."><select>
                    <option>All Status</option>
                </select></div><button class="btn primary">＋ Add Industrie</button>
        </div>
        <div class="tablewrap">
            <table>
                <thead>
                    <tr>
                        <th>INDUSTRY</th>
                        <th>DESCRIPTION</th>
                        <th>PROJECTS</th>
                        <th>STATUS</th>
                        <th>ACTION</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Technology</td>
                        <td>SaaS, Software & IT</td>
                        <td>24</td>
                        <td>Active</td>
                        <td><button class="rowbtn">•••</button></td>
                    </tr>
                    <tr>
                        <td>E-commerce</td>
                        <td>Retail & Online Stores</td>
                        <td>18</td>
                        <td>Active</td>
                        <td><button class="rowbtn">•••</button></td>
                    </tr>
                    <tr>
                        <td>Finance</td>
                        <td>Fintech & Financial Services</td>
                        <td>12</td>
                        <td>Active</td>
                        <td><button class="rowbtn">•••</button></td>
                    </tr>
                    <tr>
                        <td>Healthcare</td>
                        <td>Clinics & Health Brands</td>
                        <td>9</td>
                        <td>Active</td>
                        <td><button class="rowbtn">•••</button></td>
                    </tr>
                    <tr>
                        <td>Education</td>
                        <td>EdTech & Institutions</td>
                        <td>11</td>
                        <td>Active</td>
                        <td><button class="rowbtn">•••</button></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
