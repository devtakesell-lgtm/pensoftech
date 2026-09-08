@extends('admin.layouts.admin-master')

@section('title', 'Pages')

@section('content')
    <div class="heading">
        <div><small>AGENCY ADMIN</small>
            <h1>Website Pages</h1>
            <p>Manage your PenSoftTech agency operations from one place.</p>
        </div>
        <div><button class="btn light">⇩ Export</button><button class="btn primary">＋ Create New</button></div>
    </div>
    <div class="card list-card">
        <div class="toolbar">
            <div class="filters"><input placeholder="Search pages..."><select>
                    <option>All Status</option>
                </select></div><button class="btn primary">＋ Add Page</button>
        </div>
        <div class="tablewrap">
            <table>
                <thead>
                    <tr>
                        <th>PAGE</th>
                        <th>URL</th>
                        <th>STATUS</th>
                        <th>UPDATED</th>
                        <th>ACTION</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Home</td>
                        <td>/</td>
                        <td>Published</td>
                        <td>Sep 02, 2026</td>
                        <td><button class="rowbtn">•••</button></td>
                    </tr>
                    <tr>
                        <td>About Us</td>
                        <td>/about</td>
                        <td>Published</td>
                        <td>Sep 01, 2026</td>
                        <td><button class="rowbtn">•••</button></td>
                    </tr>
                    <tr>
                        <td>Services</td>
                        <td>/services</td>
                        <td>Published</td>
                        <td>Aug 29, 2026</td>
                        <td><button class="rowbtn">•••</button></td>
                    </tr>
                    <tr>
                        <td>Portfolio</td>
                        <td>/portfolio</td>
                        <td>Published</td>
                        <td>Aug 25, 2026</td>
                        <td><button class="rowbtn">•••</button></td>
                    </tr>
                    <tr>
                        <td>Contact Us</td>
                        <td>/contact</td>
                        <td>Draft</td>
                        <td>Aug 20, 2026</td>
                        <td><button class="rowbtn">•••</button></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
