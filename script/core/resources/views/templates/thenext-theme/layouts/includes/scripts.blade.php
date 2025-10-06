@stack('scripts_at_top')

<script>
    "use strict";
    var siteurl = @json(route('home'));
    var ajaxurl = @json(route('ajaxurl'));
    var themecolor = @json($settings->theme_color);
    var mapcolor = @json($settings->map_color);
    var LANG_LOGGED_IN_SUCCESS = @json(___('Logged in successfully'));
    var LANG_DEVELOPED_BY = @json(___('Developed by'));
    var DEVELOPER_CREDIT = @json(@$settings->developer_credit);
    var LIVE_CHAT = @json(@$settings->live_chat);

    if ($("body").hasClass("rtl")) {
        var rtl = true;
    }else{
        var rtl = false;
    }
</script>

<script src="{{ asset($activeThemeAssets.'assets/js/mmenu.min.js') }}"></script>
<script src="{{ asset($activeThemeAssets.'assets/js/tippy.all.min.js') }}"></script>
<script src="{{ asset($activeThemeAssets.'assets/js/bootstrap-select.min.js') }}"></script>
<script src="{{ asset($activeThemeAssets.'assets/js/magnific-popup.min.js') }}"></script>
<script src="{{ asset($activeThemeAssets.'assets/js/jquery.cookie.min.js') }}"></script>
<script src="{{ asset($activeThemeAssets.'assets/js/jquery.nicescroll.min.js') }}"></script>
<script src="{{ asset($activeThemeAssets.'assets/js/slick.min.js') }}"></script>
<script src="{{ asset('assets/global/js/jquery.lazyload.min.js') }}"></script>
<script src="{{ asset('assets/global/plugins/snackbar/snackbar.min.js') }}"></script>
<script src="{{ asset('assets/global/plugins/styleswitcher/jquery.style-switcher.js') }}"></script>
<script src="{{ asset('assets/global/js/global.js') }}"></script>
<script src="{{ asset('assets/global/js/jquery.cookie.js') }}"></script>
@stack('scripts_vendor')
<!--Custom JS-->
<script src="{{ asset($activeThemeAssets.'assets/js/custom.js?ver='.config('appinfo.version')) }}"></script>
<script src="{{ asset($activeThemeAssets.'assets/js/app.js?ver='.config('appinfo.version')) }}"></script>
<script src="{{ asset($activeThemeAssets.'assets/js/user-ajax.js?ver='.config('appinfo.version')) }}"></script>
@stack('scripts_at_bottom')

@if(\Session::has('quick_alert_message'))
    <script>
        Snackbar.show({
            text: @json(\Session::get('quick_alert_message')),

            @if(\Session::get('quick_alert_type') == 'error')
            backgroundColor: '#ee5252'
            @elseif(\Session::get('quick_alert_type') == 'success')
            backgroundColor: '#383838'
            @elseif(\Session::get('quick_alert_type') == 'info')
            backgroundColor: '#45cfe1'
            @endif
        });
    </script>
@endif

<script>
    $(document).ready(function(){
        /* THIS PORTION OF CODE IS ONLY EXECUTED WHEN THE USER CHANGE THEME(CLIENT-SIDE)
        /* ========================================================================== */
        $('#theme-dropdown').on('click', '.dropdown-menu li', function (e) {
            var theme = $(this).data('theme');
            var theme_url = siteurl+"/theme/"+theme;
            window.location.href = theme_url;
        });
        var theme = $.cookie('Quick_theme');
        if (theme!=null) {
            var thm = theme.substr(0, theme.indexOf('-'));
            $('#selected_theme').html(thm);
        }

    });
</script>
