<!-- Wrapper -->
<div id="wrapper" class="">
    <!-- Header Container
    ================================================== -->
    <header id="header-container" class="transparent">
        @if(session()->get('quick_admin_user_id'))
            <div class="notification notice margin-bottom-0 padding-bottom-10 padding-top-10">
                <div class="d-flex justify-content-between">
                    <span>{!! ___('You are logged in as :user_name.', ['user_name' => '<strong>'.request()->user()->name.'</strong>']) !!}</span>
                    <a href="{{ route('logout') }}"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{ ___('Exit') }}
                    </a>
                </div>
            </div>
        @endif
        @auth
            @if($settings->non_active_msg == 1 && !request()->user()->hasVerifiedEmail())
                <div class="user-status-message">
                    <div class="container container-active-msg">
                        <div class="row">
                            <div class="col-lg-8">
                                <i class="icon-lock text-18"></i>
                                <span>{{ ___('Your email address is not verified. Please verify your email address to use all the features.') }}</span>
                            </div>
                            <div class="col-lg-4">
                                <form action="{{ route('verification.resend') }}" method="post">
                                    @csrf
                                    <button type="submit"
                                            class="button ripple-effect gray">{{ ___('Resend Email') }}</button>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
        @endif
    @endauth
    <!-- Header -->
        <div id="header">
            <div class="container">
                <div class="left-side">
                    <div id="logo">
                        <a href="{{ route('home') }}">
                            @php
                                $logo_white = asset('storage/logo/'.@$settings->site_logo_footer);
                                $logo_dark = asset('storage/logo/'.$settings->site_logo);
                            @endphp
                            <img src="{{ $logo_dark }}" data-sticky-logo="{{ $logo_dark }}"
                                 data-transparent-logo="{{ $logo_white }}" alt="{{ @$settings->site_title }}">
                        </a>
                    </div>
                    <nav class="navigation">
                        <ul>
                            @if(@$settings->country_type == 'multi')
                            <li>
                                <a href="#countryModal" class="country-flag popup-with-zoom-anim"
                                   title="Change Country"
                                   data-tippy-placement="right">

                                    <img src="{{ asset('assets/global/plugins/flags/') }}/images/{{ strtolower($session_country) }}.png"/>
                                </a>
                            </li>
                            @endif
                            @if(env('DEMO_MODE'))
                                <li class=""><a href="#">{{ ___('Home') }}</a>
                                    <ul class="dropdown-nav">
                                        <li><a href="{{ route('home') }}/?view=homeimage">{{ ___('Home Image') }}</a></li>
                                        <li><a href="{{ route('home') }}/?view=homemap">{{ ___('Home Map') }}</a></li>
                                    </ul>
                                </li>
                            @endif
                            <li class="d-none d-lg-block">
                                <a href="{{ route('search.index') }}"><i class="icon-feather-list"></i> {{ ___('Find Ads') }}</a>
                            </li>
                        </ul>
                    </nav>
                    <div class="clearfix"></div>
                    <!-- Mobile Navigation -->
                    <nav class="mmenu-init">
                        <ul class="mm-listview">
                            @guest
                                <li><a href="{{ route('login') }}">{{ ___('Login') }}</a></li>
                                <li><a href="{{ route('register') }}">{{ ___('Register') }}</a></li>
                            @endguest
                                <li><a href="{{ route('posts.create') }}" class="button ripple-effect">{{ ___('Post Free Ad') }}</a></li>
                                <li><a href="{{ route('search.index') }}">{{ ___('Find Ads') }}</a></li>
                            @auth
                                    <li><a href="{{ route('dashboard') }}">{{ ___('Dashboard') }}</a></li>
                                    <li><a href="{{ route('profile', request()->user()->username) }}">{{ ___('My Profile') }}</a></li>
                                    <li><a href="{{ route('dashboard') }}">{{ ___('My Ads') }}</a></li>
                                    @if(is_plugin_enabled('quickchatajax'))
                                        <li><a href="{{ route('message.index') }}">{{ ___('Message') }}</a></li>
                                    @endif
                                    <li><a href="{{ route('subscription') }}">{{ ___('Membership') }}</a></li>
                                    <li><a href="{{ route('transactions') }}">{{ ___('Transactions') }}</a></li>
                                    <li><a href="{{ route('settings') }}">{{ ___('Settings') }}</a></li>
                                    <li><a href="{{ route('logout') }}"
                                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i
                                                class="icon-feather-log-out"></i> {{ ___('Logout') }}
                                        </a>
                                    </li>
                            @endauth
                        </ul>
                    </nav>
                </div>
                <div class="right-side">
                    @guest
                        <div class="header-widget d-none d-lg-block">
                            <nav class="navigation">
                                <ul>
                                    <li>
                                        <a href="#sign-in-dialog" class="popup-with-zoom-anim"><i
                                                class="icon-feather-log-in"></i> {{ ___('Login') }}</a>
                                    </li>
                                    <li><a href="{{ route('register') }}">{{ ___('Register') }}</a></li>
                                    <li><a href="{{ route('posts.create') }}" class="button ripple-effect post-job">{{ ___('Post Free Ad') }}</a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    @endguest

                    @auth
                        <div class="header-widget padding-right-0 d-none d-lg-block">
                            <div class="header-notifications user-menu">
                                <div class="header-notifications-trigger">
                                    <a href="#"><i class="icon-feather-user"></i> {{ request()->user()->username }}<i
                                            class="icon-feather-chevron-down"></i></a>
                                </div>
                                <div class="header-notifications-dropdown">
                                    <ul class="user-menu-small-nav">
                                        @if(request()->user()->isAdmin())
                                            <li><a href="{{ route('admin.dashboard') }}" target="_blank"><i
                                                        class="icon-feather-external-link"></i> {{ ___('Admin') }}
                                                </a></li>
                                        @endif
                                            <li><a href="{{ route('dashboard') }}"><i
                                                        class="icon-feather-grid"></i> {{ ___('Dashboard') }}
                                                </a></li>
                                            <li><a href="{{ route('posts.create') }}"><i
                                                        class="icon-feather-plus-square"></i> {{ ___('Post Ad') }}
                                                </a></li>
                                            <li><a href="{{ route('posts.myListing') }}"><i
                                                        class="icon-feather-layers"></i> {{ ___('My Listings') }}
                                                </a></li>

                                            <li><a href="{{ route('subscription') }}"><i
                                                        class="icon-feather-gift"></i> {{ ___('Membership') }}
                                                </a></li>
                                            <li><a href="{{ route('transactions') }}"><i
                                                        class="icon-feather-file-text"></i> {{ ___('Transactions') }}
                                                </a></li>
                                            <li><a href="{{ route('settings') }}"><i
                                                        class="icon-feather-settings"></i> {{ ___('Account Setting') }}
                                                </a></li>
                                            <li><a href="{{ route('logout') }}"
                                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i
                                                        class="icon-feather-log-out"></i> {{ ___('Logout') }}
                                                </a>
                                            </li>
                                    </ul>
                                    <form id="logout-form" class="d-inline" action="{{ route('logout') }}"
                                          method="POST">
                                        @csrf
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="header-widget d-none d-lg-block">
                            <nav class="navigation">
                                <ul>
                                    <li><a href="{{ route('posts.create') }}" class="button ripple-effect post-job">
                                            {{ ___('Post Free Ad') }}
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    @endauth

                    @if($settings->userlangsel)
                        @php
                            $language = current_language();
                        @endphp
                        <div class="header-widget">
                            <div class="btn-group bootstrap-select language-switcher">
                                <button type="button" class="btn dropdown-toggle btn-default" data-toggle="dropdown"
                                        title="{{ $language->name }}">
                                    <span class="filter-option pull-left"
                                          id="selected_lang">{{ strtoupper($language->code) }}</span>&nbsp;
                                    <span class="caret"></span>
                                </button>
                                <div class="dropdown-menu scrollable-menu open">
                                    <ul class="dropdown-menu inner">
                                        @foreach($languages as $language)
                                            <li data-lang="{{ $language->code }}">
                                                <a role="menuitem" tabindex="-1" rel="alternate"
                                                   href="{{ lang_url($language->code) }}">{{ $language->name }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endif
                    <span class="mmenu-trigger">
                        <button class="hamburger hamburger--collapse" type="button">
                            <span class="hamburger-box">
                                <span class="hamburger-inner"></span>
                            </span>
                        </button>
                    </span>
                </div>
            </div>
        </div>

    </header>
    <div class="clearfix"></div>
    <!-- Header Container / End -->

    <!-- Country Picker -->
    <div class="zoom-anim-dialog mfp-hide dialog-with-tabs popup-dialog big-dialog" id="countryModal">
        <ul class="popup-tabs-nav">
            <li><a href="#country"><i class="icon-feather-map-pin"></i> {{ ___('Select Your Country') }}</a></li>
        </ul>
        <div class="popup-tabs-container">
            <div class="popup-tab-content" id="country">

                <div class="row">
                    <div class="col-md-6">
                        <div class="input-with-icon margin-bottom-30">
                            <input class="with-border" type="text" placeholder="{{ ___('Search') }}..." id="country-modal-search">
                            <i class="icon-feather-search"></i>
                        </div>
                    </div>
                    <ul id="countries" class="column col-md-12 col-sm-12 cities">
                        @foreach(countries(true) as $country)
                        <li data-name="{{ $country->name }}">
                            <span class="flag flag-{{ strtolower($country->code) }}"></span>
                            <a href="{{ lang_url(getLangFromCountry($country->languages)) }}/{{ strtolower($country->code) }}"
                                data-id="{{ $country->id }}"
                                data-name="{{ $country->name }}"> {{ $country->name }}</a>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!--Country-Cities-changes-Model-->
    <a class="popup-with-zoom-anim hidden" href="#citiesModal" id="change-city">{{ ___('city') }}</a>
    <div class="zoom-anim-dialog mfp-hide popup-dialog big-dialog" id="citiesModal">
        <div class="popup-tab-content padding-0">
            <div class="quick-states" id="country-popup" data-country-id="{{ $session_country }}" style="display: block;">
                <div id="regionSearchBox" class="title clr">
                    <div class="clr">
                        <div class="locationrequest smallBox br5 col-sm-4">
                            <div class="rel input-container">
                                <div class="input-with-icon">
                                    <input id="inputStateCity" class="with-border" type="text" placeholder="{{ ___('Enter city name') }}">
                                    <i class="la la-map-marker"></i>
                                </div>
                                <div id="searchDisplay"></div>
                                <div class="suggest bottom abs small br3 error hidden"><span
                                        class="target abs icon"></span>

                                    <p></p>
                                </div>
                            </div>
                            <div id="lastUsedCities" class="last-used binded" style="display: none;">{{ ___('Last Visited') }}
                                <ul id="last-locations-ul">
                                </ul>
                            </div>
                        </div>
                        @if(@$settings->country_type == 'multi')
                            <span style="line-height: 30px;">
                                <span class="flag flag-{{ strtolower($session_country) }}"></span>
                                <a href="#countryModal" class="popup-with-zoom-anim">{{ ___('Change Country') }}</a>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="popular-cities clr">
                    <p>{{ ___('Popular Cities') }}</p>

                    <div class="list row">

                        <ul class="col-lg-12 col-md-12 popularcity">
                            @foreach($popularCities as $city)
                                <li><a class="selectme" data-id="{{ $city->id }}" data-name="{{ $city->name }}" data-type="city"><span>{{ $city->name }}</span></a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="viewport">
                    <div class="full" id="getCities">
                        <div class="col-sm-12 col-md-12 loader" style="display: none"></div>
                        <div id="results" class="animate-bottom">
                            <ul class="column cities">

                                <li class="selected"><a class="selectme" data-id="{{ $session_country }}" data-name="{{ ___('All') }} {{ get_country_name($session_country) }}" data-type="country"><strong>{{ ___('All') }} {{ get_country_name($session_country) }}</strong></a></li>

                                @foreach($regions as $region)
                                    <li class="">
                                        <a class="statedata" id="region{{ $region->code }}"
                                           data-id="{{ $region->code }}" data-name="{{ $region->name }}">
                                            <span>{{ $region->name }} <i class="fa fa-angle-right"></i></span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="table full subregionslinks hidden" id="subregionslinks"></div>
                </div>
            </div>
        </div>
    </div>
    <!--Country-Cities-changes-Model-->
