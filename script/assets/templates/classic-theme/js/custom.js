jQuery(function ($) {
    'use strict';
    bgTransfer();

    // -------------------------------------------------------------
    //  ScrollUp Minimum setup
    // -------------------------------------------------------------
    (function () {
        $.scrollUp();
    }());
    // -------------------------------------------------------------
    //  Placeholder
    // -------------------------------------------------------------
    (function () {
        var textAreas = document.getElementsByTagName('textarea');
        Array.prototype.forEach.call(textAreas, function (elem) {
            elem.placeholder = elem.placeholder.replace(/\\n/g, '\n');
        });
    }());
    // -------------------------------------------------------------
    //  Show
    // -------------------------------------------------------------
    (function () {
        $("document").ready(function () {
            $(".more-category.one").hide();
            $(".show-more.one").click(function () {
                $(".more-category.one").show();
                $(".show-more.one").hide();
            });

            $(".more-category.two").hide();
            $(".show-more.two").click(function () {
                $(".more-category.two").show();
                $(".show-more.two").hide();
            });

            $(".more-category.three").hide();
            $(".show-more.three").click(function () {
                $(".more-category.three").show();
                $(".show-more.three").hide();
            });
        });
    }());

    /*===================
     * Modal
     * =================*/
    $(".modal-overlay,.close_modal").on("click", function (e) {
        e.preventDefault();
        $(this).parents(".modal-container").removeClass("active");
    });

    $(".modal-trigger").on("click", function (e) {
        e.preventDefault();
        $(".modal-container").removeClass("active");
        $($(this).attr("href")).addClass("active");
    });
    // -------------------------------------------------------------
    //  Tooltip
    // -------------------------------------------------------------

    (function () {
        $('[data-toggle="tooltip"]').tooltip();
    }());

    // -------------------------------------------------------------
    // Accordion
    // -------------------------------------------------------------
    (function () {
        $('.collapse').on('show.bs.collapse', function () {
            var id = $(this).attr('id');
            $('a[href="#' + id + '"]').closest('.panel-heading').addClass('active-faq');
            $('a[href="#' + id + '"] .panel-title span').html('<i class="fa fa-minus"></i>');
        });

        $('.collapse').on('hide.bs.collapse', function () {
            var id = $(this).attr('id');
            $('a[href="#' + id + '"]').closest('.panel-heading').removeClass('active-faq');
            $('a[href="#' + id + '"] .panel-title span').html('<i class="fa fa-plus"></i>');
        });
    }());

    // -------------------------------------------------------------
    //  Checkbox Icon Change
    // -------------------------------------------------------------
    (function () {
        $('input[type="checkbox"]').change(function () {
            if ($(this).is(':checked')) {
                $(this).parent("label").addClass("checked");
            } else {
                $(this).parent("label").removeClass("checked");
            }
        });
    }());

    // -------------------------------------------------------------
    //   Show Mobile Number
    // -------------------------------------------------------------
    (function () {

        $('.show-number').on('click', function () {
            $('.hide-text').fadeIn(500, function () {
                $(this).addClass('hide');
            });
            $('.hide-number').fadeIn(500, function () {
                $(this).addClass('show');
            });
        });
    }());
// script end
});

// -------------------------------------------------------------
//  Owl Carousel
// -------------------------------------------------------------
(function () {
    if ($("body").hasClass("rtl")) var rtl = true;
    else rtl = false;
    $("#featured-slider").owlCarousel({
        items: 3,
        nav: true,
        autoplay: true,
        dots: false,
        autoplayHoverPause: true,
        rtl: rtl,
        navText: [
            "<i class='fa fa-angle-left '></i>",
            "<i class='fa fa-angle-right'></i>"
        ],
        responsive: {
            0: {
                items: 1,
                slideBy: 1
            },
            500: {
                items: 2,
                slideBy: 1
            },
            991: {
                items: 2,
                slideBy: 1
            },
            1200: {
                items: 3,
                slideBy: 1
            }
        }
    });

    $("#latest-slider").owlCarousel({
        items: 3,
        nav: true,
        autoplay: true,
        dots: false,
        autoplayHoverPause: true,
        rtl: rtl,
        navText: [
            "<i class='fa fa-angle-left '></i>",
            "<i class='fa fa-angle-right'></i>"
        ],
        responsive: {
            0: {
                items: 1,
                slideBy: 1
            },
            500: {
                items: 2,
                slideBy: 1
            },
            991: {
                items: 2,
                slideBy: 1
            },
            1200: {
                items: 3,
                slideBy: 1
            }
        }
    });

    $("#recent-slider-id").owlCarousel({
        items: 4,
        nav: true,
        autoplay: true,
        dots: false,
        autoplayHoverPause: true,
        rtl: rtl,
        navText: [
            "<i class='fa fa-angle-left '></i>",
            "<i class='fa fa-angle-right'></i>"
        ],
        responsive: {
            0: {
                items: 1,
                slideBy: 1
            },
            480: {
                items: 2,
                slideBy: 1
            },
            991: {
                items: 3,
                slideBy: 1
            },
            1000: {
                items: 4,
                slideBy: 1
            }
        }
    });

    $("#recommended-slider-id").owlCarousel({
        items: 4,
        nav: true,
        autoplay: true,
        dots: false,
        autoplayHoverPause: true,
        nav: true,
        rtl: rtl,
        navText: [
            "<i class='fa fa-angle-left '></i>",
            "<i class='fa fa-angle-right'></i>"
        ],
        responsive: {
            0: {
                items: 1,
                slideBy: 1
            },
            480: {
                items: 2,
                slideBy: 1
            },
            991: {
                items: 3,
                slideBy: 1
            },
            1000: {
                items: 4,
                slideBy: 1
            }
        }
    });

    $(".pricing-plans-carousel").owlCarousel({
        autoplay: false,
        autoplayTimeout: 3000,
        nav: false,
        loop:true,
        touchDrag: true,
        checkVisibility: true,
        dots: true,
        margin:10,
        rtl: rtl,
        responsive:{
            0:{
                items:1
            },
            762: {
                items:2
            },

            1350:{
                items:3
            }
        }
    });
}());

