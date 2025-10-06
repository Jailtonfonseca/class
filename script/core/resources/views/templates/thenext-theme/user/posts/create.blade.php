@extends($activeTheme.'layouts.main')
@section('title', ___('Post ad'))
@section('content')
    <div id="titlebar" class="margin-bottom-0">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>{{ ___('Post An Advertise') }}</h2>
                    <!-- Breadcrumbs -->
                    <nav id="breadcrumbs">
                        <ul>
                            <li><a href="{{ route('home') }}">{{ ___('Home') }}</a></li>
                            <li>{{ ___('Post An Advertise') }}</li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- Select Category Modal -->
    <div class="zoom-anim-dialog mfp-hide popup-dialog big-dialog" id="categoryModal">
        <div class="popup-tab-content padding-0 tg-thememodal tg-categorymodal">
            <div class="tg-thememodaldialog">
                <div class="tg-thememodalcontent">
                    <div class="tg-title">
                        <strong>{{ ___('Select Category') }}</strong>
                    </div>
                    <div id="tg-dbcategoriesslider" class="tg-dbcategoriesslider tg-categories owl-carousel select-category post-option">
                        @foreach(categories() as $cat)
                            <div class="tg-category" data-ajax-catid="{{ $cat->id }}" data-ajax-action="{{ route('posts.getsubcatbyidList') }}" data-cat-name="{{ $cat->get_translated_title() }}">
                                <div class="tg-categoryholder">
                                    <div class="margin-bottom-10">
                                        @if($cat->picture != "")
                                            <img src="{{ $cat->picture }}">
                                        @else
                                            <i class="{{ $cat->icon }}"></i>
                                        @endif
                                    </div>
                                    <h3><a href="javascript:void()">{{ $cat->get_translated_title() }}</a></h3>
                                </div>
                            </div>
                        @endforeach

                    </div>
                    <ul class="tg-subcategories" style="display: none">
                        <li>
                            <div class="tg-title">
                                <strong>{{ ___('Select a subcategory') }}</strong>
                                <div id="sub-category-loader" style="visibility:hidden"></div>
                            </div>
                            <div class=" tg-verticalscrollbar tg-dashboardscrollbar">
                                <ul id="sub_category">

                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- Select Category Modal -->
    <div class="section gray">
        <div class="container">
            <div class="row">
                <div class="col-xl-8 col-md-12">
                    <div id="post_error"></div>
                    <div class="payment-confirmation-page dashboard-box margin-top-0 padding-top-0 margin-bottom-50" style="display: none">
                        <div class="headline">
                            <h3>{{ ___('Success') }}</h3>
                        </div>
                        <div class="content with-padding padding-bottom-10">
                            <i class="la la-check-circle"></i>
                            <h1 class="margin-top-30 margin-bottom-30">{{ ___('Success') }}</h1>
                            <p>{{ ___('Your listing succussfully uploaded. Please wait for approval. Thanks') }}</p>
                        </div>
                    </div>
                    <form class="form-validate" id="post-advertise-form" action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data" accept-charset="UTF-8">
                        @csrf
                        <div class="dashboard-box margin-top-0">
                            <!-- Headline -->
                            <div class="headline">
                                <h3><i class="icon-feather-briefcase"></i> {{ ___('Listing Details') }}</h3>
                            </div>
                            <div class="content with-padding padding-bottom-10">
                                <div class="row">
                                    <div class="col-xl-12">
                                        <div class="form-group text-center">
                                            <a href="#categoryModal" id="choose-category" class="button popup-with-zoom-anim"><i class="icon-feather-check-circle"></i> &nbsp;{{ ___('Choose Category') }}</a>
                                        </div>
                                        <div class="form-group selected-product" id="change-category-btn" style='display: none'>
                                            <ul class="select-category list-inline">
                                                <li id="main-category-text"></li>
                                                <li id="sub-category-text"></li>
                                                <li class="active"><a href="#categoryModal" class="popup-with-zoom-anim"><i class="icon-feather-edit"></i> {{ ___('Edit') }}</a></li>
                                            </ul>

                                            <input type="hidden" id="input-maincatid" name="category" value="">
                                            <input type="hidden" id="input-subcatid" name="sub_category" value="">
                                        </div>
                                        <div class="submit-field">
                                            <h5>{{ ___('Title') }} *</h5>
                                            <input type="text" class="with-border" name="title" placeholder="{{ ___('Title for your listing') }}">
                                        </div>
                                        <div class="submit-field">
                                            <h5>{{ ___('Description') }} *</h5>
                                            <textarea cols="30" rows="5" class="with-border text-editor" name="description" placeholder="{{ ___('Tell us more about your listing') }}"></textarea>
                                        </div>
                                        <div class="submit-field" id="quickad-photo-field">
                                            <h5>{{ ___('Upload Images') }}</h5>
                                            <input type="file"
                                                   class="quickImageUpload"
                                                   name="image[]"
                                                   multiple
                                                   data-allow-reorder="true"
                                                   data-max-file-size="3MB"
                                                   data-max-files="{{ @$settings->max_image_upload }}">
                                        </div>
                                        <div id="ResponseCustomFields" class="submit-field">
                                            @if(count($custom_fields))
                                                @foreach($custom_fields as $field)
                                                    @php
                                                        $field_title = $field->get_translated_title();
                                                    @endphp
                                                    @if($field->type == "text-field")
                                                        <div class="submit-field">
                                                            <h5 class="label-title">{{ $field_title }}</h5>
                                                            <input type="text" class="form-control with-border quick-text"
                                                                   name="custom[{{ $field->id }}]"
                                                                   id="custom[{{ $field->id }}]"
                                                                   value="{{ $field->default }}"
                                                                   placeholder="{{ $field_title }}"
                                                                   data-name="{{ $field->id }}"
                                                                   data-req="{{ $field->required }}"/>
                                                            <div class="quick-error">{{ ___('This field is required.') }}</div>
                                                        </div>
                                                    @endif
                                                    @if($field->type == "textarea")
                                                        <div class="submit-field">
                                                            <h5 class="label-title">{{ $field_title }}</h5>
                                                            <textarea class="materialize-textarea form-control with-border quick-textArea"
                                                                      name="custom[{{ $field->id }}]"
                                                                      id="custom[{{ $field->id }}]"
                                                                      placeholder="{{ $field_title }}"
                                                                      data-name="{{ $field->id }}"
                                                                      data-req="{{ $field->required }}">{{ $field->default }}</textarea>
                                                            <div class="quick-error">{{ ___('This field is required.') }}</div>
                                                            <p class="help-block">Html tags are allow.</p>
                                                        </div>
                                                    @endif
                                                    @if($field->type == "drop-down")
                                                        <div class="submit-field">
                                                            <h5 class="label-title">{{ $field_title }}</h5>
                                                            <select class="selectpicker with-border" name="custom[{{ $field->id }}]">
                                                                <option value="" selected>{{ ___('Select') }} {{ $field_title }}</option>
                                                                @foreach(explode(',',$field->options) as $option_id)
                                                                    @php
                                                                        $option = get_customOptions_by_id($option_id);
                                                                    @endphp
                                                                    @if($option)
                                                                        <option value="{{ $option_id }}">{{ $option->get_translated_title() }}</option>
                                                                    @endif
                                                                @endforeach

                                                            </select>
                                                        </div>
                                                    @endif
                                                    @if($field->type == "radio-buttons")
                                                        <div class="submit-field">
                                                            <h5 class="label-title">{{ $field_title }}</h5>
                                                            @foreach(explode(',',$field->options) as $option_id)
                                                                @php
                                                                    $option = get_customOptions_by_id($option_id);
                                                                @endphp
                                                                @if($option)
                                                                    <div class="radio radio-primary radio-inline">
                                                                        <input class="with-gap" type="radio" name="custom[{{ $field->id }}]" id="{{ $option_id }}" value="{{ $option_id }}" data-name="{{ $field->id }}" />
                                                                        <label for="{{ $option_id }}"><span class="radio-label"></span>
                                                                            {{ $option->get_translated_title() }}
                                                                        </label>
                                                                    </div><br>
                                                                @endif
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                    @if($field->type == "checkboxes")
                                                        <div class="submit-field">
                                                            <h5 class="label-title">{{ $field_title }}</h5>
                                                            @foreach(explode(',',$field->options) as $option_id)
                                                                @php
                                                                    $option = get_customOptions_by_id($option_id);
                                                                @endphp
                                                                @if($option)
                                                                    <div class="checkbox">
                                                                        <input type="checkbox" name="custom[{{ $field->id }}][]" id="{{ $option_id }}" value="{{ $option_id }}" data-name="{{ $field->id }}" />
                                                                        <label for="{{ $option_id }}"><span class="checkbox-icon"></span>
                                                                            {{ $option->get_translated_title() }}
                                                                        </label>
                                                                    </div>
                                                                @endif
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </div>
                                        <div class="submit-field" id="quickad-price-field">
                                            <h5>{{ ___('Price') }}</h5>
                                            <div class="row">
                                                <div class="col-xl-6 col-md-12">
                                                    <div class="input-with-icon">
                                                        <input class="with-border" type="text" placeholder="{{ ___('Price') }}" name="price">
                                                        <i class="currency">{{ $currency->code }}</i>
                                                    </div>
                                                </div>
                                                <div class="col-xl-6 col-md-12 margin-top-12">
                                                    <div class="checkbox">
                                                        <input type="checkbox" id="negotiable" name="negotiable" value="1">
                                                        <label for="negotiable"><span class="checkbox-icon"></span> {{ ___('Negotiable') }}</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="submit-field">
                                            <h5>{{ ___('Phone Number') }}</h5>
                                            <div class="row">
                                                <div class="col-xl-6 col-md-12">
                                                    <div class="input-with-icon-left">
                                                        <i class="flag-img"><img src="{{ asset('assets/global/plugins/flags/images/') }}/{{ strtolower($session_country) }}.png"></i>
                                                        <input type="text" class="with-border" name="phone">
                                                    </div>
                                                </div>
                                                <div class="col-xl-6 col-md-12">
                                                    <div class="checkbox margin-top-12">
                                                        <input type="checkbox" name="hide_phone" id="phone" value="1">
                                                        <label for="phone"><span class="checkbox-icon"></span> {{ ___('Hide') }}</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="submit-field">
                                            <h5>{{ ___('City') }} *</h5>
                                            <select id="jobcity" data-action="searchCityFromCountry" class="with-border" name="city" data-size="7" title="{{ ___('Select City') }}">
                                                <option value="" selected="selected">{{ ___('Select City') }}</option>
                                            </select>
                                        </div>
                                        <!-- Location -->

                                        @if(@$settings->post_address_mode)
                                            <div class="submit-field">
                                                <h5>{{ ___('Address') }}</h5>
                                                <div class="input-with-icon">
                                                    <div id="autocomplete-container" data-autocomplete-tip="{{ ___('type and hit enter') }}">
                                                        <input class="with-border" type="text" placeholder="{{ ___('Address') }}" name="location" id="address-autocomplete">
                                                    </div>
                                                    <div class="geo-location"><i class="la la-crosshairs"></i></div>
                                                </div>
                                                <div class="map shadow" id="singleListingMap" data-latitude="{{ $latitude }}" data-longitude="{{ $longitude }}"  style="height: 200px" data-map-icon="map-marker"></div>
                                                <small class="d-none">{{ ___('Drag the map marker to exact address') }}</small>
                                                <input type="hidden" id="latitude" name="latitude" value="{{ $latitude }}"/>
                                                <input type="hidden" id="longitude" name="longitude" value="{{ $longitude }}"/>
                                            </div>
                                        @endif
                                        @if(@$settings->post_tags_mode)
                                        <div class="submit-field form-group">
                                            <h5>{{ ___('Tags') }}</h5>
                                            <input class="with-border" type="text" name="tags">
                                            <small>{{ ___('Enter the tags separated by commas.') }}</small>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        @guest
                            <div class="dashboard-box">
                            <!-- Headline -->
                            <div class="headline">
                                <h3><i class="icon-feather-user"></i> {{ ___('User Details') }}</h3>
                            </div>
                            <div class="content with-padding padding-bottom-10">
                                <div class="row">
                                    <div class="col-xl-6 col-md-12">
                                        <div class="submit-field">
                                            <h5>{{ ___('Full Name') }} *</h5>
                                            <div class="input-with-icon-left">
                                                <i class="la la-user"></i>
                                                <input type="text" class="with-border" name="seller_name">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-md-12">
                                        <div class="submit-field">
                                            <h5>{{ ___('username') }} *</h5>
                                            <div class="input-with-icon-left">
                                                <i class="la la-user"></i>
                                                <input type="text" class="with-border" name="seller_username">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-md-12">
                                        <div class="submit-field">
                                            <h5>{{ ___('Email') }} *</h5>
                                            <div class="input-with-icon-left">
                                                <i class="la la-envelope"></i>
                                                <input type="email" class="with-border" name="seller_email">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-md-12">
                                        <div class="submit-field">
                                            <h5>{{ ___('Password') }} *</h5>
                                            <div class="input-with-icon-left">
                                                <i class="la la-envelope"></i>
                                                <input type="password" class="with-border" name="seller_password">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endguest

                        @if(@$settings->post_premium_listing)
                            <div class="dashboard-box">
                            <div class="headline">
                                <h3><i class="icon-feather-zap"></i> {{ ___('Make your listing premium') }} <small>({{ ___('Optional') }})</small></h3>
                            </div>
                            <div class="content with-padding">
                                <div class="payment">

                                    <div class="payment-tab payment-tab-active">
                                        <div class="payment-tab-trigger">
                                            <input checked id="free" name="make_premium" type="radio" value="0">
                                            <label for="free">{{ ___('Free Listing') }}</label>
                                        </div>
                                        <div class="payment-tab-content">
                                            <p>{{ ___('Your ad will go live after check by reviewer.') }}</p>
                                        </div>
                                    </div>

                                    <div class="payment-tab">
                                        <div class="payment-tab-trigger">
                                            <input type="radio" name="make_premium" id="make_premium" value="1">
                                            <label for="make_premium">{{ ___('Premium') }} <span class="badge green pull-right">{{ ___('Recommended') }}</span></label>
                                        </div>

                                        <div class="payment-tab-content">
                                            <p>{{ ___('You can optionally select some upgrades to get the best results.') }}</p>
                                            <div class="row premium-plans">
                                                <div class="col-lg-3">
                                                    <div class="checkbox">
                                                        <input type="checkbox" id="featured" name="featured" value="1" onchange="fillPrice(this,{{ $plan->settings->featured_project_fee }});">
                                                        <label for="featured"><span class="checkbox-icon"></span> <span class="badge blue">{{ ___('Featured') }}</span></label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 premium-plans-text">
                                                    {{ ___('Featured ads attract higher-quality viewer and are displayed prominently in the Featured ads section home page.') }}
                                                </div>
                                                <div class="col-lg-3 premium-plans-price">
                                                    {{ price_symbol_format($plan->settings->featured_project_fee) }}
                                                </div>
                                            </div>
                                            <div class="row premium-plans">
                                                <div class="col-lg-3">
                                                    <div class="checkbox">
                                                        <input type="checkbox" id="urgent" name="urgent" value="1" onchange="fillPrice(this,{{ $plan->settings->urgent_project_fee }});">
                                                        <label for="urgent"><span class="checkbox-icon"></span> <span class="badge yellow">{{ ___('Urgent') }}</span></label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 premium-plans-text">
                                                    {{ ___('Make your ad stand out and let viewer know that your advertise is time sensitive.') }}
                                                </div>
                                                <div class="col-lg-3 premium-plans-price">
                                                    {{ price_symbol_format($plan->settings->urgent_project_fee) }}
                                                </div>
                                            </div>
                                            <div class="row premium-plans">
                                                <div class="col-lg-3">
                                                    <div class="checkbox">
                                                        <input type="checkbox" id="highlight" name="highlight" value="1" onchange="fillPrice(this,{{ $plan->settings->highlight_project_fee }});">
                                                        <label for="highlight"><span class="checkbox-icon"></span> <span class="badge red">{{ ___('Highlight') }}</span></label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 premium-plans-text">
                                                    {{ ___('Make your ad highlighted with border in listing search result page. Easy to focus.') }}
                                                </div>
                                                <div class="col-lg-3 premium-plans-price">
                                                    {{ price_symbol_format($plan->settings->urgent_project_fee) }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        @endif
                        <input type="hidden" name="submit">
                        <div class="form-group margin-top-30 margin-bottom-15">
                            <div class="text-center">
                                {!! display_captcha() !!}
                                @error('g-recaptcha-response')
                                <span class="status-not-available">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="checkbox">
                            <input type="checkbox" id="agree_for_term" name="agree_for_term" value="1">
                            <label for="agree_for_term"><span
                                    class="checkbox-icon"></span> {{ ___('I have read and agree to the Terms & Conditions') }}
                            </label>
                        </div>
                        <div class="row margin-top-30 margin-bottom-80" style="align-items: center;">
                            <div class="col-6">
                                <button type="submit" id="submit_job_button" name="Submit" class="button ripple-effect big"><i class="icon-feather-plus"></i> {{ ___('Post Listing') }}</button>
                            </div>
                            <div class="col-6">
                                <div id="ad_total_cost_container" class="text-right" style="display: none">
                                    <strong>
                                        {{ ___('Total') }}:
                                        <span id="totalPrice">0</span>
                                        <span class="currency-code">{{ $settings->currency_code }}</span>
                                    </strong>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-xl-4 hide-under-992px">
                    <div class="dashboard-box margin-top-0">
                        <!-- Headline -->
                        <div class="headline">
                            <h3><i class="icon-feather-alert-circle"></i> {{ ___('Tips!') }}</h3>
                        </div>
                        <div class="content with-padding padding-bottom-10">
                            <ul class="list-2">
                                <li>{{ ___('Enter a brief description of the advertise.') }}</li>
                                <li>{{ ___('Add your product photo.') }}</li>
                                <li>{{ ___('Choose the correct category and sub-category of the ad.') }}</li>
                                <li>{{ ___('Check again before submit the ad.') }}</li>
                            </ul>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection

@push('scripts_vendor')
    {!! google_captcha() !!}
    <script>
        var lang_edit_cat = @json("<i class='icon-feather-check-circle'></i> &nbsp;".___('Edit Category'));
    </script>
    <link href="{{ asset($activeThemeAssets.'assets/css/category-modal.css') }}" type="text/css" rel="stylesheet">
    <link href="{{ asset($activeThemeAssets.'assets/css/owl.post.carousel.css') }}" type="text/css" rel="stylesheet">
    <link href="{{ asset($activeThemeAssets.'assets/css/select2.min.css') }}" type="text/css" rel="stylesheet">
@endpush

@push('scripts_at_bottom')
    <script src="{{ asset($activeThemeAssets.'assets/js/select2.min.js') }}"></script>
    <script src="{{ asset($activeThemeAssets.'assets/js/owl.carousel-category.min.js') }}"></script>
    <script src="{{ asset($activeThemeAssets.'assets/js/jquery.form.js') }}"></script>
    <script src="{{ asset($activeThemeAssets.'assets/js/ad_post.js') }}"></script>
    @if(@$settings->post_desc_editor)
        <!-- CRUD FORM CONTENT - crud_fields_scripts stack -->
        <link href="{{ asset('assets/global/plugins/simditor/styles/simditor.css') }}" media="all" rel="stylesheet" type="text/css"/>
        <script src="{{ asset('assets/global/plugins/simditor/scripts/mobilecheck.js') }}"></script>
        <script src="{{ asset('assets/global/plugins/simditor/scripts/module.js') }}"></script>
        <script src="{{ asset('assets/global/plugins/simditor/scripts/uploader.js') }}"></script>
        <script src="{{ asset('assets/global/plugins/simditor/scripts/hotkeys.js') }}"></script>
        <script src="{{ asset('assets/global/plugins/simditor/scripts/simditor.js') }}"></script>
        <script>
            (function() {
                $(function() {
                    var $preview, editor, mobileToolbar, toolbar, allowedTags;
                    Simditor.locale = 'en-US';
                    toolbar = ['bold','italic','underline','|','ol','ul','blockquote','table','link'];
                    mobileToolbar = ["bold", "italic", "underline", "ul", "ol"];
                    if (mobilecheck()) {
                        toolbar = mobileToolbar;
                    }
                    allowedTags = ['br','span','a','img','b','strong','i','strike','u','font','p','ul','ol','li','blockquote','pre','h1','h2','h3','h4','hr','table'];
                    editor = new Simditor({
                        textarea: $('.text-editor'),
                        placeholder: '',
                        toolbar: toolbar,
                        pasteImage: false,
                        defaultImage: '{{ asset('assets/global/plugins/simditor/images/image.png') }}',
                        upload: false,
                        allowedTags: allowedTags
                    });
                    $preview = $('#preview');
                    if ($preview.length > 0) {
                        return editor.on('valuechanged', function(e) {
                            return $preview.html(editor.getValue());
                        });
                    }
                });
            }).call(this);
        </script>
    @endif

    @if(@$settings->post_address_mode)
        @if(@$settings->map_type == 'google')
            <link href="{{ asset('assets/global/plugins/map/google/map-marker.css') }}" type="text/css" rel="stylesheet">
            <script type='text/javascript' src='{{ asset('assets/global/plugins/map/google/jquery-migrate-1.2.1.min.js') }}'></script>
            <script type='text/javascript' src='//maps.google.com/maps/api/js?key={{ @$settings->gmap_api_key }}&#038;libraries=places%2Cgeometry&#038;ver=2.2.1'></script>
            <script type='text/javascript' src='{{ asset('assets/global/plugins/map/google/richmarker-compiled.js') }}'></script>
            <script type='text/javascript' src='{{ asset('assets/global/plugins/map/google/markerclusterer_packed.js') }}'></script>
            <script type='text/javascript' src='{{ asset('assets/global/plugins/map/google/gmapAdBox.js') }}'></script>
            <script type='text/javascript' src='{{ asset('assets/global/plugins/map/google/maps.js') }}'></script>
            <script>
                var _latitude       = @json(@$latitude);
                var _longitude      = @json(@$longitude);
                var path            = @json(asset('assets/global/plugins/map/google/'));
                var color           = @json(@$settings->map_color);
                var element         = "singleListingMap";
                var getCity         = false;
                var getCountry      = 'all';
                simpleMap(_latitude, _longitude, element);
            </script>
        @else
            <script>
                var openstreet_access_token = @json(@$settings->openstreet_access_token);
            </script>
            <link rel="stylesheet" href="{{ asset('assets/global/plugins/map/openstreet/css/style.css') }}">
            <!-- Leaflet // Docs: https://leafletjs.com/ -->
            <script src="{{ asset('assets/global/plugins/map/openstreet/leaflet.min.js') }}"></script>

            <!-- Leaflet Maps Scripts (locations are stored in leaflet-quick.js) -->
            <script src="{{ asset('assets/global/plugins/map/openstreet/leaflet-markercluster.min.js') }}"></script>
            <script src="{{ asset('assets/global/plugins/map/openstreet/leaflet-gesture-handling.min.js') }}"></script>
            <script src="{{ asset('assets/global/plugins/map/openstreet/leaflet-quick.js') }}"></script>

            <!-- Leaflet Geocoder + Search Autocomplete // Docs: https://github.com/perliedman/leaflet-control-geocoder -->
            <script src="{{ asset('assets/global/plugins/map/openstreet/leaflet-autocomplete.js') }}"></script>
            <script src="{{ asset('assets/global/plugins/map/openstreet/leaflet-control-geocoder.js') }}"></script>
            <script>
                $('#jobcity').on('change', function() {
                    var data = $("#jobcity option:selected").val();
                    var custom_data= $("#jobcity").select2('data')[0];
                    var latitude = custom_data.latitude;
                    var longitude = custom_data.longitude;
                    var address = custom_data.text;
                    $('#latitude').val(latitude);
                    $('#longitude').val(longitude);
                    if (document.getElementById("singleListingMap") !== null && singleListingMap) {
                        $("#address-autocomplete").val(address);
                        var newLatLng = new L.LatLng(latitude, longitude);
                        singleListingMapMarker.setLatLng(newLatLng);
                        singleListingMap.flyTo(newLatLng, 10);
                    }
                });
            </script>
        @endif
    @endif
    <link href="{{ asset('assets/global/plugins/filepond/filepond.css') }}" rel="stylesheet">
    <script src="{{ asset('assets/global/plugins/filepond/filepond.js') }}"></script>
    <script>
        // Turn input element into a pond with configuration options
        $('.quickImageUpload').filepond({
            imagePreviewHeight: 200,
            acceptedFileTypes: ['image/png','image/jpg','image/jpeg'],
            credits: false,
            server: {
                load: (source, load, error, progress, abort, headers) => {
                    const myRequest = new Request(source);
                    fetch(myRequest).then((res) => {
                        return res.blob();
                    }).then(load);
                },
                process: '{{ route('posts.upload') }}',
                revert: '{{ route('posts.revert') }}',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            }
        });
    </script>
@endpush


