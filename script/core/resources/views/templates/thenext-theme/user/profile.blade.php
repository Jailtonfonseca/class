@extends($activeTheme.'layouts.main')
@section('title', $user->username.' '.___('Profile'))
@section('content')
    <div id="titlebar">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="agent agent-page long-content">
                        <div class="agent-avatar">
                            <img class="lazy-load" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsQAAA7EAZUrDhsAAAANSURBVBhXYzh8+PB/AAffA0nNPuCLAAAAAElFTkSuQmCC"  data-original="{{ asset('storage/profile/'.$user->image) }}" alt="{{ $user->name }}">
                        </div>

                        <div class="agent-content">
                            <div class="agent-name">
                                <h4>{{ $user->name }}</h4>
                                <span>{{ $user->username }}</span>
                            </div>
                            <div class="agent-about">{{ $user->about }}</div>
                            <ul class="agent-contact-details">
                                @if($user->address)
                                    <li><i class="icon-feather-map-pin"></i><a href="https://maps.google.com/?q={{ $user->address }}" target="_blank" rel="nofollow">{{ $user->address }}</a></li>
                                @endif
                                @if($user->phone)
                                    <li class="tg-btnphone"><i class="icon-feather-phone-call"></i><span data-last="{{ $user->phone }}"><a href="tel:{{ $user->phone }}" rel="nofollow"><em>{{ ___('Show Phone No') }}</em></a></span>
                                    </li>
                                @endif
                                @if($user->email)
                                    <li class="tg-btnphone"><i class="icon-feather-mail"></i><span data-last="{{ $user->email }}"><a href="mailto:{{ $user->email }}" rel="nofollow"><em>{{ ___('Show Email') }}</em></a></span></li>
                                @endif
                                @if($user->website)
                                    <li><i class="icon-feather-globe"></i><a href="{{ $user->website }}" target="_blank" rel="nofollow">{{ $user->website }}</a></li>
                                @endif
                            </ul>

                            <div class="freelancer-socials margin-top-25">
                                <ul>
                                    @if($user->facebook) <li><a href="{{ $user->facebook }}" target="_blank" class="facebook"><i class="la la-facebook"></i></a></li>@endif
                                    @if($user->twitter) <li><a href="{{ $user->twitter }}" target="_blank" class="twitter"><i class="la la-twitter"></i></a></li>@endif
                                    @if($user->google) <li><a href="{{ $user->google }}" target="_blank" class="google"><i class="la la-pinterest"></i></a></li>@endif
                                    @if($user->linkden) <li><a href="{{ $user->linkden }}" target="_blank" class="linkden"><i class="la la-linkedin"></i></a></li>@endif
                                    @if($user->instagram) <li><a href="{{ $user->instagram }}" target="_blank" class="instagram"><i class="la la-instagram"></i></a></li>@endif
                                    @if($user->youtube) <li><a href="{{ $user->youtube }}" target="_blank" class="youtube"><i class="la la-youtube"></i></a></li>@endif
                                </ul>
                                <!--end social-->
                            </div>

                            <div class="clearfix"></div>
                        </div>

                    </div>
                </div>
                <div class="col-md-12">
                    <h2>{{ ___('We found').' '.$user->posts->count().' '.___('Ads Listings') }}</h2>
                    <form method="get" action="{{ route('search.index') }}" name="locationForm" id="ListingForm" accept-charset="UTF-8">
                        @csrf
                        <div class="intro-banner-search-form listing-page margin-top-30">
                        <!-- Search Field -->
                        <div class="intro-search-field">
                            <div class="dropdown category-dropdown">
                                <a data-toggle="dropdown" href="#">
                                    <span class="change-text"><i class="fa fa-th"></i>{{ ___('Select Category') }}</span><i class="fa fa-navicon"></i>
                                </a>
                                <ul class="dropdown-menu category-change" id="category-change">
                                    <li><a href="#" class="no-arrow" data-cat-type="all"><i class="fa fa-th"></i>{{ ___('All Categories') }}</a></li>
                                    @foreach(categories() as $cat)
                                        <li>
                                            <a href="#" data-ajax-id="{{ $cat->id }}" data-cat-type="maincat">
                                                @if($cat->picture != "")
                                                    <img src="{{ $cat->picture }}" style="width: 20px;">
                                                @else
                                                    <i class="{{ $cat->icon }}"></i>
                                                @endif
                                                {{ $cat->get_translated_title() }}

                                            </a>
                                            <span class="dropdown-arrow"><i class="fa fa-angle-right"></i></span>
                                            <ul>
                                                @foreach(subcategories($cat->id) as $subcat)
                                                    <li>
                                                        <a href="#" data-ajax-id="{{ $subcat->id }}" data-cat-type="subcat">{{ $subcat->get_translated_title() }}
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>

                        <div class="intro-search-field">
                            <input id="keywords" type="text" name="keywords" placeholder="{{ ___('What') }} ?">
                        </div>
                        <div class="intro-search-field with-autocomplete live-location-search">
                            <div class="input-with-icon">
                                <input type="text" id="searchStateCity" name="location" placeholder="{{ ___('Where') }}">
                                <i class="la la-map-marker"></i>
                                <div data-option="{{ @$settings->auto_detect_location }}" class="loc-tracking"><i class="fa fa-crosshairs"></i></div>
                                <input type="hidden" name="placetype" id="searchPlaceType" value="">
                                <input type="hidden" name="placeid" id="searchPlaceId" value="">
                                <input type="hidden" id="input-maincat" name="cat"/>
                                <input type="hidden" id="input-subcat" name="subcat"/>
                                <input type="hidden" id="input-filter" name="filter"/>
                                <input type="hidden" id="input-sort" name="sort"/>
                                <input type="hidden" id="input-order" name="order"/>
                            </div>
                        </div>
                        <div class="intro-search-button">
                            <button class="button ripple-effect">{{ ___('Search') }}</button>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="container margin-bottom-60">
        <div class="row">
            <div class="col-md-12">
                <h3 class="page-title">{{ ___('Search Results') }}</h3>
                <div class="notify-box margin-top-15">
                    <span class="font-weight-600">{{ ___('We Found') }} {{ $user->posts->count() }} {{ ___('Listings') }}</span>

                    <div class="sort-by">
                        <span>{{ ___('Sort by') }}</span>
                        <select form="ListingForm" class="selectpicker hide-tick" id="sort-filter" name="sort">
                            <option value="newest" @isset($sort_by) @if ($sort_by == 'newest') selected @endif @endisset>{{ ___('Newest')}}</option>
                            <option value="oldest" @isset($sort_by) @if ($sort_by == 'oldest') selected @endif @endisset>{{ ___('Oldest')}}</option>
                            <option value="price-asc" @isset($sort_by) @if ($sort_by == 'price-asc') selected @endif @endisset>{{ ___('Price low to high')}}</option>
                            <option value="price-desc" @isset($sort_by) @if ($sort_by == 'price-desc') selected @endif @endisset>{{ ___('Price high to low')}}</option>
                            <option value="title-asc" @isset($sort_by) @if ($sort_by == 'title-asc') selected @endif @endisset>{{ ___('Name')}}</option>
                        </select>
                    </div>
                </div>

                <div class="listings-container margin-top-35">
                    @if ($posts->count() > 0)
                        @foreach($posts as $post)
                            <div class="job-listing @if($post->highlight == '1') highlight @endif">
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

                                        <h3 class="job-listing-title"><a href="{{ route('posts.single', [$post->id,$post->slug]) }}">{{ $post->title }}</a>
                                            @if($post->featured == '1') <span class="badge blue"> {{ ___('Featured') }}</span> @endif
                                            @if($post->urgent == '1') <span class="badge yellow"> {{ ___('Urgent') }}</span> @endif
                                            @if($post->highlight == '1') <span class="badge red"> {{ ___('Highlight') }}</span> @endif
                                        </h3>
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
                                            <div>
                                                <a class="locationStorage" href="#" data-id="{{ @$post->city->id }}" data-name="{{ @$post->city->name }}" data-type="city">
                                                    <i class="la la-map-marker"></i>
                                                    {{ @$post->city->name }},
                                                    {{ @$post->country->name }}
                                                </a>
                                            </div>
                                        @endif
                                    </div>

                                </div>
                                <div class="job-listing-footer">
                                    <ul>
                                        <li><a href="{{ route('profile', $post->user->username) }}"><i class="la la-user"></i> {{ $post->user->username }}</a></li>
                                        <li><i class="la la-map-marker"></i>
                                            {{ @$post->city->name }},
                                            {{ @$post->country->name }}
                                        </li>

                                        @if($post->price != '0')
                                            <li><i class="la la-credit-card"></i> {!! price_format_by_country($post->price,$post->country_code) !!}</li>
                                        @endif

                                        <li><i class="la la-clock-o"></i> {{ date_formating($post->created_at) }}</li>
                                    </ul>
                                </div>
                            </div>
                        @endforeach
                        <div class="clearfix"></div>
                    @else
                        <div>{{ ___('Nothing found') }}</div>
                    @endif
                    <div class="row">
                        <div class="col-md-12">
                            <!-- Pagination -->
                            <div class="pagination-container margin-top-20 margin-bottom-60">
                                {{ $posts->links($activeTheme.'pagination/default') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts_at_bottom')
        <script type="text/javascript">
            $('#sort-filter').on('change', function (e) {
                $('#ListingForm').submit();
            });
        </script>
    @endpush
@endsection