(function () {

    $(".testimonial-carousel").owlCarousel({
        items: 1,
        autoplay: true,
        autoplayHoverPause: true
    });

}());

var s = localStorage.listGrid;
if (s) {
    if (s == 'grid') {
        $('#serchlist .searchresult.grid').fadeIn();
        $('#grid').addClass('btn-success').children('i').addClass('icon-white');
        $('#list').removeClass('btn-success').children('i').removeClass('icon-white');
    } else {
        $('#serchlist .searchresult.list').fadeIn();
        $('#list').addClass('btn-success').children('i').addClass('icon-white');
        $('#grid').removeClass('btn-success').children('i').removeClass('icon-white');
    }
} else {
    var listing_view = $('#serchlist').data('listing-view');

    if(listing_view == 'list'){
        $('#serchlist .searchresult.list').show();
        $('#list').addClass('btn-success').children('i').addClass('icon-white');
        $('#grid').removeClass('btn-success').children('i').removeClass('icon-white');
    }else{
        $('#serchlist .searchresult.grid').show();
        $('#grid').addClass('btn-success').children('i').addClass('icon-white');
        $('#list').removeClass('btn-success').children('i').removeClass('icon-white');
    }

}
$('#list').click(function () {
    $(this).addClass('btn-success').children('i').addClass('icon-white');
    $('.grid').fadeOut();
    $('.list').fadeIn();
    $('#grid').removeClass('btn-success').children('i').removeClass('icon-white');
    localStorage.listGrid = 'list';
});
$('#grid').click(function () {
    $(this).addClass('btn-success').children('i').addClass('icon-white');
    $('.list').fadeOut();
    $('.grid').fadeIn();
    $('#list').removeClass('btn-success').children('i').removeClass('icon-white');
    localStorage.listGrid = 'grid';
});

//  Transfer "img" into CSS background-image

function bgTransfer() {
    //disable-on-mobile
    $(".bg-transfer").each(function () {
        $(this).css("background-image", "url(" + $(this).find("img").attr("src") + ")");
    });
}
// -------------------------------------------------------------
//  select-category Change
// -------------------------------------------------------------
$('.select-category.post-option ul li a').on('click', function () {
    $('.select-category.post-option ul li.link-active').removeClass('link-active');
    $(this).closest('li').addClass('link-active');
});

$('.subcategory.post-option ul li a').on('click', function () {
    $('.subcategory.post-option ul li.link-active').removeClass('link-active');
    $(this).closest('li').addClass('link-active');
});

// -------------------------------------------------------------
//  language Select
// -------------------------------------------------------------

(function () {

    $('.navbar-dropdown').on('click', '.language-change a', function (ev) {
        if ("#" === $(this).attr('href')) {
            ev.preventDefault();
            var parent = $(this).parents('.navbar-dropdown');
            parent.find('.change-text').html($(this).html());
        }
    });
    // -------------------------------------------------------------
    //   Toggle user menu 
    $(".user-menu").on("click", function () {
        $(this).toggleClass("active")
    });

}());

$('.enable-filters-button').on('click', function () {
    $('.sidebar-container').slideToggle();
    $(this).toggleClass("active");
    if($('.enable-filters-button i').hasClass('fa-plus')){
        $('.enable-filters-button i').removeClass('fa-plus').addClass('fa-minus');
    }else{
        $('.enable-filters-button i').removeClass('fa-minus').addClass('fa-plus');
    }
});

$('.billing-cycle-radios').on("click", function () {
    if ($('.billed-yearly-radio input').is(':checked')) {
        $('.pricing-plans-container').addClass('billed-yearly').removeClass('billed-lifetime');
    }
    if ($('.billed-monthly-radio input').is(':checked')) {
        $('.pricing-plans-container').removeClass('billed-yearly').removeClass('billed-lifetime');
    }
    if ($('.billed-lifetime-radio input').is(':checked')) {
        $('.pricing-plans-container').addClass('billed-lifetime').removeClass('billed-yearly');
    }
});
$('.billing-cycle-radios input').first().trigger('click');