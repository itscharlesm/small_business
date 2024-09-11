@extends('admin.themes.layouts.main')

@section('title', 'Product Details')

@section('content')
{{-- Content Header) --}}
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Cash Management</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a
                            href="{{ action('App\Http\Controllers\AdminController@home') }}">Home</a></li>
                    <li class="breadcrumb-item">Transactions</li>
                    <li class="breadcrumb-item">Cash Management</li>
                </ol>
            </div>
        </div>
    </div>
</div>

{{-- Main Content --}}
<section class="content">
    <div class="container-fluid">
        <div class="row mt-3">
            <div class="col-md-12">
                <table class="table table-hover table-striped" id="RegTable">
                    <thead class="bg-gradient-dark">
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Date</th>
                            <th class="text-center">Starting Cash</th>
                            <th class="text-center">Cash on Hand</th>
                            <th class="text-center">End of the Day Cash</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cash_on_hand as $index => $cash)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td class="text-center">{{ $cash->formatted_date }}</td>
                                <td class="text-center">₱{{ number_format($cash->coh_starting_cash, 2) ?? 0  }}</td>
                                <td class="text-right">₱{{ number_format($cash->coh_cash, 2) ?? 0  }}</td>
                                <td class="text-right">₱{{ number_format($cash->coh_ending_cash, 2) ?? 0  }}</td>
                                <td class="text-center">
                                    <a class="btn btn-primary" href="javascript:void(0)" data-toggle="modal"
                                        data-target="#viewCashHistoryModal-{{ $cash->coh_id }}">
                                        <i class="fa fa-eye"></i> View
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

@endsection