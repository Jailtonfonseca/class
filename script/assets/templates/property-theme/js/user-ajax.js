(function ($) {
    "use strict";

    $('.selectpicker').select2();

    $(".selectTwo-input").select2({
        minimumResultsForSearch: Infinity
    });

    $(document).on("change", "input[type=radio][name=looking_for]", (function(e) {
        "rent" === $(e.currentTarget).val() ? $("#price_period").removeClass("hidden").fadeIn() : $("#price_period").addClass("hidden").fadeOut()
    }))

    // -------------------------------------------------------------
    //  Search and post page ajax
    // -------------------------------------------------------------
    $(window).bind("load", function () {
        if ( typeof PostTypeId !== 'undefined' && PostTypeId == null ) {
            getposttypes(Category, "getPostTypes", PostTypeId);
        }
    });

    $(document).on('click', '.looking_for', filterLookingFor);

    $(document).on('change', 'input[type=radio][name=category]', filterPostTypes);
    $(document).on('click', 'input[type=radio][name=category]', filterPostTypes);

    $(document).on('change', '#category', filterPostTypes);
    $(document).on('click', '#category', filterPostTypes);

    $(document).on('change', '#post_types', filterCustomFields);
    $(document).on('click', '#post_types', filterCustomFields);

    function filterLookingFor(){
        $('.looking_for').removeClass('active');
        $(this).addClass('active');
        if ($(this).data('id')) {
            var id = $(this).data('id');
            $('#category_id').val(id);
        }else{
            $('#category_id').val('');
            var id = $(this).val();
        }
    }

    function filterPostTypes(){
        if ($(this).data('id')) {
            var id = $(this).data('id');
        }else{
            var id = $(this).val();
        }

        if ($(this).data('ajax-action')) {
            var action = $(this).data('ajax-action');
        }else{
            var action = "getPostTypes";
        }

        var selectid = $(this).data('selectid');
        getposttypes(id, action, selectid);
    }

    function filterCustomFields(){
        var posttypeid = $(this).val();
        var action = $(this).data('ajax-action');
        var filter = $(this).data('filter');
        var post_id = $(this).data('postid');
        var data = {action: action, filter: filter, posttypeid: posttypeid, post_id: post_id};
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            url: ajaxurl,
            data: data,
            success: function (result) {
                if (result != 0) {
                    $("#ResponseCustomFields").html(result);
                    $('#custom-field-block').show();
                }
                else {
                    $('#custom-field-block').hide();
                    $("#ResponseCustomFields").html('');
                }
                $(".selectpicker").select2();
            }
        });
    }

    function getposttypes(subcatid, action, selectid) {
        var data = {action: action, subcatid: subcatid, selectid: selectid};
        var $select = $("#post_types");
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            url: ajaxurl,
            data: data,
            success: function (result) {
                $select.find('option').not(':first').remove();
                var i;
                for (i = 0; i < result.length; i++) {
                    $select.append('<option value="' + result[i]["id"] + '" data-id="' + result[i]["id"] + '" ' + result[i]["selected_text"] + '>' + result[i]["title"] + '</option>');
                }
                $("#post_types option:first").trigger('click');
            }
        });
    }

    /* Get and Bind cities */
    $('#listingcity').select2({
        ajax: {
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: ajaxurl,
            type: "POST",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                var query = {
                    action: "searchCityFromCountry",
                    country: $("#select_country option:selected").val(),
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
        escapeMarkup: function (markup) {
            return markup;
        },
        minimumInputLength: 2,
        templateResult: function (data) {
            return data.text;
        },
        templateSelection: function (data, container) {
            return data.text;
        }
    });

    $('#listingcity').on('change', function() {
        var data = $("#listingcity option:selected").val();
        var custom_data= $("#listingcity").select2('data')[0];
        var latitude = custom_data.latitude;
        var longitude = custom_data.longitude;
        var address = custom_data.text;
        $('#latitude').val(latitude);
        $('#longitude').val(longitude);
        if (document.getElementById("singleListingMap") !== null && singleListingMap) {
            $("#address-autocomplete").val(address);
            var newLatLng = new L.LatLng(latitude, longitude);
            singleListingMapMarker.setLatLng(newLatLng);
            singleListingMap.flyTo(newLatLng, 10);
        }
    });

    // -------------------------------------------------------------
    //  End Search and post page ajax
    // -------------------------------------------------------------

    $('.wishlist-toggle-check').on('click', function (e) {
        //e.preventDefault();
        var $this = $(this).closest('.set-favorite'),
            $item = $this.closest('.fav-listing'),
            post_id = $this.data('item-id'),
            user_id = $this.data('userid'),
            action = $this.data('action');

        if (user_id == 0) {
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
                    $this.prop("checked", true);
                }else{
                    $this.prop("checked", false);
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
            cache:false,
            contentType: false,
            processData: false,
            success: function (response) {
                $btn.removeClass('button-progress').prop('disabled',false);
                if(response.success){
                    $form.find('.valid-tooltip').removeClass('d-none');
                    $form.find('.valid-tooltip').show();

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
        var $this = $(this),
            action = $this.data('ajax-action'),
            $item = $this.closest('.ajax-item-listing');
        if (confirm(LANG_ARE_YOU_SURE)) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                url: action,
                data: {post_id: $item.data('item-id')},
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
        }
    });

    $('#js-table-list').on('click', '.item-js-hide', function (e) {
        e.stopPropagation();
        e.preventDefault();
        var $this = $(this),
            action = $this.data('ajax-action'),
            $item = $this.closest('.ajax-item-listing');
        if (confirm(LANG_ARE_YOU_SURE)) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                url: action,
                data: {post_id: $item.data('item-id')},
                success: function (response) {
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
                }
            });
        }
    });

    $('.emailContact').on('click', function (e) {
        e.stopPropagation();
        e.preventDefault();
        var post_id = $(this).data('id');
        $('#contactForm #post_id').val(post_id);
        $('#contactForm').modal('show');
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

    //Country popup keyword search
    $(document).on('keyup', '#country-modal-search', function () {
        var searchTerm = $(this).val().toLowerCase();
        $('#countries').find('li').each(function () {
            if ($(this).filter(function() {
                return $(this).attr('data-name').toLowerCase().indexOf(searchTerm) > -1;
            }).length > 0 || searchTerm.length < 1) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    });
    //Country popup keyword search
})(this.jQuery);