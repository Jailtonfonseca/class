@extends($activeTheme.'layouts.main')
@section('title', $page_title)
@section('content')
    <form method="get" action="{{ route('search.index') }}" name="locationForm" id="ListingForm" accept-charset="UTF-8">
        <div id="titlebar">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h2>{{ ___('We found').' '.$posts->total().' '.___('Ads Listings') }}</h2>
                        <!-- Breadcrumbs -->
                        <nav id="breadcrumbs" class="dark">
                            <ul>
                                <li><a href="{{ route('home') }}">{{ ___('Home') }}</a></li>
                                @if($catTitle != "")
                                    <li>{{ $catTitle }}</li>
                                @endif
                                @if($subCatTitle != "")
                                    <li>{{ $subCatTitle }}</li>
                                @endif
                                @if($category_id == "" and $subcategory_id == "")
                                    <li>{{ ___('All Categories') }}</li>
                                @endif
                            </ul>
                        </nav>

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
                                <input id="keywords" type="text" name="keywords" placeholder="{{ ___('What') }} ?" value="{{ $keywords }}">
                            </div>
                            <div class="intro-search-field with-autocomplete live-location-search">
                                <div class="input-with-icon">
                                    <input type="text" id="searchStateCity" name="location" placeholder="{{ ___('Where') }}">
                                    <i class="la la-map-marker"></i>
                                    <div data-option="{{ @$settings->auto_detect_location }}" class="loc-tracking"><i class="fa fa-crosshairs"></i></div>
                                </div>
                            </div>
                            <div class="intro-search-button">
                                <input type="hidden" name="placetype" id="searchPlaceType" value="">
                                <input type="hidden" name="placeid" id="searchPlaceId" value="">
                                <input type="hidden" id="input-maincat" name="cat" value="{{ $category_id }}"/>
                                <input type="hidden" id="input-subcat" name="subcat" value="{{ $subcategory_id }}"/>
                                <input type="hidden" id="input-filter" name="filter" value="{{ $filter }}"/>
                                <input type="hidden" id="input-sort" name="sort" value="{{ $sort_by }}"/>
                                <input type="hidden" id="input-order" name="order" value="{{ $order_by }}"/>
                                <button class="button ripple-effect">{{ ___('Search') }}</button>
                            </div>
                        </div>

                        <div class="hide-under-768px margin-top-20">
                            <ul class="categories-list">
                                @if($category_id != "")
                                    @foreach(subcategories($category_id) as $subcat)
                                        <li>
                                            <a href="{{ route('search.subcategory', [$category->get_translated_slug(), $subcat->get_translated_slug()]) }}">
                                                {{ $subcat->get_translated_title() }}
                                                <span class="count">({{ $subcat->posts_count }})</span></a>
                                        </li>
                                    @endforeach
                                @else
                                    @foreach($category as $cat)
                                        <li>
                                            <a href="{{ route('search.category', $cat->get_translated_slug()) }}">
                                                {{ $cat->get_translated_title() }}
                                                <span class="count">({{ $cat->posts_count }})</span></a>
                                        </li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {!! ads_on_top() !!}

        <div class="container">
            <div class="row margin-top-30">

                <div class="col-xl-3 col-lg-4">
                    <div class="filter-button-container">
                        <button type="button" class="enable-filters-button">
                            <i class="enable-filters-button-icon"></i>
                            <span class="show-text">{{ ___('Advance Search') }}</span>
                            <span class="hide-text">{{ ___('Advance Search') }}</span>
                        </button>
                    </div>
                    <div class="sidebar-container search-sidebar">

                        @foreach($custom_fields as $field)
                            @php
                                $field_title = $field->get_translated_title();
                            @endphp
                            @if($field->type == "text-field")
                                <div class="sidebar-widget">
                                    <h3 class="label-title">{{ $field_title }}</h3>
                                    <input type="text" class="form-control with-border quick-text"
                                           name="custom[{{ $field->id }}]"
                                           id="custom[{{ $field->id }}]"
                                           value="{{ request()->get('custom')[$field->id] ?? null }}"
                                           placeholder="{{ $field_title }}"
                                           data-name="{{ $field->id }}"
                                           data-req="{{ $field->required }}"/>
                                    <div class="quick-error">{{ ___('This field is required.') }}</div>
                                </div>
                            @endif
                            @if($field->type == "textarea")
                                <div class="sidebar-widget">
                                    <h3 class="label-title">{{ $field_title }}</h3>
                                    <textarea class="materialize-textarea form-control with-border quick-textArea"
                                              name="custom[{{ $field->id }}]"
                                              id="custom[{{ $field->id }}]"
                                              placeholder="{{ $field_title }}"
                                              data-name="{{ $field->id }}"
                                              data-req="{{ $field->required }}">{{ request()->get('custom')[$field->id] ?? null }}</textarea>
                                    <div class="quick-error">{{ ___('This field is required.') }}</div>
                                    <p class="help-block">Html tags are allow.</p>
                                </div>
                            @endif
                            @if($field->type == "drop-down")
                                <div class="sidebar-widget">
                                    <h3 class="label-title">{{ $field_title }}</h3>
                                    <select class="selectpicker with-border" name="custom[{{ $field->id }}]">
                                        <option value="" selected>{{ ___('Select') }} {{ $field_title }}</option>
                                        @foreach(explode(',',$field->options) as $option_id)
                                            @php
                                                $option = get_customOptions_by_id($option_id);
                                            @endphp
                                            @if($option)
                                                <option value="{{ $option_id }}"
                                                @selected($option_id == (request()->get('custom')[$field->id] ?? null))>
                                                    {{ $option->get_translated_title() }}
                                                </option>
                                            @endif
                                        @endforeach

                                    </select>
                                </div>
                            @endif
                            @if($field->type == "radio-buttons")
                                <div class="sidebar-widget">
                                    <h3 class="label-title">{{ $field_title }}</h3>
                                    @foreach(explode(',',$field->options) as $option_id)
                                        @php
                                            $option = get_customOptions_by_id($option_id);
                                        @endphp
                                        @if($option)
                                            <div class="radio radio-primary radio-inline">
                                                <input class="with-gap" type="radio" name="custom[{{ $field->id }}]" id="{{ $option_id }}" value="{{ $option_id }}" data-name="{{ $field->id }}"
                                                    @checked($option_id == (request()->get('custom')[$field->id] ?? null))/>
                                                <label for="{{ $option_id }}"><span class="radio-label"></span>
                                                    {{ $option->get_translated_title() }}
                                                </label>
                                            </div><br>
                                        @endif
                                    @endforeach
                                </div>
                            @endif
                            @if($field->type == "checkboxes")
                                <div class="sidebar-widget">
                                    <h3 class="label-title">{{ $field_title }}</h3>
                                    @foreach(explode(',',$field->options) as $option_id)
                                        @php
                                            $option = get_customOptions_by_id($option_id);
                                        @endphp
                                        @if($option)
                                            <div class="checkbox">
                                                <input type="checkbox" name="custom[{{ $field->id }}][]" id="{{ $option_id }}" value="{{ $option_id }}" data-name="{{ $field->id }}"
                                                    @checked(in_array($option_id,request()->get('custom')[$field->id] ?? []))
                                                />
                                                <label for="{{ $option_id }}"><span class="checkbox-icon"></span>
                                                    {{ $option->get_translated_title() }}
                                                </label>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                        <div class="sidebar-widget">
                            <h3>{{ ___('Price') }}</h3>
                            <div class="range-widget">
                                <div class="range-inputs">
                                    <input type="text" placeholder="{{ ___('From') }}" name="min_price" value="{{ @$min_price }}">
                                    <input type="text" placeholder="{{ ___('To') }}" name="max_price" value="{{ @$max_price }}">
                                </div>
                                <button type="submit" class="button"><i class="icon-feather-arrow-right"></i></button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-9 col-lg-8">

                    <h3 class="page-title">
                        @if(isset($subcategory_id))
                            {{ $subCatTitle }}
                        @elseif(isset($category_id))
                            {{ $catTitle }}
                        @elseif(isset($keywords))
                            {{ ___('Search result for ') }}"{{ $keywords }}"
                        @else
                            {{ ___('All Listings') }}
                        @endif
                    </h3>

                    <div class="notify-box margin-top-15">
                        @php
                            $view = @$settings->listing_view;
                            if(request()->get('view') == "list"){
                                $view = "list";
                            }elseif (request()->get('view') == "grid"){
                                $view = "grid";
                            }
                        @endphp

                        <span class="font-weight-600">{{ $posts->total() }} {{ ___('Ads Listing Found') }}</span>

                        <div class="sort-by">
                            <span>{{ ___('Sort by') }}</span>
                            <select class="selectpicker hide-tick" id="sort-filter" name="sort">
                                <option value="newest" @isset($sort_by) @if ($sort_by == 'newest') selected @endif @endisset>{{ ___('Newest')}}</option>
                                <option value="oldest" @isset($sort_by) @if ($sort_by == 'oldest') selected @endif @endisset>{{ ___('Oldest')}}</option>
                                <option value="price-asc" @isset($sort_by) @if ($sort_by == 'price-asc') selected @endif @endisset>{{ ___('Price low to high')}}</option>
                                <option value="price-desc" @isset($sort_by) @if ($sort_by == 'price-desc') selected @endif @endisset>{{ ___('Price high to low')}}</option>
                                <option value="title-asc" @isset($sort_by) @if ($sort_by == 'title-asc') selected @endif @endisset>{{ ___('Name')}}</option>
                            </select>
                        </div>
                    </div>

                    <div class="listings-container margin-top-35">
                        <!-- Tabs content-->
                        <div class="tab-content py-2" id="myProperty-setting">
                            <!-- Grid View tab-->
                            <div class="tab-pane @if($view == "grid") show active @endif" id="grid-view" role="tabpanel">
                                <!-- Catalog grid-->
                                <div class="row g-4 pb-4">
                                    <!-- Item-->
                                    @if ($posts->count() > 0)
                                        @foreach ($posts as $post)
                                            <div class="col col-xl-4 col-sm-6">
                                                @include($activeTheme.'user.posts.inc.grid-block')
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="clearfix"></div>
                                        <div>{{ ___('Nothing found') }}</div>
                                    @endif
                                </div>
                            </div>
                            <!-- List View tab-->
                            <div class="tab-pane @if($view == "list") show active @endif" id="list-view" role="tabpanel">
                                <!-- Catalog List-->
                                <!-- Item-->
                                @if ($posts->count() > 0)
                                    @foreach ($posts as $post)
                                        @include($activeTheme.'user.posts.inc.list-block')
                                    @endforeach
                                @else
                                    <div class="clearfix"></div>
                                    <div>{{ ___('Nothing found') }}</div>
                                @endif
                            </div>
                        </div>
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

    </form>

    {!! ads_on_bottom() !!}
    @push('scripts_at_bottom')
        <script type="text/javascript">
            $('#sort-filter').on('change', function (e) {
                $('#ListingForm').submit();
            });

            var getMaincatId = @json($category_id);
            var getSubcatId = @json($subcategory_id);

            $(window).bind("load", function () {
                if (getMaincatId != "") {
                    $('li a[data-cat-type="maincat"][data-ajax-id="' + getMaincatId + '"]').trigger('click');
                } else if (getSubcatId != "") {
                    $('li ul li a[data-cat-type="subcat"][data-ajax-id="' + getSubcatId + '"]').trigger('click');
                } else {
                    $('li a[data-cat-type="all"]').trigger('click');
                }
            });
        </script>
    @endpush
@endsection
