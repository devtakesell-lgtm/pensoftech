@extends('admin.layouts.admin-master')

@section('title', 'Case Studies')

@section('content')
    <div class="heading">
        <div><small>AGENCY ADMIN</small>
            <h1>Case Study Management</h1>
            <p>Manage your PenSoftTech agency operations from one place.</p>
        </div>
        <div><button class="btn light">⇩ Export</button><button class="btn primary">＋ Create New</button></div>
    </div>
    <div class="card list-card">
        <div class="toolbar">
            <div class="filters"><input placeholder="Search case studies..."><select>
                    <option>All Status</option>
                </select></div><button class="btn primary">＋ Add Case Studie</button>
        </div>
        <div class="tablewrap">
            <table>
                <thead>
                    <tr>
                        <th>CASE STUDY</th>
                        <th>CLIENT</th>
                        <th>SERVICE</th>
                        <th>RESULT</th>
                        <th>STATUS</th>
                        <th>ACTION</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Nova Labs — Website Revamp</td>
                        <td>Nova Labs</td>
                        <td>Web Development</td>
                        <td>+184% Leads</td>
                        <td>Published</td>
                        <td><button class="rowbtn">•••</button></td>
                    </tr>
                    <tr>
                        <td>FinServe — Growth Campaign</td>
                        <td>FinServe</td>
                        <td>Digital Marketing</td>
                        <td>+72% Revenue</td>
                        <td>Published</td>
                        <td><button class="rowbtn">•••</button></td>
                    </tr>
                    <tr>
                        <td>BrightCo — Mobile Platform</td>
                        <td>BrightCo</td>
                        <td>Mobile App</td>
                        <td>4.9★ Rating</td>
                        <td>Draft</td>
                        <td><button class="rowbtn">•••</button></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
