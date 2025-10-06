<style>
    :root{@php
        $themecolor = $settings->theme_color;
        list($r, $g, $b) = sscanf($themecolor, "#%02x%02x%02x");

        $i = 0.01;
        while($i <= 1){
            echo "--theme-color-".str_replace('.','_',$i).": rgba($r,$g,$b,$i);";
            $i += 0.01;
        }
        echo "--theme-color-1: rgba($r,$g,$b,1);";
        @endphp}
</style>

<link rel="stylesheet" href="{{ asset('assets/global/css/icons.css') }}">
<link rel="stylesheet" href="{{ asset('assets/global/fonts/css/fontawesome.css') }}">
<link rel="stylesheet" href="{{ asset('assets/global/plugins/flags/flags.min.css') }}"/>
<link rel="stylesheet" href="{{ asset('assets/global/plugins/snackbar/snackbar.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/global/plugins/styleswitcher/styleswitcher.css') }}">

<link rel="stylesheet" href="{{ asset($activeThemeAssets.'assets/css/style.css') }}">
<link rel="stylesheet" href="{{ asset($activeThemeAssets.'assets/css/slick.css') }}">
<link rel="stylesheet" href="{{ asset($activeThemeAssets.'assets/css/color.css') }}">
@if(current_language()->direction == 'rtl')
    <link rel="stylesheet" href="{{ asset($activeThemeAssets.'assets/css/rtl.css') }}">
@endif
<script src="{{ asset('assets/global/js/jquery.min.js') }}"></script>
@if (!empty(@$settings->external_code))
    {!! trim($settings->external_code) !!}
@endif
