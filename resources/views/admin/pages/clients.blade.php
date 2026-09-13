@extends('admin.layouts.admin-master')

@section('title', 'Clients')

@section('content')
    <div class="heading">
        <div><small>AGENCY ADMIN</small>
            <h1>Client Management</h1>
            <p>Manage your PenSoftTech agency operations from one place.</p>
        </div>
        <div><button class="btn light">⇩ Export</button><button class="btn primary">＋ Create New</button></div>
    </div>
    <div class="card list-card">
        <div class="toolbar">
            <div class="filters"><input placeholder="Search clients..."><select>
                    <option>All Status</option>
                </select></div><button class="btn primary">＋ Add Client</button>
        </div>
        <div class="tablewrap">
            <table>
                <thead>
                    <tr>
                        <th>CLIENT</th>
                        <th>CONTACT</th>
                        <th>EMAIL</th>
                        <th>SERVICE</th>
                        <th>STATUS</th>
                        <th>ACTION</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($clients as $client)
                        <tr>
                            <td>Nova Labs</td>
                            <td>Mark Khan</td>
                            <td>mark@novalabs.io</td>
                            <td>Web Development</td>
                            <td>Active</td>
                            <td><button class="rowbtn">•••</button></td>
                        </tr>
                    @endforeach

                </tbody>
            </table>

            <div class="p-3 border-top d-flex justify-content-end">
                {{ $clients->links('pagination::bootstrap-5') }}
            </div>

        </div>
    </div>
@endsection
