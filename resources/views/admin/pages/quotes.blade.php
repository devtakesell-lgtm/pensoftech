@extends('admin.layouts.admin-master')

@section('title', 'Quotes')

@section('content')
    <div class="heading">
        <div><small>AGENCY ADMIN</small>
            <h1>Quotes & Proposals</h1>
            <p>Manage your PenSoftTech agency operations from one place.</p>
        </div>
        <div><button class="btn light">⇩ Export</button><button class="btn primary">＋ Create New</button></div>
    </div>
    <div class="card list-card">
        <div class="toolbar">
            <div class="filters"><input placeholder="Search quotes..."><select>
                    <option>All Status</option>
                </select></div><button class="btn primary">＋ Add Quote</button>
        </div>
        <div class="tablewrap">
            <table>
                <thead>
                    <tr>
                        <th>QUOTE</th>
                        <th>CLIENT</th>
                        <th>SERVICE</th>
                        <th>AMOUNT</th>
                        <th>STATUS</th>
                        <th>ACTION</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>#QT-1048</td>
                        <td>BrightCo</td>
                        <td>Mobile App</td>
                        <td>{{ $defaultCurrency?->symbol ?? '$' }}12,500</td>
                        <td>Sent</td>
                        <td><button class="rowbtn">•••</button></td>
                    </tr>
                    <tr>
                        <td>#QT-1047</td>
                        <td>Nova Labs</td>
                        <td>Web Development</td>
                        <td>{{ $defaultCurrency?->symbol ?? '$' }}8,900</td>
                        <td>Accepted</td>
                        <td><button class="rowbtn">•••</button></td>
                    </tr>
                    <tr>
                        <td>#QT-1046</td>
                        <td>FinServe</td>
                        <td>Digital Marketing</td>
                        <td>{{ $defaultCurrency?->symbol ?? '$' }}4,800</td>
                        <td>Negotiation</td>
                        <td><button class="rowbtn">•••</button></td>
                    </tr>
                    <tr>
                        <td>#QT-1045</td>
                        <td>CloudCore</td>
                        <td>E-commerce</td>
                        <td>{{ $defaultCurrency?->symbol ?? '$' }}15,200</td>
                        <td>Draft</td>
                        <td><button class="rowbtn">•••</button></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
