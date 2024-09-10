@extends('admin.themes.layouts.main')

@section('title', 'Product Details')

@section('content')
{{-- Content Header) --}}
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Products Details</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a
                            href="{{ action('App\Http\Controllers\AdminController@home') }}">Home</a></li>
                    <li class="breadcrumb-item">Utility</li>
                    <li class="breadcrumb-item">Manage Product Details</li>
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
                            <th class="text-center">Total Orders</th>
                            <th class="text-center">Total</th>
                            <th class="text-center">Payment</th>
                            <th class="text-center">Change</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transactions as $index => $transaction)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td class="text-center">{{ $transaction->formatted_date }}</td>
                                <td class="text-center">{{ $transaction->mtrx_total_orders }}</td>
                                <td class="text-right">₱{{ number_format($transaction->mtrx_total, 2) ?? 0  }}</td>
                                <td class="text-right">₱{{ number_format($transaction->mtrx_cash, 2) ?? 0  }}</td>
                                <td class="text-right">₱{{ number_format($transaction->mtrx_change, 2) ?? 0 }}</td>
                                <td class="text-center"><a class="btn btn-primary" href="#"><i class="fa fa-eye"></i>
                                        View</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

@endsection