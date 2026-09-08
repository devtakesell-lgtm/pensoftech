@extends('admin.layouts.admin-master')

@section('title', 'Services')

@section('content')
    <div class="heading">
        <div><small>AGENCY ADMIN</small>
            <h1>Services Management</h1>
            <p>Manage your PenSoftTech agency operations from one place.</p>
        </div>
        <div><button class="btn light">⇩ Export</button><button class="btn primary">＋ Create New</button></div>
    </div>
    <div class="card list-card">
        <div class="toolbar">
            <div class="filters"><input placeholder="Search services..."><select>
                    <option>All Status</option>
                </select></div><button class="btn primary">＋ Add Service</button>
        </div>
        <div class="tablewrap">
            <table>
                <thead>
                    <tr>
                        <th>SERVICE</th>
                        <th>CATEGORY</th>
                        <th>PROJECTS</th>
                        <th>STATUS</th>
                        <th>ACTION</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Web Development</td>
                        <td>Software Development</td>
                        <td>32 Projects</td>
                        <td>Active</td>
                        <td><button class="rowbtn">•••</button></td>
                    </tr>
                    <tr>
                        <td>Mobile App Development</td>
                        <td>Software Development</td>
                        <td>18 Projects</td>
                        <td>Active</td>
                        <td><button class="rowbtn">•••</button></td>
                    </tr>
                    <tr>
                        <td>SEO & Marketing</td>
                        <td>Digital Marketing</td>
                        <td>27 Projects</td>
                        <td>Active</td>
                        <td><button class="rowbtn">•••</button></td>
                    </tr>
                    <tr>
                        <td>Meta Ads</td>
                        <td>Digital Marketing</td>
                        <td>41 Projects</td>
                        <td>Active</td>
                        <td><button class="rowbtn">•••</button></td>
                    </tr>
                    <tr>
                        <td>UI/UX Design</td>
                        <td>Software Development</td>
                        <td>22 Projects</td>
                        <td>Active</td>
                        <td><button class="rowbtn">•••</button></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
