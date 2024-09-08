@extends('admin.themes.layouts.main')
@section('content')
    {{-- Content Header) --}}
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Borrow History</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ action('App\Http\Controllers\AdminController@home') }}">Home</a></li>
                        <li class="breadcrumb-item">Borrow</li>
                        <li class="breadcrumb-item active">Unreturned Equipment</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    {{-- Main Content  --}}
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                {{-- <div class="col-md-12">
                    <a class="btn btn-secondary mb-3" href="#"><span class="fa fa-qrcode"></span> Search by QR</a>
                </div> --}}
            </div>
            <div class="row">
                <div class="col-md-12">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Borrower</th>
                                <th>Equipment Name</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th>Total Borrowed</th>
                                <th width="200px">Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($borrow_requests as $borrow_request)
                                <tr>
                                    <td>
                                        [{{ $borrow_request->bor_student_id }}] {{ $borrow_request->bor_last_name }}, {{ $borrow_request->bor_first_name }} {{ $borrow_request->bor_middle_name }}
                                    </td>
                                    <td>
                                        @if($borrow_request->res_active == '1')
                                        {{-- 1=for_approval,2=released,3=returned,-1=disapproved --}}
                                            @if($borrow_request->res_status == '1')
                                                <span class="badge badge-info">Equipment for Releasing</span>
                                            @elseif($borrow_request->res_status == '2')
                                                <span class="badge badge-info">Equipment Released/For Return</span>
                                            @elseif($borrow_request->res_status == '3')
                                                <span class="badge badge-success">Equipment Returned</span>
                                            @elseif($borrow_request->res_status == '-1')
                                                <span class="badge badge-warning">Request Disapproved</span>
                                            @endif
                                        @else
                                            <span class="badge badge-danger">Cancelled</span>
                                        @endif
                                        <br/>
                                        {{ $borrow_request->eqp_name }} <br/>
                                        <small>Date Requested: {{ $borrow_request->res_date_requested }}</small>
                                    </td>
                                    <td>
                                        {{ $borrow_request->eqp_description }}
                                    </td>
                                    <td>
                                         {!! overdue_days($borrow_request->res_id) !!}
                                    </td>
                                    <td>
                                        {{ $borrow_request->res_quantity }}
                                    </td>
                                    <td>
                                        <a class="btn btn-primary" href="javascrip:void(0)" data-toggle="modal" data-target="#borrowDetailsModal{{$borrow_request->res_uuid}}"><span class="fa fa-eye"></span> Details</a>
                                        <a class="btn btn-secondary" href="{{ action('App\Http\Controllers\QRController@generate',[$borrow_request->res_uuid]) }}" target="_blank"><span class="fa fa-qrcode"></span></a>
                                    </td>
                                </tr>
                                <div class="modal fade" id="borrowDetailsModal{{$borrow_request->res_uuid}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Borrow Details</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label for="bor_details">Borrower Details</label>
                                                    <input class="form-control" type="text" name="bor_details" id="bor_details" placeholder="Name of borrower" value="[{{ $borrow_request->bor_student_id }}] {{ $borrow_request->bor_last_name }}, {{ $borrow_request->bor_first_name }} {{ $borrow_request->bor_middle_name }}" readonly/>
                                                </div>
                                                <div class="form-group">
                                                    <label for="eqp_name">Equipment Name</label>
                                                    <input class="form-control" type="text" name="eqp_name" id="eqp_name" placeholder="Name of equipment" value="{{ $borrow_request->eqp_name }}" readonly/>
                                                </div>
                                                <div class="form-group">
                                                    <label for="eqp_description">Equipment Description</label>
                                                    <input class="form-control" type="text" name="eqp_description" id="eqp_description" placeholder="Description of equipment" value="{{ $borrow_request->eqp_description }}" readonly/>
                                                </div>
                                                <div class="form-group">
                                                    <label for="res_quantity">Borrowed Qty.</label>
                                                    <input class="form-control" type="number" name="res_quantity" id="res_quantity" value="{{ $borrow_request->res_quantity }}" readonly/>
                                                </div>
                                                <div class="form-group">
                                                    <label for="res_date_requested">Date Borrowed</label>
                                                    <input class="form-control" type="text" name="res_date_requested" id="res_date_requested" value="{{ $borrow_request->res_date_requested }}" readonly/>
                                                </div>
                                                <div class="form-group">
                                                    <label for="res_date_released">Date Released (or Cancelled)</label>
                                                    <input class="form-control" type="text" name="res_date_released" id="res_date_released" value="{{ $borrow_request->res_date_released }}" readonly/>
                                                </div>
                                                <div class="form-group">
                                                    <label for="res_date_to_return">To be returned on</label>
                                                    <input class="form-control" type="text" name="res_date_to_return" id="res_date_to_return" value="{{ $borrow_request->res_date_to_return }}" readonly/>
                                                </div>
                                                <div class="form-group">
                                                    <label for="res_date_returned">Date Returned (actual)</label>
                                                    <input class="form-control" type="text" name="res_date_returned" id="res_date_returned" value="{{ $borrow_request->res_date_returned }}" readonly/>
                                                </div>
                                                <div class="form-group">
                                                    <label for="res_approved_by">Released By:</label>
                                                    <input class="form-control" type="text" name="res_approved_by" id="res_approved_by" value="{{ getUserName($borrow_request->res_approved_by) }}" readonly/>
                                                </div>
                                                <div class="form-group">
                                                    <label for="res_return_received_by">Return Received By:</label>
                                                    <input class="form-control" type="text" name="res_return_received_by" id="res_return_received_by" value="{{ getUserName($borrow_request->res_return_received_by) }}" readonly/>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <a type="button" class="btn btn-success" href="{{ action('App\Http\Controllers\BorrowController@return',[$borrow_request->res_uuid]) }}"><span class="fa fa-check-circle"></span> Return Equipment</a>
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection
