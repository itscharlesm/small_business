@extends('layouts.themes.main')
@section('content')
    <section class="section">
        <div class="container mb-3">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addModal"><span class="fa fa-plus-circle"></span> New Banner</button>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="text-center">BANNER PREVIEW</h4>
                            <div class="banner-carousel banner-carousel-1 mb-0">
                                {{-- load dynamic banners  --}}
                                @foreach($banners as $banner)
                                    @if($banner->ban_is_expirable == '1' AND Carbon\Carbon::parse($banner->ban_date_expiry) > Carbon\Carbon::parse(date("Y-m-d")))
                                        <div class="banner-carousel-item" style="background-image:url({{ asset('images/slider-main/' . $banner->ban_image) }})">
                                            <div class="slider-content">
                                                <div class="container h-100">
                                                    <div class="row align-items-center h-100">
                                                        <div class="col-md-12">
                                                            <h3 class="slide-sub-title" data-animation-in="fadeIn">{{ $banner->ban_title }}</h3>
                                                            <h3 class="slide-title" data-animation-in="slideInLeft">{{ $banner->ban_subtitle }}</h3>
                                                            <p data-animation-in="slideInRight">
                                                                @if($banner->ban_show_button_1 == '1')
                                                                    <a href="{{ $banner->ban_button_1_link }}" class="slider btn btn-primary">{{ $banner->ban_button_1_text }}</a>
                                                                @endif
                                                                @if($banner->ban_show_button_2 == '1')
                                                                    <a href="{{ $banner->ban_button_2_link }}" class="slider btn btn-primary border">{{ $banner->ban_button_2_text }}</a>
                                                                @endif
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <div class="banner-carousel-item" style="background-image:url({{ asset('images/slider-main/' . $banner->ban_image) }})">
                                            <div class="slider-content">
                                                <div class="container h-100">
                                                    <div class="row align-items-center h-100">
                                                        <div class="col-md-12">
                                                            <h3 class="slide-sub-title" data-animation-in="fadeIn">{{ $banner->ban_title }}</h3>
                                                            <h3 class="slide-title" data-animation-in="slideInLeft">{{ $banner->ban_subtitle }}</h3>
                                                            <p data-animation-in="slideInRight">
                                                                @if($banner->ban_show_button_1 == '1')
                                                                    <a href="{{ $banner->ban_button_1_link }}" class="slider btn btn-primary">{{ $banner->ban_button_1_text }}</a>
                                                                @endif
                                                                @if($banner->ban_show_button_2 == '1')
                                                                    <a href="{{ $banner->ban_button_2_link }}" class="slider btn btn-primary border">{{ $banner->ban_button_2_text }}</a>
                                                                @endif
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                                
                                {{-- load static banners  --}}
                                <div class="banner-carousel-item" style="background-image:url({{ asset('images/slider-main/bg1.jpg') }})">
                                    <div class="slider-content">
                                        <div class="container h-100">
                                            <div class="row align-items-center h-100">
                                                <div class="col-md-12 text-center">
                                                    <h2 class="slide-title" data-animation-in="slideInLeft">The University of Mindanao</h2>
                                                    <h3 class="slide-sub-title" data-animation-in="slideInRight">QUALITY</h3>
                                                    <h3 class="slide-sub-title" data-animation-in="slideInLeft">AFFORDABLE</h3>
                                                    <h3 class="slide-sub-title" data-animation-in="slideInRight">OPEN EDUCATION</h3>
                                                    <p data-animation-in="slideInRight" data-duration-in="1.2">
                                                        <a href="#" class="slider btn btn-primary">Admission Requirements</a>
                                                        <a href="#" class="slider btn btn-primary border">Registration Guidelines</a>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="banner-carousel-item" style="background-image:url({{ asset('images/slider-main/bg2.jpg') }})">
                                    <div class="slider-content text-left">
                                        <div class="container h-100">
                                            <div class="row align-items-center h-100">
                                                <div class="col-md-12">
                                                    <h2 class="slide-title-box" data-animation-in="slideInDown"></h2>
                                                    <h3 class="slide-sub-title" data-animation-in="fadeIn">Vision</h3>
                                                    <h3 class="slide-title" data-animation-in="slideInLeft">The University of Mindanao envisions to be a leading globally engaged university creating sustainable impact in society.</h3>
                                                    <p data-animation-in="slideInRight">
                                                        <a href="#" class="slider btn btn-primary border">Vision Mission and Values</a>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="banner-carousel-item" style="background-image:url({{ asset('images/slider-main/bg3.jpg') }})">
                                    <div class="slider-content text-right">
                                        <div class="container h-100">
                                            <div class="row align-items-center h-100">
                                                <div class="col-md-12">
                                                    <h2 class="slide-sub-title" data-animation-in="slideInDown">Mission</h2>
                                                    <h3 class="slide-title" data-animation-in="fadeIn"></h3>
                                                    <p class="slider-description lead" data-animation-in="slideInRight">The University of Mindanao seeks to provide a dynamic learning environment through the highest standard of instruction, research, extension, and production in a private non-sectarian institution committed to democratizing access to education.</p>
                                                    <div data-animation-in="slideInLeft">
                                                        <a href="#" class="slider btn btn-primary" aria-label="vision-mission-values">Vision Mission and Values</a>
                                                        <a href="#" class="slider btn btn-primary border" aria-label="legion-of-topnotchers">Legion of Topnotchers</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="banner-carousel-item" style="background-image:url({{ asset('images/slider-main/bg4.jpg') }})">
                                    <div class="slider-content">
                                        <div class="container h-100">
                                            <div class="row align-items-center h-100">
                                                <div class="col-md-12 text-center">
                                                    <h2 class="slide-title" data-animation-in="slideInLeft">Philosophy of education</h2>
                                                    <h3 class="slide-sub-title" data-animation-in="slideInRight">Transformative education through polishing diamonds in the rough.</h3>
                                                    <p data-animation-in="slideInRight" data-duration-in="1.2">
                                                        <a href="#" class="slider btn btn-primary">Vision Mission and Values</a>
                                                        <a href="#" class="slider btn btn-primary border">Legion of Topnotchers</a>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <section class="section">
            <div class="container">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="text-center">BANNERS</h4>    
                            @foreach($banners as $banner)
                                
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <h4 class="card-title">{{ $banner->ban_title }}</h4>
                                        <img class="card-img-top rounded-0" src="{{ asset('images/slider-main/' . $banner->ban_image) }}" alt="{{ $banner->ban_title }}">
                                        <p class="card-text">DISPLAY ORDER: <span class="badge badge-info">{{ $banner->ban_order }}</span></p>
                                        <a class="btn btn-warning" data-toggle="modal" data-target="#editModal-{{ $banner->ban_id }}" href="javascript:void(0)"><span class="fa fa-edit"></span> Edit</a>
                                        <a class="btn btn-danger" href="{{ action('App\Http\Controllers\BannerController@delete',[$banner->ban_id]) }}"><span class="fa fa-trash"></span> Delete</a>
                                    </div>
                                </div>
                                <div id="editModal-{{ $banner->ban_id }}" class="modal fade" role="dialog">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Update Banner</h4>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>
                                            <form method="POST" action="{{ action('App\Http\Controllers\BannerController@update') }}">
                                            {{ csrf_field() }}
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-lg-12 mb-12 mb-lg-0">
                                                            <div class="form-group">
                                                                <label for="ban_title">Title (leave blank if none)</label>
                                                                <input type="text" class="form-control mb-3" id="ban_title" name="ban_title" placeholder="Title" value="{{ $banner->ban_title }}" />
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="ban_subtitle">Subtitle (leave blank if none)</label>
                                                                <input type="text" class="form-control mb-3" id="ban_subtitle" name="ban_subtitle" placeholder="Subtitle" value="{{ $banner->ban_subtitle }}" />
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="ban_order">Order of Appearance</label>
                                                                <input type="number" class="form-control mb-3" id="ban_order" name="ban_order" value="{{ $banner->ban_order }}" min="0" max="100" required/>
                                                            </div>
                                                            <div class="form-group">
                                                                <hr/>
                                                                @if($banner->ban_show_button_1 == '1')
                                                                    <input type="checkbox" class="mb-3" id="ban_show_button_1" name="ban_show_button_1" value="1" checked/> Display Primary Button <br/>
                                                                @else
                                                                    <input type="checkbox" class="mb-3" id="ban_show_button_1" name="ban_show_button_1" value="1"/> Display Primary Button <br/>
                                                                @endif
                                                            </div>
                                                            <div class="form-group">
                                                                <input type="text" class="form-control mb-3" id="ban_button_1_text" name="ban_button_1_text" placeholder="Primary Button Text" value="{{ $banner->ban_button_1_text }}" />
                                                            </div>
                                                            <div class="form-group">
                                                                <input type="text" class="form-control mb-3" id="ban_button_1_link" name="ban_button_1_link" placeholder="Primary Button Hyperlink" value="{{ $banner->ban_button_1_link }}" />
                                                            </div>
                                                            <div class="form-group">
                                                                <hr/>
                                                                @if($banner->ban_show_button_2 == '1')
                                                                    <input type="checkbox" class="mb-3" id="ban_show_button_2" name="ban_show_button_2" value="1" checked/> Display Secondary Button <br/>
                                                                @else
                                                                    <input type="checkbox" class="mb-3" id="ban_show_button_2" name="ban_show_button_2" value="1"/> Display Secondary Button <br/>
                                                                @endif
                                                            </div>
                                                            <div class="form-group">
                                                                <input type="text" class="form-control mb-3" id="ban_button_2_text" name="ban_button_2_text" placeholder="Secondary Button Text" value="{{ $banner->ban_button_2_text }}" />
                                                            </div>
                                                            <div class="form-group">
                                                                <input type="text" class="form-control mb-3" id="ban_button_2_link" name="ban_button_2_link" placeholder="Secondary Button Hyperlink" value="{{ $banner->ban_button_2_link }}" />
                                                            </div>
                                                            <div class="form-group">
                                                                <hr/>
                                                                @if($banner->ban_is_expirable == '1')
                                                                    <input type="checkbox" class="mb-3" id="ban_is_expirable" name="ban_is_expirable" value="1" checked/> Banner Expires <br/>
                                                                @else
                                                                    <input type="checkbox" class="mb-3" id="ban_is_expirable" name="ban_is_expirable" value="1"/> Banner Expires <br/>
                                                                @endif
                                                            </div>
                                                            <div class="form-group">
                                                                <input type="date" class="form-control mb-3" id="ban_date_expiry" name="ban_date_expiry" value="{{ \Carbon\Carbon::parse($banner->ban_date_expiry)->toDateString() }}" required/>
                                                                <hr/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <input type="hidden" name="ban_id" value="{{ $banner->ban_id }}"/>
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-success"><span class="fa fa-save"></span> Save Banner</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <div id="addModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add New Banner</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form method="POST" action="{{ action('App\Http\Controllers\BannerController@save') }}" enctype="multipart/form-data">
                {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12 mb-12 mb-lg-0">
                                <div class="form-group">
                                    <label for="ban_title">Title (leave blank if none)</label>
                                    <input type="text" class="form-control mb-3" id="ban_title" name="ban_title" placeholder="Title" />
                                </div>
                                <div class="form-group">
                                    <label for="ban_subtitle">Subtitle (leave blank if none)</label>
                                    <input type="text" class="form-control mb-3" id="ban_subtitle" name="ban_subtitle" placeholder="Subtitle" />
                                </div>
                                <div class="form-group">
                                    <label for="ban_order">Order of Appearance</label>
                                    <input type="number" class="form-control mb-3" id="ban_order" name="ban_order" value="1" min="0" max="100" required/>
                                </div>
                                <div class="form-group">
                                    <hr/>
                                    <input type="checkbox" class="mb-3" id="ban_show_button_1" name="ban_show_button_1" value="1"/> Display Primary Button <br/>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control mb-3" id="ban_button_1_text" name="ban_button_1_text" placeholder="Primary Button Text" />
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control mb-3" id="ban_button_1_link" name="ban_button_1_link" placeholder="Primary Button Hyperlink" />
                                </div>
                                <div class="form-group">
                                    <hr/>
                                    <input type="checkbox" class="mb-3" id="ban_show_button_2" name="ban_show_button_2" value="1"/> Display Secondary Button <br/>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control mb-3" id="ban_button_2_text" name="ban_button_2_text" placeholder="Secondary Button Text" />
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control mb-3" id="ban_button_2_link" name="ban_button_2_link" placeholder="Secondary Button Hyperlink" />
                                </div>
                                <div class="form-group">    
                                    <hr/>
                                    <input type="checkbox" class="mb-3" id="ban_is_expirable" name="ban_is_expirable" value="1"/> Banner Expires <br/>
                                </div>
                                <div class="form-group">
                                    <input type="date" class="form-control mb-3" id="ban_date_expiry" name="ban_date_expiry" value="{{ \Carbon\Carbon::today()->addDays(30)->toDateString() }}" required/>
                                </div>
                                <div class="form-group">
                                    <hr/>
                                    <input type="file" class="btn btn-default btn-file" id="ban_image" name="ban_image" value="Attach an image" required/>  
                                    <small id="fileHelp" class="form-text text-muted">Allowed file: jpg or png, dimension: 1600 x 800 pixels</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success"><span class="fa fa-save"></span> Save Banner</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection