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
                        <li class="breadcrumb-item active">Edit Contact</li>
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
                            <span class="fa fa-address-book"></span> Update Contact Information
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ action('App\Http\Controllers\ContactController@update') }}">
                            {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="con_name">Name <span style="color:red;">*</span></label>
                                    <input class="form-control" type="text" name="con_name" id="con_name" placeholder="Contact Name" value="{{ $contact->con_name }}" required/>
                                </div>
                                <div class="form-group">
                                    <label for="con_mobile">Mobile No. <span style="color:red;">*</span><small>(Format: 09101234567)</small></label>
                                    <input class="form-control" type="number" min="00000000000" max="09999999999" name="con_mobile" id="con_mobile" placeholder="Mobile Number" value="{{ $contact->con_mobile }}" required/>
                                </div>
                                <div class="form-group">
                                    <label for="cat_ids">Category</label>
                                    <select class="select2" multiple="multiple" data-placeholder="Select categories" style="width: 100%;" name="categories[]">
                                        @foreach($categories as $category)
                                            @if(isPresentContactCategory($contact->con_id,$category->cat_id) == true)
                                                <option value="{{ $category->cat_id }}" selected>{{ $category->cat_name }}</option>
                                            @else
                                                <option value="{{ $category->cat_id }}">{{ $category->cat_name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <input type="hidden" name="con_id" id="con_id" value="{{ $contact->con_id }}" required/>
                                    <button type="submit" class="btn btn-primary"><span class="fa fa-save"></span> Save changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
