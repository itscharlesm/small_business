<section class="subscribe no-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-sm-12">
                <div class="subscribe-call-to-action">
                    <h3 class="text-white">Search our news</h3>
                    <h4>archives</h4>
                </div>
            </div>

            <div class="col-lg-8 col-sm-12">
                {{-- <div class="ts-newsletter row align-items-center"> --}}
                    <div class="col-md-5 newsletter-introtext">
                        <!-- <h4 class="text-white mb-0">Search News Articles</h4> -->
                        <p class="text-white">Search news articles for specific topic or content</p>
                    </div>
                    <div class="col-md-7 newsletter-form">
                        <form action="{{ action('App\Http\Controllers\NewsController@search') }}" method="post">
                        @csrf
                            <div class="form-group">
                                <label for="news-search" class="content-hidden">Search News</label>
                                <input type="text" name="keyword" id="news-search" class="form-control form-control-lg" placeholder="Enter keyword(s) and hit enter" autocomplete="off">
                            </div>
                        </form>
                    </div>
                {{-- </div> --}}
            </div>
        </div>
    </div>
</section>

<section id="news" class="news">
    <div class="container">
        <div class="row text-center">
            <div class="col-12">
                <h2 class="section-title">News and Events</h2>
                <h3 class="section-sub-title">Recent News</h3>
            </div>
        </div>

        <div class="row">
            @foreach($news as $news_article)
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="latest-post">
                        <div class="latest-post-media">
                            <a href="{{ action('App\Http\Controllers\NewsController@article',[$news_article->news_id]) }}" class="latest-post-img">
                                @if(isset($news_article->news_image))
                                    <img class="rounded mx-auto d-block" height="240px" width="100%" loading="lazy"  src="{{ asset('images/news/' . $news_article->news_image) }}" alt="{{ $news_article->news_title }}">
                                @else
                                    <img class="rounded mx-auto d-block" height="240px" width="100%" loading="lazy" src="{{ asset('images/news/default.png') }}" alt="{{ $news_article->news_title }}">
                                @endif
                            </a>
                        </div>
                        <div class="post-body">
                            <h4 class="post-title">
                                <a href="{{ action('App\Http\Controllers\NewsController@article',[$news_article->news_id]) }}" class="d-inline-block"> {{ $news_article->news_title }} </a>
                            </h4>
                            <div class="latest-post-meta">
                                <span class="post-item-date">
                                    <i class="fa fa-clock-o"></i> {{ $news_article->news_date }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="general-btn text-center mt-4">
            <a class="btn btn-primary" href="{{ action('App\Http\Controllers\NewsController@home') }}">See All News</a>
        </div>
    </div>
</section>
