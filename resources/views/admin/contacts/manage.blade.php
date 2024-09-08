@extends('admin.themes.layouts.main')
@section('content')
    {{-- Content Header) --}}
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Manage Contacts</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ action('App\Http\Controllers\AdminController@home') }}">Home</a></li>
                        <li class="breadcrumb-item">Contacts</li>
                        <li class="breadcrumb-item active">Manage Contacts</li>
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
                    <div class="card">
                        <div class="card-header">
                            <span class="fa fa-address-book"></span> Enter Contact Name
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ action('App\Http\Controllers\ContactController@find') }}">
                            {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="search_string">Contact Name</label>
                                    @if(isset($search_string))
                                        <input class="form-control" type="text" name="search_string" id="search_string" placeholder="Contact Name" value="{{ $search_string }}" required/>
                                    @else 
                                        <input class="form-control" type="text" name="search_string" id="search_string" placeholder="Contact Name" required/>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary"><span class="fa fa-search"></span> Find Contact</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <button type="button" class="btn btn-secondary mb-3" data-toggle="modal" data-target="#newContactModal"><span class="fa fa-plus"></span> New Contact</button>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Mobile</th>
                                <th>Category(ies)</th>
                                <th width="100px" class="text-center"><span class="fa fa-cog"></span></th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($contacts))
                                @forelse($contacts as $contact)
                                    <tr>
                                        <td>
                                            {{ $contact->con_name }}
                                        </td>
                                        <td>
                                            +63{{ $contact->con_mobile }}
                                        </td>
                                        <td>
                                           {!! getContactCategories($contact->con_id) !!}
                                        </td>
                                        <td>
                                           <a class="btn btn-primary btn-sm" href="{{ action('App\Http\Controllers\ContactController@edit',[$contact->con_uuid]) }}"><span class="fa fa-edit"></span></a>
                                           <a class="btn btn-danger btn-sm" href="javascript:void(0)" data-toggle="modal" data-target="#deleteContactModal{{$contact->con_uuid}}"><span class="fa fa-trash"></span></a>
                                        </td>
                                    </tr>
                                    <div class="modal fade" id="deleteContactModal{{$contact->con_uuid}}" tabindex="-1" role="dialog" aria-labelledby="deleteContactModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="deleteContactModalLabel">Confirm Deletion</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <h3><span class="fa fa-info-circle"></span></h3>
                                                    <p>Are you sure you want to remove {{ $contact->con_name }}?</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    <a class="btn btn-danger" href="{{ action('App\Http\Controllers\ContactController@delete',[$contact->con_uuid]) }}"><span class="fa fa-trash"></span> Delete contact</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center">
                                            --- No matching contact found ---
                                        </td>
                                    </tr>
                                @endforelse
                            @else
                                <tr>
                                    <td colspan="3" class="text-center">
                                        --- Search a contact ---
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    {{-- Modals  --}}
    <div class="modal fade" id="newContactModal" tabindex="-1" role="dialog" aria-labelledby="newContactModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="newContactModalLabel">Create New Contact</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="{{ action('App\Http\Controllers\ContactController@save') }}">
                {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="con_name">Name <span style="color:red;">*</span></label>
                            <input class="form-control" type="text" name="con_name" id="con_name" placeholder="Contact Name" required/>
                        </div>
                        <div class="form-group">
                            <label for="con_mobile">Mobile No. <span style="color:red;">*</span><small>(Format: 09101234567)</small></label>
                            <input class="form-control" type="number" min="00000000000" max="09999999999" name="con_mobile" id="con_mobile" placeholder="Mobile Number" required/>
                        </div>
                        <div class="form-group">
                            <label for="cat_ids">Category</label>
                            <select class="select2" multiple="multiple" data-placeholder="Select categories" style="width: 100%;" name="categories[]">
                                @foreach($categories as $category)
                                    <option value="{{ $category->cat_id }}">{{ $category->cat_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary"><span class="fa fa-save"></span> Save contact</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
