@extends($activeTheme.'layouts.app')
@section('title', ___('Favorite Listings'))
@section('active_menu', 'favorite')
@section('content')
    <div class="dashboard-box margin-top-0">
        <!-- Headline -->
        <div class="headline">
            <h3><i class="icon-feather-heart"></i> {{ ___('My Favorite Listings') }}</h3>
        </div>
        @if (!$posts->count())
        <div class="content with-padding text-center">
            {{ ___('Nothing found') }}
        </div>
        @endif
    </div>
    <div class="listings-container margin-top-30">
        @if ($posts->count())
            @foreach ($posts as $post)
                <div class="job-listing fav-listing">
                    <div class="job-listing-details">
                        @php
                            $picture     =   explode(',' ,$post->images);
                            if($picture[0] != ""){
                                $main_picture = $picture[0];
                            }else{
                                $main_picture = "default.png";
                            }
                        @endphp
                        <div class="job-listing-company-logo">
                            <img class="img-whp lazy-load" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsQAAA7EAZUrDhsAAAANSURBVBhXYzh8+PB/AAffA0nNPuCLAAAAAElFTkSuQmCC"  data-original="{{ asset('storage/products/thumb/'.$main_picture) }}" alt="{{ $post->title }}">
                        </div>
                        <div class="job-listing-description">
                            <h4 class="job-listing-company">
                                <ol class="breadcrumb">
                                    <li>
                                        <a href="{{ route('search.category', $post->category->get_translated_slug()) }}"><i class="la la-tags"></i>
                                            {{ $post->category->get_translated_title() }}
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('search.subcategory', [$post->category->get_translated_slug(), $post->sub_category->get_translated_slug()]) }}">
                                            {{ $post->sub_category->get_translated_title() }}
                                        </a>
                                    </li>
                                </ol>
                            </h4>
                            <h3 class="job-listing-title"><a href="{{ route('posts.single', [$post->id,$post->slug]) }}">{{ $post->title }}</a>
                                @if($post->featured == '1') <span class="badge blue"> {{ ___('Featured') }}</span> @endif
                                @if($post->urgent == '1') <span class="badge yellow"> {{ ___('Urgent') }}</span> @endif
                                @if($post->highlight == '1') <span class="badge red"> {{ ___('Highlight') }}</span> @endif
                            </h3>
                            @if($post->custom_field_data->count() > 0)
                                <ul class="prop_details mb0">
                                    @foreach ($post->custom_field_data as $customdata)
                                        @if($customdata->type == 'drop-down' || $customdata->type == 'radio-buttons')
                                            @php
                                                $option = get_customOptions_by_id($customdata->pivot->field_data);
                                            @endphp
                                            @if($option)
                                                <li class="list-inline-item">
                                                    <img src="{{ $customdata->icon }}" width="14"/>
                                                    {{ $customdata->get_translated_title() }}:
                                                    {{ $option->get_translated_title() }}
                                                </li>
                                            @endif

                                        @elseif($customdata->type == 'text-field' || $customdata->type == 'textarea')
                                            <li class="list-inline-item">
                                                <img src="{{ $customdata->icon }}" width="14"/>
                                                {{ $customdata->get_translated_title() }}:
                                                {{ $customdata->pivot->field_data }}
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            @else
                                <ul class="prop_details mb0">
                                    <li class="list-inline-item">
                                        {{ \Illuminate\Support\Str::limit(strip_tags($post->description), 110, $end='...') }}
                                    </li>
                                </ul>
                            @endif
                        </div>
                    </div>
                    <div class="job-listing-footer with-icon">
                        <ul>
                            <li><a href="{{ route('profile', $post->user->username) }}"><i class="la la-user"></i> {{ $post->user->username }}</a></li>
                            <li>
                                <i class="la la-map-marker"></i>
                                {{ @$post->city->name }},
                                {{ @$post->country->name }}
                            </li>
                            @if($post->price != '0')
                                <li><i class="la la-credit-card"></i> {!! price_format_by_country($post->price,$post->country_code) !!}</li>
                            @endif

                            <li><i class="la la-clock-o"></i> {{ date_formating($post->created_at) }}</li>
                        </ul>
                        <span class="fav-icon set-item-fav @if($post->hasFavorite()) added @endif"
                              data-item-id="{{ $post->id }}"
                              data-userid="{{ auth()->user()->id }}"
                              data-action="{{ route('posts.setFavorite') }}">
                        </span>
                    </div>
                </div>
            @endforeach
        @endif

        <!-- Pagination -->
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12">
                <!-- Pagination -->
                <div class="pagination-container margin-top-20">
                    {{ $posts->links($activeTheme.'pagination/default') }}
                </div>
            </div>
        </div>
    </div>
@endsection
