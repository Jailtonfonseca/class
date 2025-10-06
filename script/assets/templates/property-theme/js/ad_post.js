$(document).ready(function () {
    // -------------------------------------------------------------
    //  prepare the form when the DOM is ready
    // -------------------------------------------------------------
    $('#post-advertise-form').on('submit', function (e) {
        e.stopPropagation();
        e.preventDefault();

        var error = 0;
        $('.quick-error').hide();
        $('.quick-text').each(function() {
            var $value = $(this).val().trim();
            if($(this).data('req') && $value.length === 0){
                error = 1;
                $(this).siblings('.quick-error').show();
            }
        });
        $('.quick-textArea').each(function() {
            var $value = $(this).val().trim();
            if($(this).data('req') && $value.length === 0){
                error = 1;
                $(this).siblings('.quick-error').show();
            }
        });
        $('.quick-select').each(function() {
            var $value = $(this).val().trim();
            if($(this).data('req') && $value.length === 0){
                error = 1;
                $(this).siblings('.quick-error').show();
            }
        });
        $('.quick-radioCheck').each(function() {
            var $name = $(this).data('name');
            var $value = $('[data-name="'+$name+'"]:checked').map(function () {
                return $(this).val().trim();
            }).get();
            if($(this).data('req') && $value.length === 0){
                error = 1;
                $(this).siblings('.quick-error').show();
            }
        });

        if(!error){
            post_advertise();
        }else{
            $('html, body').animate({
                scrollTop: $("#ResponseCustomFields").offset().top
            }, 2000);
        }
        return false;
    });
});
var payment_uri = '';

function post_advertise() {
    $('#submit_job_button').addClass('button-progress').prop('disabled', true);
    var formdata = new FormData(document.querySelector("#post-advertise-form"));
    // submit the form
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "POST",
        url: $('#post-advertise-form').attr("action"),
        data: formdata,
        cache: false,
        contentType: false,
        processData: false,
        dataType:  'json',
        success: function (data) {
            if (data.status == "error") {
                if (data["errors"].length > 0) {
                    for (var i = 0; i < data["errors"].length; i++) {
                        var $message = data["errors"][i]["message"];
                        if (i == 0) {
                            $('#post_error').html('<span class="status-not-available">! ' + $message + '</span>');
                        } else {
                            $('#post_error .status-not-available').append('<br>! ' + $message);
                        }
                    }
                    $('html, body').animate({
                        scrollTop: $("#post_error").offset().top
                    }, 2000);
                }
                $('#submit_job_button').removeClass('button-progress').prop('disabled', false);
            } else if (data.status == "success") {
                $('#submit_job_button').removeClass('button-progress').prop('disabled', false);
                $('#post_ad_email_exist').fadeOut();
                $('#post_job_form').fadeOut();
                $('.payment-confirmation-page').fadeIn();
                var delay = 2000;
                setTimeout(function () {
                    window.location = data.redirect;
                }, delay);
            } else if (data.status == "email-exist") {
                $('#email_exists_user').hide();
                $('#email_exists_login').show();

                $('#post_ad_email_exist #quickad_email_already_linked').html(data.errors);
                $('#post_ad_email_exist #quickad_username_display').html(data.username);
                $('#post_ad_email_exist #quickad_email_display').html(data.email);
                $('#post_ad_email_exist #username').val(data.username);
                $('#post_ad_email_exist #email').val(data.email);

                $('#post_ad_email_exist').fadeIn();
                $('#submit_job_button').removeClass('button-progress').prop('disabled', false);
            }
        }
    });
    // return false to prevent normal browser submit and page navigation
    return false;
}

$('#post_ad_email_exist .mfp-close, #post_ad_email_exist #change-email').on('click', function (e) {
    $('#post_ad_email_exist').fadeOut();
});

$("#post_ad_email_exist #link_account").on('click', function (event) {
    $('#link_account').addClass('button-progress').prop('disabled', true);
    var action = "ajaxlogin";
    var $formData = {
        action: action,
        username: $("#username").val(),
        password: $("#password").val(),
        is_ajax: 1
    };

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "POST",
        url: ajaxurl,
        data: $formData,
        success: function (response) {
            if (response == "success") {
                $('#post_ad_email_exist #email_exists_success').fadeIn();
                $('#post_ad_email_exist #email_exists_error').html('').fadeOut();

                post_advertise();
            } else {
                $('#post_ad_email_exist #email_exists_error').html('<span class="status-not-available">' + response + '</span>').fadeIn();
                post_advertise();
            }
            $('#link_account').removeClass('button-progress').prop('disabled', false);
        }
    });
    return false;
});

function fillPrice(obj, val) {
    if ($(obj).is(':checked')) {
        var a = $('#totalPrice').text();
        var c = (parseFloat(a) + parseFloat(val)).toFixed(2);
    } else {
        var a = $('#totalPrice').text();
        var c = (parseFloat(a) - parseFloat(val)).toFixed(2);
    }

    $('#ad_total_cost_container').fadeIn();
    if (c == 0) {
        $('#ad_total_cost_container').fadeOut();
    }
    $('#totalPrice').html(c);
}
