@extends('admin.themes.layouts.main')

@section('title', 'Home2')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Home2</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a
                            href="{{ action('App\Http\Controllers\AdminController@home') }}">Home2</a></li>
                </ol>
            </div>
        </div>
    </div>
</div>
<section class="content">
    <div class="container-fluid">
        <div class="row justify-content-start">
            <div class="col-md-6">
                <form id="searchForm" role="form" method="post">
                    @csrf
                    <table style="width:100%">
                        <tr>
                            <th class="mr-3">
                                <div class="form-group">
                                    <label for="from_date"><strong>From</strong></label>
                                    {{-- <input class="form-control" type="date" id="from_date" name="from_date"
                                        value="{{ $startDate}}" placeholder="Last Month"> --}}
                                    <input class="form-control" type="date" id="from_date" name="from_date" value=""
                                        placeholder="Last Month">
                                </div>
                            </th>
                            <th>
                                <div class="form-group">
                                    <label for="to_date"><strong>To</strong></label>
                                    {{-- <input class="form-control" type="date" id="to_date" name="to_date"
                                        value="{{ $endDate }}" placeholder="This Month"> --}}
                                    <input class="form-control" type="date" id="to_date" name="to_date" value=""
                                        placeholder="This Month">
                                </div>
                            </th>
                            <th>
                                <div class="form-group">
                                    <label>&nbsp;</label><br>
                                    <button class="btn btn-primary" type="submit">Search</button>
                                </div>
                            </th>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h3>Top Borrowed Equipments</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <canvas id="barChart" width="400" height="200"></canvas>
                    </div>
                    <div class="col-md-4">
                        <canvas id="pieChart" width="400" height="200"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h3><strong>Results</strong></h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div style="height: 300px;">
                            <table id="example1" class="display" style="width:70%; font-size: 17px;">
                                <thead class="thead-dark">
                                    <tr style="font-size: 20px;">
                                        <th>Equipments</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody id="table1Body">
                                    @if (isset($defaultTopBorrowedEquipment))
                                    @foreach ($defaultTopBorrowedEquipment as $tbe )
                                    <tr>
                                        <td>{{ $tbe->eqp_name }}</td>
                                        <td style="font-weight: bold">{{ $tbe->total_quantity }}</td>
                                    </tr>
                                    @endforeach
                                    @endif

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h3>Top Borrowers</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <canvas id="topBarChart" width="400" height="150"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h3><strong>Results</strong></h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div style="height: 300px;">
                            <table id="example2" class="display" style="width:70%; font-size: 17px;">
                                <thead class="thead-dark">
                                    <tr style="font-size: 20px;">
                                        <th>Name</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody id="table2Body">
                                    @if (isset($defaultTopBorrowedEquipment))
                                    @foreach ($defaultTopBorrowedEquipment as $tbe )
                                    <tr>
                                        <td>{{ $tbe->borrower_name_code }}</td>
                                        <td style="font-weight: bold">{{ $tbe->total_quantity }}</td>
                                    </tr>
                                    @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script src="{{ asset('js/charts.js') }}"></script>
@endsection