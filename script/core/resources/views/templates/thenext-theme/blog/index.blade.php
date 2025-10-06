@extends($activeTheme.'layouts.main')
@section('title', $title ?? ___('Blog'))
@section('content')
    <div id="titlebar" class="white margin-bottom-30">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>{{ $title ?? ___('Blog') }}</h2>
                    <span>{{ ___('Recent Blog') }}</span>
                    <!-- Breadcrumbs -->
                    <nav id="breadcrumbs" class="dark">
                        <ul>
                            <li><a href="{{ route('home') }}">{{ ___('Home') }}</a></li>
                            <li><a href="{{ route('blog.index') }}">{{ ___('Blog') }}</a></li>
                        </ul>
                    </nav>

                </div>
            </div>
        </div>
    </div>
    {!! ads_on_top() !!}
    <div class="section gray">
        <div class="container">
            <div class="row">
                <div class="col-xl-8 col-lg-8">

                    <!-- Section Headline -->
                    <div class="section-headline margin-top-60 margin-bottom-35">
                        <h4>{{ ___('Recent Blog') }}</h4>
                    </div>

                    @if ($blogs->count() > 0)
                        <div class="listings-container grid-layout">
                            @foreach ($blogs as $blog)
                            <div class="job-listing blog-listing">
                                <div class="job-listing-details">
                                    @if($settings->blog_banner)
                                    <div class="job-listing-company-logo">
                                        <a href="{{ route('blog.single', [$blog->id, $blog->slug]) }}">
                                            <img class="lazy-load" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsQAAA7EAZUrDhsAAAANSURBVBhXYzh8+PB/AAffA0nNPuCLAAAAAElFTkSuQmCC"  data-original="{{ asset('storage/blog/'.$blog->image) }}" alt="{{ $blog->title }}">
                                        </a>
                                    </div>
                                    @endif
                                    <div class="job-listing-description">
                                        <div class="blog-cat">
                                            @php
                                                $categories = [];
                                                foreach ($blog->categories as $category){
                                                   $categories[] = $category->title;
                                                }
                                            @endphp
                                            {{ implode(', ', $categories) }}
                                        </div>
                                        <h3 class="job-listing-title"><a href="{{ route('blog.single', [$blog->id, $blog->slug]) }}">{{ $blog->title }}</a></h3>

                                        <p class="job-listing-text margin-top-10">
                                            {{ text_shorting(strip_tags($blog->description), 100) }}
                                        </p>
                                    </div>
                                </div>
                                <div class="job-listing-footer">
                                    <ul>
                                        <li><img src="{{ asset('storage/profile/'.$blog->user->image) }}"
                                                 class="author-avatar"> {{ ___('By') }} <a href="{{ route('profile', $blog->user->username) }}">{{ $blog->user->name }}</a></li>
                                        <li><i class="la la-clock-o"></i> {{ $blog->created_at->diffForHumans() }}</li>
                                    </ul>
                                </div>
                            </div>
                            @endforeach
                            <div class="clearfix"></div>
                            {{ $blogs->links($activeTheme.'pagination/default') }}
                        </div>
                    @else
                        <div class="blog-not-found">
                            <h2><span>:</span>(</h2>
                            <p>
                                {{ ___('Sorry, we could not found the blog you are looking for!') }}
                            </p>
                        </div>
                    @endif
                </div>

                @include($activeTheme.'blog.sidebar', ['margin' => true])
            </div>
        </div>

        <!-- Spacer -->
        <div class="padding-top-40"></div>
        <!-- Spacer -->
    </div>

    {!! ads_on_top() !!}
@endsection
