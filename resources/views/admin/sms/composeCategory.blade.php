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
                        <li class="breadcrumb-item active">Compose (category)</li>
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
                    @if(get_remaining_daily_credits() > 0)
                        <div class="alert alert-info">
                            <strong><span class="fa fa-info-circle"></span></strong> 
                            <p>-SMS is only limited to {{ session('sms_character_limit') }} characters including blank spaces. </p>
                            <p>-Sending of bulk messages will be queued to SMS server and may take some time depending on the number of recipients.</p>
                            <p>-If the number of recipients is greater that the remaining credits, only the first group of contacts corresponding to the number of remaining credits will receive the SMS.</p>
                        </div>
                        <div class="card card-info card-outline">
                            <div class="card-header">
                                <h3 class="card-title">Compose Text Message</h3>
                            </div>
                            <form method="POST" action="{{ action('App\Http\Controllers\SMSController@sendCategory') }}">
                            {{ csrf_field() }}
                                <div class="card-body">
                                    <div class="form-group">
                                        <select class="select2" multiple="multiple" data-placeholder="Select recipients" style="width: 100%;" name="cat_ids[]" required>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->cat_id }}">{{ $category->cat_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <p>{{ session('acc_short_name') }}:</p>
                                        <textarea id="compose-textarea" class="form-control" style="height: 150px" name="sms_content" maxlength="{{ session('sms_character_limit') }}" onkeyup="changeText()" required></textarea>
                                    </div>
                                    <div class="form-group">
                                        <p id="counter">Characters left: {{ session('sms_character_limit') }}</p>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="float-right">
                                        <button type="submit" class="btn btn-primary"><i class="fa fa-paper-plane"></i> Send</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    @else
                        <div class="alert alert-danger">
                            <strong><span class="fa fa-exclamation-circle"></span></strong> Daily SMS allowance has already been exhausted! Please try again tomorrow.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
    <script>
        function changeText(){
            var sms_content = document.getElementById("compose-textarea");
            var element = document.getElementById("counter");
            element.innerHTML = "Characters left: " + ({{ session('sms_character_limit') }} - sms_content.value.length);
        }
    </script>
@endsection
