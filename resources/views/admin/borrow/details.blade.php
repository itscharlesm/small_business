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
                        <li class="breadcrumb-item active">Borrow Details</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    {{-- Main Content  --}}
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 mb-3">
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
                
                    <a type="button" class="btn btn-success" href="{{ action('App\Http\Controllers\BorrowController@approve',[$borrow_request->res_uuid]) }}"><span class="fa fa-check-circle"></span> Approve</a>
                    <a type="button" class="btn btn-danger" href="{{ action('App\Http\Controllers\BorrowController@disapprove',[$borrow_request->res_uuid]) }}"><span class="fa fa-times-circle"></span> Disapprove</a>
                </div>
            </div>
        </div>
    </section>
@endsection
