(function ($) {
    /* save vcard details */
    $('#newsletter-form').on('submit',function (e) {
        e.preventDefault();
        e.stopPropagation();
        var data = new FormData(this),
            $form = $(this);

        var $btn = $(this).find('.button'),
            $error = $(this).find('.invalid-tooltip');
        $btn.addClass('button-progress').prop('disabled', true);

        $error.hide();
        $.ajax({
            type: "POST",
            url: $form.attr('action'),
            data: data,
            dataType: 'json',
            cache:false,
            contentType: false,
            processData: false,
            success: function (response) {
                $btn.removeClass('button-progress').prop('disabled',false);
                if(response.success){
                    $form.find('.valid-tooltip').removeClass('d-none');

                }else{
                    $error.text(response.message).show();
                }
                setTimeout(function () {
                    $form.find('.valid-tooltip').addClass('d-none');
                    $error.hide();
                    $form.trigger("reset");
                }, 2000);
            },
            error: function (xhr) {
                $btn.removeClass('button-progress').prop('disabled',false);
                $error.text(xhr.responseJSON.message).show();
            },
        });
    });

    $('#js-table-list').on('click', '.item-js-delete', function (e) {
        e.stopPropagation();
        e.preventDefault();
        var action = $(this).data('ajax-action');
        var $item = $(this).closest('.ajax-item-listing');
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            url: action,
            success: function (response) {
                if (response.success) {
                    $item.remove();
                    Snackbar.show({
                        text: response.message,
                        pos: 'bottom-center',
                        showAction: false,
                        actionText: "Dismiss",
                        duration: 3000,
                        textColor: '#fff',
                        backgroundColor: '#383838',
                    });
                }else{
                    Snackbar.show({
                        text: response.message,
                        actionText: '<i class="fas fa-times"></i>',
                        showAction: true,
                        duration: 100000,
                        actionTextColor: '#ffffff',
                        backgroundColor: '#ee5252'});
                }
            }
        });
    });

    $('#js-table-list').on('click', '.item-js-hide', function (e) {
        e.stopPropagation();
        e.preventDefault();
        var action = $(this).data('ajax-action');
        var $item = $(this).closest('.ajax-item-listing');
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            url: action,
            data: {post_id: $item.data('item-id')},
            success: function (response) {
                if (response.type == 1) {
                    $item.addClass('opapcityLight');
                    $item.find('.label-hidden').html(LANG_HIDDEN)
                    $item.find('.item-js-hide').attr('title', LANG_SHOW);
                    $item.find('.item-js-hide').html('<i class="icon-feather-eye"></i>');
                }
                else if (response.type == 2) {
                    $item.removeClass('opapcityLight');
                    $item.find('.label-hidden').html(LANG_SHOW)
                    $item.find('.item-js-hide').attr('title', LANG_HIDE);
                    $item.find('.item-js-hide').html('<i class="icon-feather-eye-off"></i>');
                }

                Snackbar.show({
                    text: response.message,
                    pos: 'bottom-center',
                    showAction: false,
                    actionText: "Dismiss",
                    duration: 3000,
                    textColor: '#fff',
                    backgroundColor: '#383838',
                });
            }
        });
    });

    //Set Favorite Listing
    $('.set-item-fav').on('click', function (e) {
        e.stopPropagation();
        e.preventDefault();

        var post_id = $(this).data('item-id');
        var user_id = $(this).data('userid');
        var action = $(this).data('action');
        var $item = $(this).closest('.fav-listing');
        var $this = $(this);

        if (user_id == 0) {
            //window.location.href = loginurl;
            $('[href="#sign-in-dialog"]').trigger('click');
            return;
        }
        $this.addClass('button-loader');
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            url: action,
            data: {post_id: post_id},
            success: function (response) {
                if(response.success){
                    if (response.action == 'removeFavorite') {
                        $item.remove();
                        var val = $('.fav-ad-count').text();
                        var favcount = val - 1;
                        $('.fav-ad-count').html(favcount);
                    }
                    else {
                        $this.addClass('active');
                    }
                }else{
                    $this.removeClass('active');
                }
                Snackbar.show({
                    text: response.message,
                    pos: 'bottom-center',
                    showAction: false,
                    actionText: "Dismiss",
                    duration: 3000,
                    textColor: '#fff',
                    backgroundColor: '#383838',
                });
                $this.removeClass('button-loader');
            }
        });
    });

    $("#email_contact_seller").on('submit', function(e) {
        e.stopPropagation();
        e.preventDefault();

        $('#email_submit_button').addClass('button-progress').prop('disabled', true);
        var action = $("#email_contact_seller").attr('action');
        var form_data = $(this).serialize();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            url: ajaxurl,
            data: form_data+ '&action=' + action,
            success: function (response) {
                if (response.success) {
                    $('#email_error').hide();
                    $('#email_success').show();
                    $('#ContactSellerFormData').hide();
                }
                else {
                    $('#email_success').hide();
                    $('#email_error').html(response.message);
                    $('#email_error').show();
                }
                $('#email_submit_button').removeClass('button-progress').prop('disabled', false);
            }
        });
        return false;
    });

    // cookie consent
    if (localStorage.getItem('Quick-cookie') != '1') {
        $('.cookieConsentContainer').delay(2000).fadeIn();
    }
    $('.cookieAcceptButton').on('click',function() {
        localStorage.setItem('Quick-cookie','1');
        $('.cookieConsentContainer').fadeOut();
    });

})(this.jQuery);
