<!DOCTYPE html>
<html lang="{{ get_lang() }}" dir="{{ current_language()->direction }}">
<head>
    @include($activeTheme.'layouts.includes.head')
    @include($activeTheme.'layouts.includes.styles')
    {!! head_code() !!}
</head>
<body class="{{ current_language()->direction }}">
@include($activeTheme.'layouts.includes.header')

    <div id="titlebar" class="margin-bottom-0">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>@yield('title')</h2>
                    <!-- Breadcrumbs -->
                    <nav id="breadcrumbs">
                        <ul>
                            <li><a href="{{ route('home') }}">{{ ___('Home') }}</a></li>
                            <li>@yield('title')</li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="section gray padding-bottom-50">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-12">
                    @include($activeTheme.'user.includes.dashboard-sidebar')
                </div>
                <div class="col-lg-9 col-md-12">
                    {!! ads_on_dashboard_top() !!}
                    @yield('content')
                    {!! ads_on_dashboard_bottom() !!}
                </div>
            </div>
        </div>
    </div>
    <div class="small-footer">
        <div class="small-footer-copyrights">
            {{ ___('Copyright © :current_year Bylancer. All Rights Reserved.', ['current_year' => date('Y')]) }}
        </div>
        <ul class="footer-social-links">
            @if(@$settings->facebook_link)
                <li><a href="{{ $settings->facebook_link }}" target="_blank" rel="nofollow"><i
                            class="fab fa-facebook"></i></a></li>
            @endif
            @if(@$settings->twitter_link)
                <li><a href="{{ $settings->twitter_link }}" target="_blank"
                       rel="nofollow"><i class="fab fa-x"></i></a></li>
            @endif
            @if(@$settings->instagram_link)
                <li><a href="{{ $settings->instagram_link }}" target="_blank"
                       rel="nofollow"><i class="fab fa-instagram"></i></a></li>
            @endif
            @if(@$settings->linkedin_link)
                <li><a href="{{ $settings->linkedin_link }}" target="_blank" rel="nofollow"><i
                            class="fab fa-linkedin"></i></a></li>
            @endif
            @if(@$settings->pinterest_link)
                <li><a href="{{ $settings->pinterest_link }}" target="_blank"
                       rel="nofollow"><i class="fab fa-pinterest"></i></a></li>
            @endif
            @if(@$settings->youtube_link)
                <li><a href="{{ $settings->youtube_link }}" target="_blank"
                       rel="nofollow"><i class="fab fa-youtube"></i></a></li>
            @endif
        </ul>
        <div class="clearfix"></div>
    </div>

@include($activeTheme.'layouts.includes.addons')
@include($activeTheme.'layouts.includes.scripts')

@auth
    <!-- /# QuickChatAjax Plugin-->
    @if(is_plugin_enabled('quickchatajax'))
        @include('quickchatajax::user.quickchat')
    @endif
    <!-- /# QuickChatAjax Plugin-->
@endauth

</body>
</html>
