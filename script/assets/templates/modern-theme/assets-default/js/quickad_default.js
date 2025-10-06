/* --------------------------------------------------------------------------
 * Bylancer Technologies : Mydiary - Template
 *
 * file           : default.css
 * Desc           : Mydiary Template - Stylesheet
 * Version        : 1.1
 * Date           : 2016-07-01
 * Author         : Bylancer Technologies
 * Author URI     : http://bylancer.com
 * Email          : helpdesk.bylancer@gmail.com
 *
 * Bylancer Studio. Copyright 2019. All Rights Reserved.
 * -------------------------------------------------------------------------- */
/* --------------------------------------------------------------------------
 *  Mydiary Template - Table of Content

  1 - Style-Switcher
  2 -




/* 1 */
/* Style-Switcher
/* ========================================================================== */

!function(e){function t(e){"undefined"!=typeof map&&(map.setOptions({styles:null}),map.setOptions({styles:[{featureType:"all",elementType:"labels.icon",stylers:[{visibility:"off"}]},{featureType:"landscape",stylers:[{saturation:-100},{lightness:60}]},{featureType:"road.local",stylers:[{saturation:-100},{lightness:40},{visibility:"on"}]},{featureType:"transit",stylers:[{saturation:-100},{visibility:"simplified"}]},{featureType:"administrative.province",stylers:[{visibility:"off"}]},{featureType:"water",stylers:[{visibility:"on"},{lightness:30}]},{featureType:"road.highway",elementType:"geometry.fill",stylers:[{color:e},{lightness:40}]},{featureType:"road.highway",elementType:"geometry.stroke",stylers:[{visibility:"off"}]},{featureType:"poi.park",elementType:"geometry.fill",stylers:[{color:e},{lightness:60},{saturation:-40}]},{}]}))}e.fn.styleSwitcher=function(o){var l={slidein:!0,preview:!0,container:this.selector},i=e.extend(l,o);localStorage&&(void 0!==localStorage.quickadColor?(document.documentElement.style.setProperty("--theme-color",localStorage.quickadColor),t(localStorage.quickadColor)):(document.documentElement.style.setProperty("--theme-color",themecolor),t(mapcolor))),i.slidein?e(i.container).slideDown("slow"):e(i.container).show(),i.preview&&e(i.container+" a").click(function(){document.documentElement.style.setProperty("--theme-color",e(this).html()),t(e(this).html())}),e(i.container+" a").click(function(){document.documentElement.style.setProperty("--theme-color",e(this).html()),t(e(this).html()),localStorage&&(localStorage.quickadColor=e(this).html())})}}(jQuery);

