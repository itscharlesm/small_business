@extends('admin.themes.layouts.main')
@section('content')
    {{-- Content Header) --}}
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Manage Borrowers</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ action('App\Http\Controllers\AdminController@home') }}">Home</a></li>
                        <li class="breadcrumb-item">Borrowers</li>
                        <li class="breadcrumb-item active">Manage Borrowers</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    {{-- Main Content  --}}
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <button type="button" class="btn btn-secondary mb-3" data-toggle="modal" data-target="#newBorrowerModal"><span class="fa fa-plus"></span> New Borrower</button>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Borrower's Name</th>
                                <th>Mobile Number</th>
                                <th>E-mail</th>
                                <th>QR Code</th>
                                <th width="70px">Active</th>
                                <th width="100px"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($borrowers as $borrower)
                                <tr>
                                    <td>
                                        <a href="javascrip:void(0)" data-toggle="modal" data-target="#editModal{{$borrower->bor_uuid}}">
                                            <span class="fa fa-edit"></span> 
                                            <strong>[{{ $borrower->bor_student_id }}]</strong>
                                            {{ $borrower->bor_last_name }}, {{ $borrower->bor_first_name }} {{ $borrower->bor_middle_name }}
                                        </a>
                                        @if($borrower->bor_active == '1')
                                            <span class="badge badge-success"> Active </span>
                                        @else
                                            <span class="badge badge-danger"> Inactive </span>
                                        @endif
                                    </td>
                                    <td>
                                        {{ $borrower->bor_mobile }}
                                    </td>
                                    <td>
                                        {{ $borrower->bor_email }}
                                    </td>
                                    <td>
                                        <a href="{{ action('App\Http\Controllers\QRController@generate',[$borrower->bor_uuid]) }}" target="_blank"><span class="fa fa-qrcode"></span></a>
                                    </td>
                                    <td>
                                        @if($borrower->bor_active == '1')
                                            <a href="{{ action('App\Http\Controllers\BorrowerController@deactivate',[$borrower->bor_uuid]) }}"><span class="fa fa-toggle-on"></span></a>
                                        @else
                                            <a href="{{ action('App\Http\Controllers\BorrowerController@activate',[$borrower->bor_uuid]) }}"><span class="fa fa-toggle-off"></span></a>
                                        @endif
                                    </td>
                                    <td>
                                        <a class="btn btn-info btn-sm" href="javascrip:void(0)" data-toggle="modal" data-target="#resetModal{{$borrower->bor_uuid}}"><span class="fa fa-key"></span> Reset</a>
                                    </td>
                                </tr>
                                <div class="modal fade" id="editModal{{$borrower->bor_uuid}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Edit Borrower</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form method="POST" action="{{ action('App\Http\Controllers\BorrowerController@update') }}">
                                            {{ csrf_field() }}
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label for="bor_student_id">Borrower's ID Number <span style="color:red;">*</span></label>
                                                        <input class="form-control" type="text" name="bor_student_id" id="bor_student_id" placeholder="ID Number" value="{{ $borrower->bor_student_id }}" required/>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="bor_last_name">Borrower's Last Name <span style="color:red;">*</span></label>
                                                        <input class="form-control" type="text" name="bor_last_name" id="bor_last_name" placeholder="Last Name" value="{{ $borrower->bor_last_name }}" required/>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="bor_first_name">First Name <span style="color:red;">*</span></label>
                                                        <input class="form-control" type="text" name="bor_first_name" id="bor_first_name" placeholder="First Name" value="{{ $borrower->bor_first_name }}" required/>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="bor_middle_name">Middle Name</label>
                                                        <input class="form-control" type="text" name="bor_middle_name" id="bor_middle_name" placeholder="Middle Name" value="{{ $borrower->bor_middle_name }}" />
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="bor_address">Address</label>
                                                        <textarea class="form-control" name="bor_address" id="bor_address" rows="5" required>{{ $borrower->bor_address }}</textarea>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="bor_mobile">Mobile Number (eg. 9109005555) <span style="color:red;">*</span></label>
                                                        <input class="form-control" type="number" name="bor_mobile" id="bor_mobile" placeholder="" value="{{ $borrower->bor_mobile }}" required />
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="bor_email">E-mail <span style="color:red;">*</span></label>
                                                        <input class="form-control" type="email" name="bor_email" id="bor_email" placeholder="" value="{{ $borrower->bor_email }}" required />
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <input type="hidden" name="bor_uuid" value="{{ $borrower->bor_uuid }}" required />
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary"><span class="fa fa-save"></span> Save changes</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal fade" id="resetModal{{$borrower->bor_uuid}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Please Confirm</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                Are you sure you want to reset this borrower's password?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <a class="btn btn-primary" href="{{ action('App\Http\Controllers\BorrowerController@reset',[$borrower->bor_uuid]) }}">Reset</a>
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
    {{-- Modals  --}}
    <div class="modal fade" id="newBorrowerModal" tabindex="-1" role="dialog" aria-labelledby="newBorrowerModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="newUserModalLabel">Create New Borrower</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="{{ action('App\Http\Controllers\BorrowerController@save') }}">
                {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="bor_student_id">Borrower's ID Number <span style="color:red;">*</span></label>
                            <input class="form-control" type="text" name="bor_student_id" id="bor_student_id" placeholder="ID Number" required/>
                        </div>
                        <div class="form-group">
                            <label for="bor_last_name">Borrower's Last Name <span style="color:red;">*</span></label>
                            <input class="form-control" type="text" name="bor_last_name" id="bor_last_name" placeholder="Last Name" required/>
                        </div>
                        <div class="form-group">
                            <label for="bor_first_name">First Name <span style="color:red;">*</span></label>
                            <input class="form-control" type="text" name="bor_first_name" id="bor_first_name" placeholder="First Name" required/>
                        </div>
                        <div class="form-group">
                            <label for="bor_middle_name">Middle Name</label>
                            <input class="form-control" type="text" name="bor_middle_name" id="bor_middle_name" placeholder="Middle Name" />
                        </div>
                        <div class="form-group">
                            <label for="bor_address">Address</label>
                            <textarea class="form-control" name="bor_address" id="bor_address" rows="5" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="bor_mobile">Mobile Number (eg. 9109005555) <span style="color:red;">*</span></label>
                            <input class="form-control" type="number" name="bor_mobile" id="bor_mobile" placeholder="" required />
                        </div>
                        <div class="form-group">
                            <label for="bor_email">E-mail <span style="color:red;">*</span></label>
                            <input class="form-control" type="email" name="bor_email" id="bor_email" placeholder="" required />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary"><span class="fa fa-save"></span> Save borrower</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
