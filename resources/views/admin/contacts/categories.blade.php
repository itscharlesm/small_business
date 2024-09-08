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
                        <li class="breadcrumb-item active">Manage Categories</li>
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
                    <button type="button" class="btn btn-secondary mb-3" data-toggle="modal" data-target="#newCategoryModal"><span class="fa fa-plus"></span> New Category</button>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Category Name</th>
                                <th width="100px" class="text-center"><span class="fa fa-cog"></span></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($categories as $category)
                                <tr>
                                    <td>
                                        {{ $category->cat_name }}
                                    </td>
                                    <td>
                                        <a class="btn btn-primary btn-sm" href="javascript:void(0)" data-toggle="modal" data-target="#editCategoryModal{{$category->cat_uuid}}"><span class="fa fa-edit"></span></a>
                                        <a class="btn btn-danger btn-sm" href="javascript:void(0)" data-toggle="modal" data-target="#deleteCategoryModal{{$category->cat_uuid}}"><span class="fa fa-trash"></span></a>
                                    </td>
                                </tr>
                                <div class="modal fade" id="editCategoryModal{{$category->cat_uuid}}" tabindex="-1" role="dialog" aria-labelledby="editContactModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deleteContactModalLabel">Edit Contact Category</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                           <form method="POST" action="{{ action('App\Http\Controllers\ContactController@updateCategory') }}">
                                            {{ csrf_field() }}
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label for="cat_name">Category Name <span style="color:red;">*</span></label>
                                                        <input class="form-control" type="text" name="cat_name" id="cat_name" placeholder="Category Name" value="{{ $category->cat_name }}" required/>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <input type="hidden" name="cat_uuid" id="cat_uuid" value="{{ $category->cat_uuid }}" required/>
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary"><span class="fa fa-save"></span> Save changes</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal fade" id="deleteCategoryModal{{$category->cat_uuid}}" tabindex="-1" role="dialog" aria-labelledby="deleteContactModalLabel" aria-hidden="true">
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
                                                <p>Are you sure you want to remove {{ $category->cat_name }}?</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <a class="btn btn-danger" href="{{ action('App\Http\Controllers\ContactController@deleteCategory',[$category->cat_uuid]) }}"><span class="fa fa-trash"></span> Delete category</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <tr>
                                    <td colspan="2" class="text-center">
                                        --- No contact category ---
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    {{-- Modals  --}}
    <div class="modal fade" id="newCategoryModal" tabindex="-1" role="dialog" aria-labelledby="newContactModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="newContactModalLabel">Create New Contact Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="{{ action('App\Http\Controllers\ContactController@saveCategory') }}">
                {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="cat_name">Category Name <span style="color:red;">*</span></label>
                            <input class="form-control" type="text" name="cat_name" id="cat_name" placeholder="Category Name" required/>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary"><span class="fa fa-save"></span> Save category</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
