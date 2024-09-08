<div class="banner-carousel banner-carousel-1 mb-0">
    {{-- load dynamic banners  --}}
    @foreach($banners as $banner)
        @if($banner->ban_is_expirable == '1' AND Carbon\Carbon::parse($banner->ban_date_expiry) > Carbon\Carbon::parse(date("Y-m-d")))
            <div class="banner-carousel-item" style="background-image:url({{ asset('images/slider/' . $banner->ban_image) }})">
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
            <div class="banner-carousel-item" style="background-image:url({{ asset('images/slider/' . $banner->ban_image) }})">
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
    <div class="banner-carousel-item" style="background-image:url({{ asset('images/slider/bg0.jpg') }})">
        <div class="slider-content">
            <div class="container h-100">
                <div class="row align-items-center h-100">
                    <div class="col-md-12 text-center">
                        {{-- <h2 class="slide-sub-title" data-animation-in="slideInLeft">SALIKLAKBAY APP ANDROID USERS</h2>
                        <h3 class="slide-title" data-animation-in="slideInRight">IS NOW AVAILABLE </h3>
                        <h3 class="slide-title" data-animation-in="slideInLeft">FOR DOWNLOAD</h3> --}}
                        {{-- <p data-animation-in="slideInRight" data-duration-in="1.2">
                            <a class="slider btn btn-primary" href="javascript:void(0)" data-toggle="modal" data-target="#reportInnovationModal" target="_BLANK" rel="noopener noreferrer">
                                <span class="fa fa-download"></span> Download the App
                            </a> --}}
                            {{-- <a href="{{ action('App\Http\Controllers\InnovationController@main') }}" class="slider btn btn-primary border">View Innovations</a> --}}
                        {{-- </p> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="banner-carousel-item" style="background-image:url({{ asset('images/slider/bg1.jpg') }})">
        <div class="slider-content">
            <div class="container h-100">
                <div class="row align-items-center h-100">
                    <div class="col-md-12 text-center">
                        <h2 class="slide-sub-title" data-animation-in="slideInLeft">Affordable</h2>
                        <h3 class="slide-title" data-animation-in="slideInRight">Cloud-Based </h3>
                        <h3 class="slide-title" data-animation-in="slideInLeft">SMS Text Solution</h3>
                        {{-- <p data-animation-in="slideInRight" data-duration-in="1.2">
                            <a class="slider btn btn-primary" href="javascript:void(0)" data-toggle="modal" data-target="#reportInnovationModal" target="_BLANK" rel="noopener noreferrer">
                                Submit Innovation
                            </a>
                            <a href="{{ action('App\Http\Controllers\InnovationController@main') }}" class="slider btn btn-primary border">View Innovations</a>
                        </p> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="banner-carousel-item" style="background-image:url({{ asset('images/slider/bg2.jpg') }})">
        <div class="slider-content text-left">
            <div class="container h-100">
                <div class="row align-items-center h-100">
                    <div class="col-md-12">
                        <h2 class="slide-title-box" data-animation-in="slideInDown"></h2>
                        <h3 class="slide-sub-title" data-animation-in="fadeIn">Developed by Infinit Solutions</h3>
                        <h3 class="slide-title" data-animation-in="slideInLeft">Infinit Solutions is a leading innovative information solutions provider that has extensive experience in developing information systems.</h3>
                        <p data-animation-in="slideInRight">
                            <a href="https://www.infinitwebsolutions.com" class="slider btn btn-primary border" target="_blank">Visit Website</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- <div class="banner-carousel-item" style="background-image:url({{ asset('images/slider/bg3.jpg') }})">
        <div class="slider-content text-right">
            <div class="container h-100">
                <div class="row align-items-center h-100">
                    <div class="col-md-12">
                        <h2 class="slide-sub-title" data-animation-in="slideInDown">SALIKLAKBAY</h2>
                        <h3 class="slide-title" data-animation-in="fadeIn"></h3>
                        <p class="slider-description lead" data-animation-in="slideInRight">-a combination of the words ‘Saliksik’ (to explore/ research) and ‘Lakbay’ (to journey/go in an adventure), aims to equip participants with background knowledge, skills and practical experience in conducting solutions mapping in grassroots communities.</p>
                        <div data-animation-in="slideInLeft">
                            <a class="slider btn btn-primary" href="javascript:void(0)" data-toggle="modal" data-target="#reportInnovationModal" target="_BLANK" rel="noopener noreferrer">
                                Submit Innovation
                            </a>
                            <a href="{{ action('App\Http\Controllers\InnovationController@main') }}" class="slider btn btn-primary border" aria-label="legion-of-topnotchers">View Innovations</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
</div>
{{-- 
<section class="call-to-action-box no-padding">
    <div class="container">
        <div class="action-style-box">
            <div class="row align-items-center">
                <div class="col-md-8 text-center text-md-left">
                    <div class="call-to-action-text">
                        <h3 class="action-title">Saliklakbay app for Android users is now available for download.</h3>
                    </div>
                </div>
                <div class="col-md-4 text-center text-md-right mt-3 mt-md-0">
                    <div class="call-to-action-btn">
                        <a class="btn btn-dark" target="_blank" href="{{ action('App\Http\Controllers\MainController@downloadAndroid') }}"><span class="fa fa-download"></span> Download</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section> --}}
