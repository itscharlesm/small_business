@extends('admin.themes.layouts.main')
@section('content')
    {{-- Content Header) --}}
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Borrow Equipment</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ action('App\Http\Controllers\AdminController@home') }}">Home</a></li>
                        <li class="breadcrumb-item">Borrow</li>
                        <li class="breadcrumb-item active">Borrow Equipment</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    {{-- Main Content  --}}
    <section class="content">
        <div class="container-fluid">
            {{-- <div class="row">
                <div class="col-md-12">
                    <a class="btn btn-secondary mb-3" href="{{ action('App\Http\Controllers\BorrowController@search') }}"><span class="fa fa-qrcode"></span> Search by QR</a>
                </div>
            </div> --}}
            <div class="row">
                <div class="col-md-12">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Equipment Name</th>
                                <th>Description</th>
                                <th>Total Available</th>
                                <th width="150px">Borrow</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($equipments as $equipment)
                                <tr>
                                    <td>
                                        {{ $equipment->eqp_name }}
                                    </td>
                                    <td>
                                        {{ $equipment->eqp_description }}
                                    </td>
                                    <td>
                                        {{ $equipment->eqp_quantity }}
                                    </td>
                                    <td>
                                        <a class="btn btn-primary" href="javascrip:void(0)" data-toggle="modal" data-target="#borrowModal{{$equipment->eqp_uuid}}"><span class="fa fa-bookmark"></span> Borrow</a>
                                    </td>
                                </tr>
                                <div class="modal fade" id="borrowModal{{$equipment->eqp_uuid}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Borrow Equipment</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form method="POST" action="{{ action('App\Http\Controllers\BorrowController@borrow') }}">
                                            {{ csrf_field() }}
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label for="eqp_name">Equipment Name <span style="color:red;">*</span></label>
                                                        <input class="form-control" type="text" name="eqp_name" id="eqp_name" placeholder="Name of equipment" value="{{ $equipment->eqp_name }}" readonly/>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="eqp_description">Equipment Description <span style="color:red;">*</span></label>
                                                        <input class="form-control" type="text" name="eqp_description" id="eqp_description" placeholder="Description of equipment" value="{{ $equipment->eqp_description }}" readonly/>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="eqp_quantity">Available <span style="color:red;">*</span></label>
                                                        <input class="form-control" type="number" name="eqp_quantity" id="eqp_quantity" value="{{ $equipment->eqp_quantity }}" readonly/>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="eqp_quantity2">Qty. to Borrow <span style="color:red;">*</span></label>
                                                        <input class="form-control" min="1" max="{{ $equipment->eqp_quantity }}" type="number" name="eqp_quantity2" id="eqp_quantity2" required/>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <input type="hidden" name="eqp_id" value="{{ $equipment->eqp_id }}" required />
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary"><span class="fa fa-check-circle"></span> Borrow Equipment</button>
                                                </div>
                                            </form>
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
