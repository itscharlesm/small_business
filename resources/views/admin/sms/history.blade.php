@extends('admin.themes.layouts.main')
@section('content')
    {{-- Content Header) --}}
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">SMS</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ action('App\Http\Controllers\AdminController@home') }}">Home</a></li>
                        <li class="breadcrumb-item">SMS</li>
                        <li class="breadcrumb-item active">History</li>
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
                            <span class="fa fa-calendar"></span> Select Date
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ action('App\Http\Controllers\SMSController@history2') }}">
                            {{ csrf_field() }}
                                <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="date_from">From</label>
                                        @if(isset($date_from))
                                            <input class="form-control" type="date" name="date_from" id="date_from" value="{{ $date_from }}" required/>
                                        @else 
                                            <input class="form-control" type="date" name="date_from" id="date_from" required/>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="date_to">To</label>
                                        @if(isset($date_to))
                                            <input class="form-control" type="date" name="date_to" id="date_to" value="{{ $date_to }}" required/>
                                        @else 
                                            <input class="form-control" type="date" name="date_to" id="date_to" required/>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary"><span class="fa fa-search"></span> Search</button>
                                    </div>
                                </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-info card-outline">
                        <div class="card-header">
                            @if(isset($date_from))
                                <h3 class="card-title"><span class="fa fa-history"></span> Message History</h3>
                            @else
                                <h3 class="card-title"><span class="fa fa-history"></span> Message History (recent 100 messages)</h3>
                            @endif
                        </div>
                        <div class="card-body">
                           <table class="table">
                                <thead>
                                    <tr>
                                        <th width="200">Date Sent</th>
                                        <th width="150px">Contact No.</th>
                                        <th width="200">Name</th>
                                        <th>Message</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($messages as $message)
                                        <tr>
                                            <td>{{ $message->sms_date_created }}</td>
                                            <td>+63{{ $message->sms_number }}</td>
                                            <td>{{ $message->con_name }}</td>
                                            <td>{{ $message->sms_content }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
