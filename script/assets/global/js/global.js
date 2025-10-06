jQuery(function ($) {
    'use strict';
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

        $('#styleswitch').styleSwitcher();
        $("#styleswitch h3").click(function () {
            if ($(this).parent().css("left") == "-200px") {
                $(this).parent().animate({left: '0px'}, {queue: false, duration: 500});
            } else {
                $(this).parent().animate({left: '-200px'}, {queue: false, duration: 500});
            }
        });
        $('.styleswitch .toggler').on('click', function (event) {
            event.preventDefault();
            $(this).closest('.styleswitch').toggleClass('opened');
        });

        // -------------------------------------------------------------
        //  Lazy Load Images
        // -------------------------------------------------------------
        (function () {
            $("document").ready(function () {
                $("img.lazy-load").lazyload({effect:"fadeIn",load:function(){$(this).removeClass('lazy-load');}});
            });
        }());

    });
});