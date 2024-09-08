@extends('admin.themes.layouts.main')

@section('title', 'Home - Dashboard')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Home</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a
                            href="{{ action('App\Http\Controllers\AdminController@home') }}">Home</a></li>
                </ol>
            </div>
        </div>
    </div>
</div>

{{-- Main Content --}}
<section class="content">
    <ul class="nav nav-tabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="dashboard-tab" data-toggle="tab" href="#dashboard-content" role="tab"
                aria-controls="dashboard-content" aria-selected="true">Dashboard</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="announcements-tab" data-toggle="tab" href="#announcements-content" role="tab"
                aria-controls="announcements-content" aria-selected="false">Announcements</a>
        </li>
    </ul>

    <div class="tab-content">
        <div class="tab-pane fade show active" id="dashboard-content" role="tabpanel" aria-labelledby="dashboard-tab">
            <!-- Dashboard Content -->
            @include('admin.dashboard.dashboard')
        </div>
        <div class="tab-pane fade" id="announcements-content" role="tabpanel" aria-labelledby="announcements-tab">
            <!-- Announcements Content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row mt-3">
                        <div class="col-md-8">
                            <div class="timeline">
                                <div class="time-label">
                                    <span class="bg-info"><i class="fa fa-bullhorn"></i> Announcements</span>
                                    @if(session('usr_type') == '1')
                                    <a class="btn btn-primary float-right" href="javascript:void(0)" data-toggle="modal"
                                        data-target="#newAnnouncementModal"><i class="fa fa-comment"></i> Compose</a>
                                    @endif
                                </div>
                                @if ($announcements->count() == 0)
                                <div>
                                    <i class="fas fa-newspaper bg-blue"></i>
                                    <div class="timeline-item">
                                        {{-- <span class="time"><i class="fas fa-clock"></i>
                                            {{ \Carbon\Carbon::parse($announcement->ann_date_created)->diffForHumans()
                                            }}</span> --}}
                                        <h3 class="timeline-header">Announcement</h3>
                                        <div class="timeline-body">
                                            <p>No announcement yet!</p>
                                        </div>
                                    </div>
                                </div>
                                @else
                                @foreach($announcements as $announcement)
                                <div>
                                    <i class="fas fa-newspaper bg-blue"></i>
                                    <div class="timeline-item">
                                        <span class="time"><i class="fas fa-clock"></i>
                                            {{ \Carbon\Carbon::parse($announcement->ann_date_created)->diffForHumans()
                                            }}</span>
                                        <h3 class="timeline-header">{{ $announcement->ann_title }}</h3>
                                        <div class="timeline-body">
                                            @if($announcement->ann_image != '')
                                            <div class="thumbnail">
                                                <a
                                                    href="{{ asset('images/announcements/' . $announcement->ann_image) }}">
                                                    <img src="{{ asset('images/announcements/' . $announcement->ann_image) }}"
                                                        alt="" style="width:100%">
                                                </a>
                                                <div class="caption">
                                                    <p>{{ $announcement->ann_content }}</p>
                                                </div>
                                            </div>
                                            @else
                                            <p>{{ $announcement->ann_content }}</p>
                                            @endif
                                        </div>
                                        <div class="timeline-footer">
                                            @if(session('usr_type') == '1')
                                            <a class="btn btn-danger btn-sm"
                                                href="{{ action('App\Http\Controllers\AnnouncementController@delete',[$announcement->ann_uuid]) }}"><i
                                                    class="fa fa-trash"></i> Delete</a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                @endif
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card card-info">
                                <div class="card-header border-bottom-0 bg-navy">
                                    <h3 class="card-title" style="color:white"><i class="fas fa-history"></i> Recent
                                        Users</h3>
                                </div>
                                <div class="card-body pt-0">
                                    <ul class="products-list product-list-in-card pl-2 pr-2">
                                        @foreach($logins as $login)
                                        <li class="item">
                                            <div class="product-img">
                                                <img class="img-size-50 img-circle"
                                                    src="{{ asset(getAvatar($login->usr_id)) }}" alt="user image">
                                            </div>
                                            <div class="product-info">
                                                <a href="#" class="product-title">
                                                    {{ $login->usr_last_name }}, {{ $login->usr_first_name }}
                                                    <span class="badge badge-info float-right"></span>
                                                </a>
                                                <span class="product-description">
                                                    {{ \Carbon\Carbon::parse($login->log_date_max)->diffForHumans() }}
                                                </span>
                                            </div>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>

</section>

<div class="modal fade" id="newAnnouncementModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Create New Annoucement</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ action('App\Http\Controllers\AnnouncementController@save') }}" method="POST"
                enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="form-group">
                        <label for="ann_title">Title <span style="color:red;">*</span></label>
                        <input type="text" class="form-control" id="ann_title" name="ann_title" placeholder="Title"
                            required />
                    </div>
                    <div class="form-group">
                        <label for="ann_content">Message Content <span style="color:red;">*</span></label>
                        <textarea class="form-control" id="ann_content" name="ann_content" rows="4"></textarea>
                    </div>
                    <div class="form-group">
                        <div class="custom-file">
                            <label for="ann_image">Image</label>
                            <input type="file" class="custom-file-input" id="customFile" name="ann_image" />
                            <label class="custom-file-label" for="customFile">Choose file</label>
                        </div>
                        <small id="fileHelp" class="form-text text-muted">Please upload a valid image file in jpg or png
                            format. Size of image should not be more than 3MB.</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary"><span class="fa fa-save"></span> Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

@if(isset($data))
<script>
    $(function () {
        //Equipment
        var donutChartCanvas = $('#donutChart').get(0).getContext('2d')
        var donutData = {
            labels: @json($data['labels']),
            datasets: [
                {
                data: @json($data['data']),
                backgroundColor : ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de'],
                }
            ]
        }

        var donutOptions = {
            maintainAspectRatio : false,
            responsive : true,
        }

        var donutChart = new Chart(donutChartCanvas, {
            type: 'doughnut',
            data: donutData,
            options: donutOptions      
        })

        //Borrowers
        var donutChartCanvas2 = $('#donutChart2').get(0).getContext('2d')
        var donutData2 = {
            labels: @json($data2['labels']),
            datasets: [
                {
                data: @json($data2['data']),
                backgroundColor : ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de'],
                }
            ]
        }

        var donutOptions2 = {
            maintainAspectRatio : false,
            responsive : true,
        }

        var donutChart2 = new Chart(donutChartCanvas2, {
            type: 'doughnut',
            data: donutData2,
            options: donutOptions2      
        })
    })
</script>
@endif
@endsection