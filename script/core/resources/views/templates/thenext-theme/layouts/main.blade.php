<!DOCTYPE html>
<html lang="{{ get_lang() }}" dir="{{ current_language()->direction }}">
<head>
    @include($activeTheme.'layouts.includes.head')
    @include($activeTheme.'layouts.includes.styles')
    {!! head_code() !!}
</head>
<body id="page" data-role="page" class="{{ current_language()->direction }}" data-ipapi="{{ $settings->live_location_api }}" data-showlocationicon="{{ $settings->location_track_icon }}">
@include($activeTheme.'layouts.includes.header')

@yield('content')

@include($activeTheme.'layouts.includes.footer')
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
