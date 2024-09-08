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
                        <li class="breadcrumb-item active">Search QR</li>
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
                    <form method="POST" action="{{ action('App\Http\Controllers\BorrowController@find') }}">
                    {{ csrf_field() }}
                        <div class="form-group">
                            <label for="res_uuid">Scan QR Code <span style="color:red;">*</span></label>
                            <input class="form-control" type="text" name="res_uuid" id="res_uuid" placeholder="" required autofocus/>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