$('#styleswitch').styleSwitcher();
$("#styleswitch h3").on('click',function () {
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

/* 2 */
/* Resend Verify Email
/* ========================================================================== */
$(document).ready(function() {
    $('.resend').on('click', function (e) {
        e.preventDefault();
        // Button which will activate our modal

        the_id = $(this).attr('id');						//get the id

        // show the spinner
        $(this).parent().html("<img src= '"+siteurl+"templates/{TPL_NAME}/assets-default/images/spinner.gif'/>");

        $.ajax({											//the main ajax request
            type: "POST",
            data: "action=email_verify&id="+$(this).attr("id"),
            url: ajaxurl,
            success: function(data)
            {
                var tpl = '<a class="uiButton uiButtonLarge resend" style="box-sizing:content-box;"><span class="uiButtonText">'+data+'</span></a>';
                $("span#resend_count"+the_id).html(data);
                //fadein the vote count
                $("span#resend_count"+the_id).fadeIn();
                //remove the spinner
                $("span#resend_buttons"+the_id).remove();

            }
        });

        return false;
    });
});
/* 4 */
/* Zechat RTL Activate
/* ========================================================================== */
if ($("body").hasClass("rtl")) {
    $('#zechat-rtl').append('<link rel="stylesheet" type="text/css" href='+siteurl+'"plugins/zechat/app/includes/chatcss/chat-rtl.css">');

    var rtl = true;
}else{
    var rtl = false;
}
/* 4 */
/* Activate our reviews Star rating
/* ========================================================================== */
$(document).ready(function () {
    $().reviews('.starReviews');
    ratingPassive(".item-rating");
});

/* 5 */
/* Account Setting
/* ========================================================================== */
var error = "";
function checkAvailabilityName() {
    $("#loaderIcon").show();
    var action = 'check_availability';
    var name = $("#name").val();
    var data = {action: action, name: name};
    jQuery.ajax({
        type: "POST",
        url: ajaxurl,
        data: data,
        success: function (data) {
            if (data != "success") {
                error = 1;
                $("#name").removeClass('has-success');
                $("#name-availability-status").html(data);
                $("#name").addClass('has-error mar-zero');
            }
            else {
                error = 0;
                $("#name").removeClass('has-error mar-zero');
                $("#name-availability-status").html("");
                $("#name").addClass('has-success');
            }
            $("#loaderIcon").hide();
        },
        error: function () {
        }
    });
}
function checkAvailabilityUsername() {
    var $item = $("#username").closest('.form-group');
    $("#loaderIcon").show();
    var action = 'check_availability';
    var username = $("#username").val();
    var data = {action: action, username: username};
    jQuery.ajax({
        type: "POST",
        url: ajaxurl,
        data: data,
        success: function (data) {
            if (data != "success") {
                error = 1;
                $item.removeClass('has-success');
                $("#user-availability-status").html(data);
                $item.addClass('has-error');
            }
            else {
                error = 0;
                $item.removeClass('has-error');
                $("#user-availability-status").html("");
                $item.addClass('has-success');
            }
            $("#loaderIcon").hide();
        },
        error: function () {
        }
    });
}
function checkAvailabilityEmail() {
    $("#loaderIcon").show();
    var action = 'check_availability';
    var email = $("#email").val();
    var data = {action: action, email: email};
    jQuery.ajax({
        type: "POST",
        url: ajaxurl,
        data: data,
        success: function (data) {
            if (data != "success") {
                error = 1;
                $("#email").removeClass('has-success');
                $("#email-availability-status").html(data);
                $("#email").addClass('has-error mar-zero');
            }
            else {
                error = 0;
                $("#email").removeClass('has-error mar-zero');
                $("#email-availability-status").html("");
                $("#email").addClass('has-success');
            }
            $("#loaderIcon").hide();
        },
        error: function () {
        }
    });
}
function checkAvailabilityPassword() {
    var length = $('#password').val().length;
    if (length != 0) {
        var PASSLENG = "{LANG_PASSLENG}";
        if (length < 5 || length > 21) {
            $("#password").removeClass('has-success');
            $("#password-availability-status").html("<span class='status-not-available'>" + PASSLENG + "</span>");
            $("#password").addClass('has-error mar-zero');
        }
        else {
            $("#password").removeClass('has-error');
            $("#password-availability-status").html("<span class='status-available'>Leave blank if don't want to change password.</span>");
            $("#password").addClass('has-success mar-zero');
        }
    }

}
$(window).on('load', function(){
    $('#password').val("");
});

/* 6 */
/* Listing Grid and list view
/* ========================================================================== */


$('#listing-filter').on('click', '#quick-filter li a', function (e) {
    var $item = $(this).closest('a');

    var filtertype = $item.data('filter-type');
    var filterval = $item.data('filter-val');
    $('#input-' + filtertype).val(filterval);
    $('#input-order').val($item.data('order'));
    $('#ListingForm').submit();
});

var s = localStorage.listGrid;
if (s) {
    if (s == 'grid') {
        $('#serchlist .searchresult.grid').fadeIn();
        $('#grid').addClass('active').children('i').addClass('icon-white');
        $('#list').removeClass('active').children('i').removeClass('icon-white');
    } else {
        $('#serchlist .searchresult.list').fadeIn();
        $('#list').addClass('active').children('i').addClass('icon-white');
        $('#grid').removeClass('active').children('i').removeClass('icon-white');
    }
} else {
    $('#serchlist .searchresult:first').show();
}
$('#list').on('click', function (e) {
    e.preventDefault();
    $(this).addClass('active').children('i').addClass('icon-white');
    $('.grid').fadeOut();
    $('.list').fadeIn();
    $('#grid').removeClass('active').children('i').removeClass('icon-white');
    localStorage.listGrid = 'list';
});
$('#grid').on('click', function (e) {
    e.preventDefault();
    $(this).addClass('active').children('i').addClass('icon-white');
    $('.list').fadeOut();
    $('.grid').fadeIn();
    $('#list').removeClass('active').children('i').removeClass('icon-white');
    localStorage.listGrid = 'grid';
});

//Select List get country and city

$('#postadcity').on('change', function() {
    var data = $("#postadcity option:selected").val();
    var custom_data= $("#postadcity").select2('data')[0];
    var latitude = custom_data.latitude;
    var longitude = custom_data.longitude;
    var address = custom_data.text;
});

/* Get and Bind cities */
$('#postadcity').select2({
    ajax: {
        url: ajaxurl + '?action=searchCityFromCountry',
        dataType: 'json',
        delay: 50,
        data: function (params) {
            var query = {
                q: params.term, /* search term */
                page: params.page
            };

            return query;
        },
        processResults: function (data, params) {
            /*
             // parse the results into the format expected by Select2
             // since we are using custom formatting functions we do not need to
             // alter the remote JSON data, except to indicate that infinite
             // scrolling can be used
             */
            params.page = params.page || 1;

            return {
                results: data.items,
                pagination: {
                    more: (params.page * 10) < data.totalEntries
                }
            };
        },
        cache: true
    },
    escapeMarkup: function (markup) { return markup; }, /* let our custom formatter work */
    minimumInputLength: 2,
    templateResult: function (data) {
        return data.text;
    },
    templateSelection: function (data, container) {
        return data.text;
    }
});
/* 6 */
/* Social Share
/* ========================================================================== */
function socialShare() {
    var socialButtonsEnabled = 1;
    if (socialButtonsEnabled == 1) {
        $('head').append($('<link rel="stylesheet" type="text/css">').attr('href', 'https://cdn.jsdelivr.net/jquery.jssocials/1.4.0/jssocials.css'));
        $('head').append($('<link rel="stylesheet" type="text/css">').attr('href', 'https://cdn.jsdelivr.net/jquery.jssocials/1.4.0/jssocials-theme-flat.css'));
        $.getScript("../../assets/plugins/social-share/jssocials.min.js", function (data, textStatus, jqxhr) {
            $(".social-share").jsSocials({
                showLabel: false,
                showCount: false,
                shares: ["email", "twitter", "facebook", "googleplus", "linkedin", "pinterest", "whatsapp"]
            });
        });
    }
}
//  Social Share -------------------------------------------------------------------------------------------------------
if ($(".social-share").length) {
    socialShare();
}
//  Ad Detail Page -------------------------------------------------------------------------------------------------------
$(document).ready(function($) {
    $("#email_contact_seller").on('submit', function(e) {

        e.preventDefault();
        $('#email_contact_seller #post_loading').show();
        var action = $("#email_contact_seller").attr('action');
        var form_data = $(this).serialize();

        $.ajax({
            type: "POST",
            url: ajaxurl+'?action='+action,
            data: form_data,
            success: function (response) {
                if (response == "success") {
                    $('#email_success').show();
                }
                else {
                    $('#email_error').show();
                }
                $('#email_contact_seller #post_loading').hide();
            }
        });
        return false;
    });
});

$('.show-more-button').on('click', function (e) {
    e.preventDefault();
    $(this).toggleClass('active');
    $('.show-more').toggleClass('visible');
    if ($('.show-more').is(".visible")) {
        var el = $('.show-more'),
            curHeight = el.height(),
            autoHeight = el.css('height', 'auto').height();
        el.height(curHeight).animate({
            height: autoHeight
        }, 400);
    } else {
        $('.show-more').animate({
            height: '100px'
        }, 400);
    }
});
//  Countries Page -------------------------------------------------------------------------------------------------------
$('#getCountry').on('click', 'ul li a', function (e) {
    e.stopPropagation();
    e.preventDefault();

    localStorage.Quick_placeText = "";
    localStorage.Quick_PlaceId = "";
    localStorage.Quick_PlaceType = "";
    var url = $(this).attr('href');
    window.location.href = url;
});
//  Dashboard Page -------------------------------------------------------------------------------------------------------
if($('#pageContent').length > 0) {
    (function () {
        $(function () {
            var $preview, editor, mobileToolbar, toolbar, allowedTags;
            Simditor.locale = 'en-US';
            toolbar = ['bold', 'italic', 'underline', 'fontScale', '|', 'ol', 'ul', 'blockquote', 'table', 'link'];
            mobileToolbar = ["bold", "italic", "underline", "ul", "ol"];
            if (mobilecheck()) {
                toolbar = mobileToolbar;
            }
            allowedTags = ['br', 'span', 'a', 'img', 'b', 'strong', 'i', 'strike', 'u', 'font', 'p', 'ul', 'ol', 'li', 'blockquote', 'pre', 'h1', 'h2', 'h3', 'h4', 'hr', 'table'];
            editor = new Simditor({
                textarea: $('#pageContent'),
                placeholder: LANG_AD_DESCRIPTION,
                toolbar: toolbar,
                pasteImage: false,
                defaultImage: siteurl+'includes/assets/plugins/simditor/images/image.png',
                upload: false,
                allowedTags: allowedTags
            });
            $preview = $('#preview');
            if ($preview.length > 0) {
                return editor.on('valuechanged', function (e) {
                    return $preview.html(editor.getValue());
                });
            }
        });
    }).call(this);
}
function NotifyValueChanged() {
    if ($('#notify').is(":checked"))
        $(".skills").show();
    else
        $(".skills").hide();
}

NotifyValueChanged();
//  Membership Plan --------------------------------------
$(document).ready(function () {
    $("img.lazy-load").lazyload({effect:"fadeIn",load:function(){$(this).removeClass('lazy-load');}});

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
});

