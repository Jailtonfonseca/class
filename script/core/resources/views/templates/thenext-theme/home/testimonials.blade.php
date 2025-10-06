@extends($activeTheme.'layouts.main')
@section('title', ___('Testimonials'))
@section('content')
    <div id="titlebar">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>{{ ___('Testimonials') }}</h2>
                    <!-- Breadcrumbs -->
                    <nav id="breadcrumbs" class="dark">
                        <ul>
                            <li><a href="{{ route('home') }}">{{ ___('Home') }}</a></li>
                            <li>{{ ___('Testimonials') }}</li>
                        </ul>
                    </nav>

                </div>
            </div>
        </div>
    </div>
    {!! ads_on_top() !!}
    <div class="fullwidth-carousel-container margin-top-20">
        <div class="testimonial-carousel testimonials">
            @foreach($testimonials as $testimonial)
            <div class="single-testimonial">
                <div class="single-inner style-2">
                    <div class="testimonial-content">
                        {{ !empty($testimonial->translations->{get_lang()}->content)
                                         ? $testimonial->translations->{get_lang()}->content
                                         : $testimonial->content }}
                    </div>
                    <div class="author-info">
                        <div class="image">
                            <img class="lazy-load" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsQAAA7EAZUrDhsAAAANSURBVBhXYzh8+PB/AAffA0nNPuCLAAAAAElFTkSuQmCC"  data-original="{{ asset('storage/testimonials/'.$testimonial->image) }}" alt="{{$testimonial->name}}">
                        </div>
                        <h5 class="name">{{$testimonial->name}}</h5>
                        <span class="designation">
                            {{ !empty($testimonial->translations->{get_lang()}->designation)
                                        ? $testimonial->translations->{get_lang()}->designation
                                        : $testimonial->designation }}
                        </span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        {{ $testimonials->links($activeTheme.'pagination/default') }}
    </div>
    {!! ads_on_bottom() !!}
@endsection
