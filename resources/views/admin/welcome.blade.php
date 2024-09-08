@extends('admin.themes.layouts.main')
@section('content')
    {{-- Content Header) --}}
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Welcome to GRIND</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Welcome</li>
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
                        <div class="card-body">
                            <p>Welcome to GRIND portal!</p>
                            <p>To access this page, you may use <strong style="color:maroon;">{{ session('usr_email_activation_code') }}</strong> as your temporary password.</p>
                            <p>We strongly advise you change your password right away. To do so, kindly enter your new password below:</p>
                            <form method="POST" action="{{ action('App\Http\Controllers\UserController@updatePassword') }}">
                            {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="usr_password1">New Password *</label>
                                    <input class="form-control" type="password" name="usr_password1" id="usr_password1" placeholder="New Password" required/>
                                </div>
                                <div class="form-group">
                                    <label for="usr_password2">Re-type Password *</label>
                                    <input class="form-control" type="password" name="usr_password2" id="usr_password2" placeholder="Re-type Password" required/>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary"><span class="fa fa-save"></span> Change Password</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
