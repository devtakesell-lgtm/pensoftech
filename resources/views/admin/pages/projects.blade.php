@extends('admin.layouts.admin-master')

@section('title', 'Projects')

@section('content')
    <div class="heading">
        <div><small>AGENCY ADMIN</small>
            <h1>Project Management</h1>
            <p>Manage your PenSoftTech agency operations from one place.</p>
        </div>
        <div><button class="btn light">⇩ Export</button><button class="btn primary">＋ Create New</button></div>
    </div>
    <div class="card list-card">
        <div class="toolbar">
            <div class="filters"><input placeholder="Search projects..."><select>
                    <option>All Status</option>
                </select></div><button class="btn primary">＋ Add Project</button>
        </div>
        <div class="tablewrap">
            <table>
                <thead>
                    <tr>
                        <th>PROJECT</th>
                        <th>CLIENT</th>
                        <th>SERVICE</th>
                        <th>BUDGET</th>
                        <th>STATUS</th>
                        <th>ACTION</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Nova Labs Website</td>
                        <td>Nova Labs</td>
                        <td>Web Development</td>
                        <td>{{ $defaultCurrency?->symbol ?? '$' }}8,900</td>
                        <td>In Progress</td>
                        <td><button class="rowbtn">•••</button></td>
                    </tr>
                    <tr>
                        <td>BrightCo Mobile App</td>
                        <td>BrightCo</td>
                        <td>Mobile App</td>
                        <td>{{ $defaultCurrency?->symbol ?? '$' }}12,500</td>
                        <td>In Progress</td>
                        <td><button class="rowbtn">•••</button></td>
                    </tr>
                    <tr>
                        <td>FinServe Growth</td>
                        <td>FinServe</td>
                        <td>Digital Marketing</td>
                        <td>{{ $defaultCurrency?->symbol ?? '$' }}4,800</td>
                        <td>Completed</td>
                        <td><button class="rowbtn">•••</button></td>
                    </tr>
                    <tr>
                        <td>CloudCore Store</td>
                        <td>CloudCore</td>
                        <td>E-commerce</td>
                        <td>{{ $defaultCurrency?->symbol ?? '$' }}15,200</td>
                        <td>Planning</td>
                        <td><button class="rowbtn">•••</button></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
